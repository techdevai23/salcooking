// Descargar la ficha de receta en formato PDF
function descargarFichaRecetaPDF(nombreArchivo, tituloReceta) {
  // 1. Verificar que jsPDF y autoTable estén cargados
  if (typeof window.jspdf === 'undefined' || typeof window.jspdf.jsPDF === 'undefined') {
      alert("jsPDF no cargado.");
      console.error("jsPDF no está definido en window.jspdf");
      return;
  }
  const { jsPDF } = window.jspdf;

  // Configuración inicial del documento
  const doc = new jsPDF({
      orientation: 'portrait',
      unit: 'mm',
      format: 'a4'
  });
  
  // Configuración de márgenes y dimensiones
  const marginLeft = 20;
  const marginRight = 20;
  const marginTop = 20;
  const pageWidth = doc.internal.pageSize.getWidth();
  const pageHeight = doc.internal.pageSize.getHeight();
  const contentWidth = pageWidth - marginLeft - marginRight;
  
  // Configuración de estilos
  const lineHeightSmall = 5;
  const lineHeightDefault = 6;
  const sectionSpacing = 10;

  if (typeof doc.autoTable !== 'function') {
      alert("El plugin jsPDF-AutoTable no está cargado o no está correctamente adjunto a la instancia de jsPDF.");
      console.error("doc.autoTable no es una función.");
      return;
  }

  let yPos = marginTop;
  
  // --- Función auxiliar para limpiar texto de emojis ---
  function limpiarEmojis(texto) {
      if (typeof texto !== 'string') return '';
      return texto.replace(/[⏱️🍽️🛒👨‍🍳♻️⚠️💊]/g, '').trim();
  }

  // --- Función auxiliar para verificar y añadir página si es necesario ---
  function checkAndAddPage(currentY, spaceNeeded) {
      if (currentY + spaceNeeded > pageHeight - marginBottom) {
          doc.addPage();
          return 20;
      }
      return currentY;
  }

    // --- Título de la Receta ---
  yPos = checkAndAddPage(yPos, 15);
  doc.setFontSize(18);
  doc.setFont(undefined, 'bold');
  doc.setTextColor(0, 0, 0); // Texto en negro
  doc.text(tituloReceta, marginLeft, yPos, { maxWidth: contentWidth });
  yPos += 10;
  
  // Línea divisoria
  doc.setDrawColor(200, 200, 200);
  doc.setLineWidth(0.3);
  doc.line(marginLeft, yPos, pageWidth - marginRight, yPos);
  yPos += 10;
  
  doc.setFont(undefined, 'normal');

  // --- Tiempo de Preparación y Porciones ---
  let tiempoPrep = '';
  let porciones = '';
  
  // Obtener tiempo y porciones directamente de los elementos
  const tiempoElement = document.querySelector('.foto p');
  if (tiempoElement) {
      const tiempoText = tiempoElement.textContent;
      const lineas = tiempoText.split('\n').map(linea => linea.trim()).filter(linea => linea);
      
      if (lineas.length >= 2) {
          tiempoPrep = lineas[0].replace('Tiempo:', '').trim();
          porciones = lineas[1].replace('Porciones:', '').trim();
      }
  }

  // Información de tiempo y porciones
  doc.setFontSize(11);
  
  if (tiempoPrep) {
      yPos = checkAndAddPage(yPos, lineHeightDefault);
      doc.text(limpiarEmojis('Tiempo: ' + tiempoPrep), marginLeft, yPos);
      yPos += lineHeightDefault;
  }
  if (porciones) {
      yPos = checkAndAddPage(yPos, lineHeightDefault);
      doc.text(limpiarEmojis('Porciones: ' + porciones), marginLeft, yPos);
      yPos += sectionSpacing + 5;
  }

  // --- Ingredientes ---
  const ingredientesSection = Array.from(document.querySelectorAll('.texto h3')).find(h3 => 
      h3.textContent.trim().toLowerCase().includes('ingredientes')
  );
  
  const tableRowsIng = [];
  
  if (ingredientesSection) {
      let nextElement = ingredientesSection.nextElementSibling;
      while (nextElement && nextElement.tagName !== 'H3') {
          if (nextElement.tagName === 'UL') {
              const items = nextElement.querySelectorAll('li');
              items.forEach(item => {
                  tableRowsIng.push([`• ${limpiarEmojis(item.textContent.trim())}`]);
              });
              break;
          }
          nextElement = nextElement.nextElementSibling;
      }
  }

  // Título de Ingredientes
  yPos = checkAndAddPage(yPos, 15);
  doc.setFontSize(14);
  doc.setFont(undefined, 'bold');
  doc.text('INGREDIENTES', marginLeft, yPos);
  yPos += 8;
  
  // Línea sutil
  doc.setDrawColor(0, 0, 0);
  doc.setLineWidth(0.3);
  doc.line(marginLeft, yPos, marginLeft + 35, yPos);
  yPos += 10;

  // Lista de ingredientes
  if (tableRowsIng.length > 0) {
      doc.setFontSize(11);
      doc.setFont(undefined, 'normal');
      
      tableRowsIng.forEach((row, index) => {
          yPos = checkAndAddPage(yPos, lineHeightDefault);
          doc.text(row[0], marginLeft + 5, yPos);
          yPos += lineHeightDefault;
      });
      
      yPos += 5;
  } else {
      yPos = checkAndAddPage(yPos, lineHeightSmall);
      doc.setFontSize(10);
      doc.text("No hay ingredientes especificados.", marginLeft + 5, yPos);
      yPos += lineHeightSmall + 5;
  }
  
  // Espaciado entre secciones
  yPos += 5;

  // --- Instrucciones ---
  const instruccionesSection = Array.from(document.querySelectorAll('.texto h3')).find(h3 => 
      h3.textContent.trim().toLowerCase().includes('instrucciones')
  );
  
  // Sección de Instrucciones
  yPos = checkAndAddPage(yPos, 15);
  doc.setFontSize(14);
  doc.setFont(undefined, 'bold');
  doc.text('INSTRUCCIONES', marginLeft, yPos);
  yPos += 8;
  
  // Línea sutil
  doc.setDrawColor(0, 0, 0);
  doc.setLineWidth(0.3);
  doc.line(marginLeft, yPos, marginLeft + 40, yPos);
  yPos += 10;

  if (instruccionesSection) {
      let instruccionesElement = instruccionesSection.nextElementSibling;
      // Buscar el siguiente elemento que sea un párrafo
      while (instruccionesElement && instruccionesElement.tagName !== 'P') {
          instruccionesElement = instruccionesElement.nextElementSibling;
      }
      
      if (instruccionesElement) {
          doc.setFontSize(11);
          doc.setFont(undefined, 'normal');
          
          let instruccionesTexto = limpiarEmojis(instruccionesElement.textContent.trim());
          // Reemplazar saltos de línea múltiples por un solo salto
          instruccionesTexto = instruccionesTexto.replace(/\n\s*\n/g, '\n\n');
          
          // Dividir por párrafos
          const parrafos = instruccionesTexto.split('\n\n');
          
          parrafos.forEach(parrafo => {
              if (parrafo.trim() === '') return;
              
              const lineas = doc.splitTextToSize(parrafo.trim(), contentWidth - 10);
              for (let i = 0; i < lineas.length; i++) {
                  yPos = checkAndAddPage(yPos, lineHeightSmall);
                  doc.text(lineas[i], marginLeft + 5, yPos, { align: 'justify' });
                  yPos += lineHeightSmall + 1;
              }
              // Espacio entre párrafos
              yPos += 3;
          });
      } else {
          doc.setFontSize(10);
          doc.text("No se encontró el texto de instrucciones.", marginLeft + 5, yPos);
          yPos += lineHeightSmall;
      }
  } else {
      doc.setFontSize(10);
      doc.text("No se encontró la sección de instrucciones.", marginLeft + 5, yPos);
      yPos += lineHeightSmall;
  }
  
  // Línea decorativa
  doc.setDrawColor(80, 166, 101);
  doc.setLineWidth(0.5);
  doc.line(marginLeft, yPos - 3, pageWidth - marginRight, yPos - 3);
  yPos += 10;

  // --- Función auxiliar para añadir una sección con título y lista de items de texto ---
  function addSectionWithTextList(title, listElement, currentYPos) {
      let newYPos = currentYPos;
      
      // Estilo del título de la sección
      newYPos = checkAndAddPage(newYPos, 15);
      doc.setFontSize(14);
      doc.setFont(undefined, 'bold');
      doc.setTextColor(14, 124, 84); // Verde oscuro corporativo
      doc.text(title, marginLeft, newYPos);
      newYPos += 10;
      
      // Estilo del contenido
      doc.setFont(undefined, 'normal');
      doc.setFontSize(10);
      doc.setTextColor(45, 62, 46); // Negro verdoso
      
      if (listElement) {
          const items = listElement.getElementsByTagName('li');
          if (items.length > 0 && !(items.length === 1 && limpiarEmojis(items[0].innerText.trim()).toLowerCase().includes("ninguna"))) {
              for (let i = 0; i < items.length; i++) {
                  const itemText = "• " + limpiarEmojis(items[i].innerText.trim());
                  const splitItemText = doc.splitTextToSize(itemText, contentWidth - 10);
                  
                  for (let j = 0; j < splitItemText.length; j++) {
                      newYPos = checkAndAddPage(newYPos, lineHeightSmall);
                      doc.text(splitItemText[j], marginLeft + (j > 0 ? 10 : 5), newYPos);
                      newYPos += lineHeightSmall + 1;
                  }
              }
          } else {
              newYPos = checkAndAddPage(newYPos, lineHeightSmall);
              doc.text("No especificado.", marginLeft + 5, newYPos);
              newYPos += lineHeightSmall + 2;
          }
      } else {
          newYPos = checkAndAddPage(newYPos, lineHeightSmall);
          doc.text("Información no disponible.", marginLeft + 5, newYPos);
          newYPos += lineHeightSmall + 2;
      }
      
      // Línea decorativa
      doc.setDrawColor(80, 166, 101);
      doc.setLineWidth(0.5);
      doc.line(marginLeft, newYPos - 3, pageWidth - marginRight, newYPos - 3);
      
      return newYPos + 10;
  }

  // --- Sustitutos ---
  const sustitutosSection = document.querySelector('.texto h3:contains("Sustitutos"), .texto h3:contains("sustitutos")');
  
  if (sustitutosSection) {
      const sustitutosContent = sustitutosSection.nextElementSibling;
      if (sustitutosContent && sustitutosContent.tagName === 'P') {
          // Sección de Sustitutos
          yPos = checkAndAddPage(yPos, 15);
          doc.setFontSize(14);
          doc.setFont(undefined, 'bold');
          doc.setTextColor(14, 124, 84); // Verde oscuro corporativo
          doc.text('Sustitutos', marginLeft, yPos);
          yPos += 10;
          
          // Contenido de sustitutos
          doc.setFontSize(10);
          doc.setFont(undefined, 'normal');
          doc.setTextColor(45, 62, 46); // Negro verdoso
          
          const sustitutosText = limpiarEmojis(sustitutosContent.innerText.trim());
          if (sustitutosText) {
              const splitSustitutos = doc.splitTextToSize(sustitutosText, contentWidth - 10);
              for (let i = 0; i < splitSustitutos.length; i++) {
                  yPos = checkAndAddPage(yPos, lineHeightSmall);
                  doc.text(splitSustitutos[i], marginLeft + 5, yPos, { align: 'justify' });
                  yPos += lineHeightSmall + 1;
              }
              yPos += 3;
          } else {
              doc.text("No se especificaron sustitutos.", marginLeft + 5, yPos);
              yPos += lineHeightSmall;
          }
          
          // Línea decorativa
          doc.setDrawColor(80, 166, 101);
          doc.setLineWidth(0.5);
          doc.line(marginLeft, yPos - 3, pageWidth - marginRight, yPos - 3);
          yPos += 10;
      }
  }

  // --- Alergias ---
  const alergiasSection = Array.from(document.querySelectorAll('.texto h3')).find(h3 => 
      h3.textContent.trim().toLowerCase().includes('alergias')
  );
  
  if (alergiasSection) {
      let nextElement = alergiasSection.nextElementSibling;
      while (nextElement && nextElement.tagName !== 'H3') {
          if (nextElement.tagName === 'UL') {
              yPos = addSectionWithTextList('ALERGIAS', nextElement, yPos);
              break;
          }
          nextElement = nextElement.nextElementSibling;
      }
  }
  
  // --- Enfermedades ---
  const enfermedadesSection = Array.from(document.querySelectorAll('.texto h3')).find(h3 => 
      h3.textContent.trim().toLowerCase().includes('enfermedad')
  );
  
  if (enfermedadesSection) {
      let nextElement = enfermedadesSection.nextElementSibling;
      while (nextElement && nextElement.tagName !== 'H3') {
          if (nextElement.tagName === 'UL') {
              yPos = addSectionWithTextList('INFORMACIÓN SOBRE ENFERMEDADES', nextElement, yPos);
              break;
          }
          nextElement = nextElement.nextElementSibling;
      }
  }
  
  // --- Sustitutos ---
  const sustitutosSection = Array.from(document.querySelectorAll('.texto h3')).find(h3 => 
      h3.textContent.trim().toLowerCase().includes('sustitutos')
  );
  
  if (sustitutosSection) {
      let nextElement = sustitutosSection.nextElementSibling;
      while (nextElement && nextElement.tagName !== 'H3') {
          if (nextElement.tagName === 'P') {
              const sustitutosTexto = limpiarEmojis(nextElement.textContent.trim());
              if (sustitutosTexto) {
                  yPos = checkAndAddPage(yPos, 15);
                  doc.setFontSize(14);
                  doc.setFont(undefined, 'bold');
                  doc.text('SUSTITUTOS', marginLeft, yPos);
                  yPos += 8;
                  
                  // Línea sutil
                  doc.setDrawColor(0, 0, 0);
                  doc.setLineWidth(0.3);
                  doc.line(marginLeft, yPos, marginLeft + 35, yPos);
                  yPos += 10;
                  
                  doc.setFontSize(11);
                  doc.setFont(undefined, 'normal');
                  
                  const lineas = doc.splitTextToSize(sustitutosTexto, contentWidth - 10);
                  for (let i = 0; i < lineas.length; i++) {
                      yPos = checkAndAddPage(yPos, lineHeightSmall);
                      doc.text(lineas[i], marginLeft + 5, yPos, { align: 'justify' });
                      yPos += lineHeightSmall + 1;
                  }
              }
              break;
          }
          nextElement = nextElement.nextElementSibling;
      }
  }

  // Pie de página
  yPos = checkAndAddPage(yPos, 15);
  doc.setDrawColor(200, 200, 200);
  doc.setLineWidth(0.3);
  doc.line(marginLeft, yPos, pageWidth - marginRight, yPos);
  yPos += 5;
  
  doc.setFontSize(8);
  doc.setTextColor(100, 100, 100);
  doc.text('Receta generada desde SalCooking', marginLeft, yPos);
  
  // Fecha de generación
  const today = new Date();
  const dateString = today.toLocaleDateString('es-ES', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
  });
  doc.text(`Generado el ${dateString}`, pageWidth - marginRight, yPos, { align: 'right' });

  // Guardar el PDF
  doc.save(nombreArchivo);
}