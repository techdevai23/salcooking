// Descargar la ficha de receta en formato PDF
function descargarFichaRecetaPDF(nombreArchivo, tituloReceta) {
  // 1. Verificar que jsPDF y autoTable estén cargados
  if (typeof window.jspdf === 'undefined' || typeof window.jspdf.jsPDF === 'undefined') {
      alert("jsPDF no cargado.");
      console.error("jsPDF no está definido en window.jspdf");
      return;
  }
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  if (typeof doc.autoTable !== 'function') {
      alert("El plugin jsPDF-AutoTable no está cargado o no está correctamente adjunto a la instancia de jsPDF.");
      console.error("doc.autoTable no es una función.");
      return;
  }

  let yPos = 20;
  const pageHeight = doc.internal.pageSize.height;
  const pageWidth = doc.internal.pageSize.width;
  const marginLeft = 14;
  const marginRight = 14;
  const contentWidth = pageWidth - marginLeft - marginRight;
  const marginBottom = 20;
  const lineHeightDefault = 6;
  const lineHeightSmall = 5;
  const sectionSpacing = 8;

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
  yPos = checkAndAddPage(yPos, 10);
  doc.setFontSize(18);
  doc.setFont(undefined, 'bold');
  doc.text(tituloReceta, marginLeft, yPos); // Asumimos que tituloReceta ya viene limpio o no tiene emojis
  yPos += 10;
  doc.setFont(undefined, 'normal');

  // --- Tiempo de Preparación y Porciones ---
  // Buscar el texto de tiempo y porciones en el primer <div class="foto"> > <p>
  let tiempoPrep = '';
  let porciones = '';
  const fotoDiv = document.querySelector('.foto p');
  if (fotoDiv) {
      const texto = fotoDiv.innerText;
      // Buscar "Tiempo: XX minutos" y "Porciones: YY"
      const tiempoMatch = texto.match(/Tiempo:\s*([^\n]+)/);
      const porcionesMatch = texto.match(/Porciones:\s*([^\n]+)/);
      if (tiempoMatch) tiempoPrep = tiempoMatch[1].trim();
      if (porcionesMatch) porciones = porcionesMatch[1].trim();
  }

  doc.setFontSize(10);
  if (tiempoPrep) {
      yPos = checkAndAddPage(yPos, lineHeightDefault);
      doc.text(limpiarEmojis('Tiempo: ' + tiempoPrep), marginLeft, yPos);
      yPos += lineHeightDefault;
  }
  if (porciones) {
      yPos = checkAndAddPage(yPos, lineHeightDefault);
      doc.text(limpiarEmojis('Porciones: ' + porciones), marginLeft, yPos);
      yPos += sectionSpacing;
  }

  // --- Ingredientes ---
  // Buscar el primer <h3>Ingredientes</h3> seguido de <ul>
  let ingredientesLista = null;
  const h3s = document.querySelectorAll('.texto h3');
  h3s.forEach(h3 => {
      if (h3.textContent.trim().toLowerCase().includes('ingredientes')) {
          const nextUl = h3.nextElementSibling;
          if (nextUl && nextUl.tagName === 'UL') {
              ingredientesLista = nextUl;
          }
      }
  });
  const tableRowsIng = [];
  if (ingredientesLista) {
      const items = ingredientesLista.getElementsByTagName('li');
      for (let i = 0; i < items.length; i++) {
          tableRowsIng.push([limpiarEmojis(items[i].innerText.trim())]);
      }
  }

  if (tableRowsIng.length > 0) {
      doc.autoTable({
          body: tableRowsIng,
          startY: yPos,
          theme: 'plain',
          styles: { fontSize: 9, cellPadding: 1.5, overflow: 'linebreak' },
          columnStyles: { 0: { cellWidth: contentWidth } },
          margin: { left: marginLeft, right: marginRight },
      });
      yPos = doc.lastAutoTable.finalY + sectionSpacing;
  } else {
      yPos = checkAndAddPage(yPos, lineHeightSmall);
      doc.text("No hay ingredientes especificados.", marginLeft, yPos);
      yPos += lineHeightSmall + sectionSpacing;
  }

  // --- Instrucciones ---
  // Buscar el primer <h3>Instrucciones</h3> seguido de <p>
  let instruccionesElement = null;
  h3s.forEach(h3 => {
      if (h3.textContent.trim().toLowerCase().includes('instrucciones')) {
          const nextP = h3.nextElementSibling;
          if (nextP && nextP.tagName === 'P') {
              instruccionesElement = nextP;
          }
      }
  });
  if (instruccionesElement) {
      let instruccionesTexto = limpiarEmojis(instruccionesElement.innerText.trim());
      const splitText = doc.splitTextToSize(instruccionesTexto, contentWidth);
      for (let i = 0; i < splitText.length; i++) {
          yPos = checkAndAddPage(yPos, lineHeightSmall);
          doc.text(splitText[i], marginLeft, yPos);
          yPos += lineHeightSmall;
      }
      yPos += sectionSpacing - lineHeightSmall;
  } else {
      yPos = checkAndAddPage(yPos, lineHeightSmall);
      doc.text("No hay instrucciones especificadas.", marginLeft, yPos);
      yPos += lineHeightSmall;
  }
  yPos += sectionSpacing;

  // --- Función auxiliar para añadir una sección con título y lista de items de texto ---
  function addSectionWithTextList(title, listElement, currentYPos) {
      let newYPos = currentYPos;
      newYPos = checkAndAddPage(newYPos, lineHeightDefault + sectionSpacing);
      doc.setFontSize(12);
      doc.setFont(undefined, 'bold');
      doc.text(title, marginLeft, newYPos);
      newYPos += 7;
      doc.setFont(undefined, 'normal');
      doc.setFontSize(9);
      if (listElement) {
          const items = listElement.getElementsByTagName('li');
          if (items.length > 0 && !(items.length === 1 && limpiarEmojis(items[0].innerText.trim()).toLowerCase().includes("ninguna"))) {
              for (let i = 0; i < items.length; i++) {
                  const itemText = "• " + limpiarEmojis(items[i].innerText.trim());
                  const splitItemText = doc.splitTextToSize(itemText, contentWidth - 2);
                  for (let j = 0; j < splitItemText.length; j++) {
                      newYPos = checkAndAddPage(newYPos, lineHeightSmall);
                      doc.text(splitItemText[j], marginLeft + (j > 0 ? 2 : 0), newYPos);
                      newYPos += lineHeightSmall;
                  }
              }
          } else {
              newYPos = checkAndAddPage(newYPos, lineHeightSmall);
              doc.text("No especificado.", marginLeft + 2, newYPos);
              newYPos += lineHeightSmall;
          }
      } else {
          newYPos = checkAndAddPage(newYPos, lineHeightSmall);
          doc.text("Sección no encontrada en la página.", marginLeft + 2, newYPos);
          newYPos += lineHeightSmall;
      }
      return newYPos + sectionSpacing;
  }

  // --- Sustitutos ---
  // Buscar <h3>Sustitutos usados</h3> seguido de <p>
  let sustitutosTitleElement = null;
  let sustitutosContentElement = null;
  h3s.forEach(h3 => {
      if (h3.textContent.trim().toLowerCase().includes('sustitutos')) {
          sustitutosTitleElement = h3;
          const nextP = h3.nextElementSibling;
          if (nextP && nextP.tagName === 'P') {
              sustitutosContentElement = nextP;
          }
      }
  });

  if (sustitutosTitleElement && sustitutosContentElement) {
      yPos = checkAndAddPage(yPos, lineHeightDefault + sectionSpacing);
      doc.setFontSize(12);
      doc.setFont(undefined, 'bold');
      doc.text(limpiarEmojis(sustitutosTitleElement.innerText.trim()), marginLeft, yPos); // CORREGIDO
      yPos += 7;
      doc.setFont(undefined, 'normal');
      doc.setFontSize(9);

      const sustitutosText = limpiarEmojis(sustitutosContentElement.innerText.trim()); // CORREGIDO
      if (sustitutosText) {
          const splitSustitutos = doc.splitTextToSize(sustitutosText, contentWidth);
          for (let i = 0; i < splitSustitutos.length; i++) {
              yPos = checkAndAddPage(yPos, lineHeightSmall);
              doc.text(splitSustitutos[i], marginLeft, yPos);
              yPos += lineHeightSmall;
          }
      } else {
          yPos = checkAndAddPage(yPos, lineHeightSmall);
          doc.text("No especificado.", marginLeft, yPos);
          yPos += lineHeightSmall;
      }
      yPos += sectionSpacing;
  }

  // --- Alergias ---
  // Buscar <h3>Alergias</h3> seguido de <ul>
  let alergiasLista = null;
  h3s.forEach(h3 => {
      if (h3.textContent.trim().toLowerCase().includes('alergias')) {
          const nextUl = h3.nextElementSibling;
          if (nextUl && nextUl.tagName === 'UL') {
              alergiasLista = nextUl;
          }
      }
  });
  // --- Enfermedades ---
  // Buscar <h3>Información sobre enfermedades:</h3> seguido de <ul>
  let enfermedadesLista = null;
  h3s.forEach(h3 => {
      if (h3.textContent.trim().toLowerCase().includes('enfermedades')) {
          const nextUl = h3.nextElementSibling;
          if (nextUl && nextUl.tagName === 'UL') {
              enfermedadesLista = nextUl;
          }
      }
  });

  yPos = addSectionWithTextList("Alergias Asociadas:", alergiasLista, yPos);
  yPos = addSectionWithTextList("Indicaciones para Enfermedades:", enfermedadesLista, yPos);

  // --- Guardar el PDF ---
  doc.save(nombreArchivo);
}