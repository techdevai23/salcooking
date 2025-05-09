// scripts/descargarListaPDF.js
function descargarListaPDF(nombreArchivo, tituloLista) {
  const listaElement = document.getElementById('lista-para-descargar');
  if (!listaElement) {
      alert('No hay lista para descargar: Elemento con ID "lista-para-descargar" no encontrado.'); // Mensaje más específico
      return;
  }

  const items = listaElement.querySelectorAll('.ingrediente-item');
  if (items.length === 0) {
      alert('La lista de ingredientes está vacía.');
      return;
  }

  // Cambio 1: Verificar window.jspdf y window.jspdf.jsPDF
  if (typeof window.jspdf === 'undefined' || typeof window.jspdf.jsPDF === 'undefined') {
    alert("La librería jsPDF (objeto global jspdf o jspdf.jsPDF) no está cargada.");
    console.error("Error: window.jspdf o window.jspdf.jsPDF no está definido.");
    return;
  }

  // Cambio 2: Acceder a jsPDF desde el objeto global window.jspdf
  const { jsPDF } = window.jspdf; // Para la versión UMD de jsPDF
  const doc = new jsPDF(); // Ahora esto debería funcionar si la librería UMD está cargada

  // Cambio 3: Verificar el plugin autoTable en el prototipo de la instancia de jsPDF CREADA
  // Esto es más robusto que verificarlo directamente en jsPDF.prototype antes de la instancia.
  // Sin embargo, el error típico es que jsPDF.prototype.autoTable no existe.
  if (typeof doc.autoTable !== 'function') {
    alert("El plugin jsPDF-AutoTable no está adjunto a la instancia de jsPDF (doc.autoTable no es una función).");
    console.error("Error: doc.autoTable no es una función. Revisa la carga del plugin AutoTable.");
    return;
  }
  // La verificación duplicada de jsPDF.prototype.autoTable se puede quitar si la anterior funciona
  // if (typeof jsPDF.prototype.autoTable === 'undefined') { // Esta línea es redundante si la de arriba funciona
  //      alert("El plugin jsPDF-AutoTable no está cargado. Asegúrate de incluirlo después de jsPDF.");
  //      console.error("jsPDF.autoTable no está definido.");
  //      return;
  // }


  doc.setFontSize(18);
  doc.text(tituloLista, 14, 20);

  const tableColumn = ["Ingrediente", "Cantidad", "Unidad"];
  const tableRows = [];

  items.forEach(item => {
      const nombre = item.querySelector('.ingrediente-nombre').textContent;
      const cantidadCompleta = item.querySelector('.ingrediente-cantidad').textContent.trim();
      const match = cantidadCompleta.match(/^([\d.,]+)\s*(.*)$/);
      let cantidadNum = cantidadCompleta;
      let unidad = "";

      if (match) {
          cantidadNum = match[1];
          unidad = match[2];
      }
      tableRows.push([nombre, cantidadNum, unidad]);
  });

  doc.autoTable({
      head: [tableColumn],
      body: tableRows,
      startY: 30,
      theme: 'striped',
      headStyles: {
          fillColor: [76, 175, 80],
          textColor: [255, 255, 255],
          fontStyle: 'bold'
      },
      styles: {
          font: 'helvetica',
      },
      columnStyles: {
          0: { cellWidth: 'auto' },
          1: { cellWidth: 30, halign: 'right' },
          2: { cellWidth: 30, halign: 'left' }
      }
  });

  doc.save(nombreArchivo);
}