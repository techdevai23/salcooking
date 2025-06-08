/**
 * Descarga la ficha de receta en formato PDF usando captura de pantalla
 * @param {string} nombreArchivo - Nombre base del archivo PDF a descargar
 * @param {string} nombreReceta - Nombre de la receta para el nombre del archivo
 */
async function descargarFichaRecetaPDF(nombreArchivo, nombreReceta) {
    // ===== PUNTOS DE DEPURACIÓN =====
    console.log('===== [1] INICIO - NUEVA VERSIÓN DE DESCARGAR PDF =====');
    console.log('Parámetros recibidos:', { nombreArchivo, nombreReceta });
    console.log('window.jspdf:', window.jspdf);
    console.log('html2canvas:', typeof html2canvas);
    
    // Verificar que html2canvas esté disponible
    if (typeof html2canvas === 'undefined') {
        const errorMsg = 'Error: La biblioteca html2canvas no está cargada.';
        console.error(errorMsg);
        alert(errorMsg);
        return;
    }

    // Verificar que jsPDF esté disponible (usando la versión UMD)
    if (typeof window.jspdf === 'undefined' || typeof window.jspdf.jsPDF === 'undefined') {
        const errorMsg = 'Error: La biblioteca jsPDF no está cargada correctamente.';
        console.error(errorMsg, { jspdf: window.jspdf });
        alert(errorMsg);
        return;
    }
    
    // Obtener la referencia a jsPDF
    const { jsPDF } = window.jspdf;
    console.log('Librerías cargadas correctamente');

    // Variables para restaurar el DOM
    let header, footer, headerDisplay, footerDisplay, loadingMessage;
    
    // Verificar si el documento está listo
    console.log('[2] Estado del documento:', document.readyState);
    if (document.readyState !== 'complete') {
        console.warn('[2.1] Documento no está completamente cargado');
        await new Promise(resolve => {
            window.addEventListener('load', resolve, { once: true });
        });
        console.log('[2.2] Documento completamente cargado');
    }
    
    console.log('[3] Variables inicializadas');
    
    try {
        console.log('[4] Buscando elementos del DOM...');
        // Obtener referencias al header y footer
        header = document.querySelector('header');
        footer = document.querySelector('footer');
        console.log('[5] Elementos encontrados:', { 
            header: header ? 'Encontrado' : 'No encontrado',
            footer: footer ? 'Encontrado' : 'No encontrado'
        });
        
        if (!header) console.warn('No se encontró el elemento header');
        if (!footer) console.warn('No se encontró el elemento footer');
        
        // Guardar los estilos actuales
        headerDisplay = header ? header.style.display : '';
        footerDisplay = footer ? footer.style.display : '';
        console.log('[6] Estilos guardados:', { headerDisplay, footerDisplay });
        
        // Ocultar header y footer temporalmente
        if (header) {
            console.log('[7] Ocultando header');
            header.style.display = 'none';
        }
        if (footer) {
            console.log('[8] Ocultando footer');
            footer.style.display = 'none';
        }
        
        // Esperar un momento para que se actualice el DOM
        console.log('[9] Esperando actualización del DOM...');
        await new Promise(resolve => {
            setTimeout(() => {
                console.log('[10] Tiempo de espera del DOM completado');
                resolve();
            }, 100);
        });
        
        // Seleccionar el contenedor principal de la receta
        console.log('[11] Buscando elemento .contenido-filosofia');
        const element = document.querySelector('.contenido-filosofia');
        console.log('[12] Elemento de contenido:', element ? 'Encontrado' : 'No encontrado');
        
        if (!element) {
            const errorMsg = 'Error: No se pudo encontrar el elemento .contenido-filosofia';
            console.error('[ERROR]', errorMsg);
            console.log('[DEBUG] Contenido de document.body:', document.body.innerHTML.substring(0, 500) + '...');
            throw new Error(errorMsg);
        }
        
        console.log('[13] Contenido del elemento a capturar:', {
            height: element.offsetHeight,
            width: element.offsetWidth,
            scrollHeight: element.scrollHeight,
            scrollWidth: element.scrollWidth
        });
        
        // Configuración del PDF
        const pdf = new jsPDF('p', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const margin = 10; // margen en mm
        const contentWidth = pageWidth - (2 * margin);
        const contentHeight = pageHeight - (2 * margin);

        // Capturar todo el contenido como una sola imagen
        console.log('[13] Capturando todo el contenido como una sola imagen...');
        loadingMessage = document.createElement('div');
        loadingMessage.textContent = 'Generando PDF, por favor espere...';
        loadingMessage.style.position = 'fixed';
        loadingMessage.style.top = '50%';
        loadingMessage.style.left = '50%';
        loadingMessage.style.transform = 'translate(-50%, -50%)';
        loadingMessage.style.background = 'rgba(0, 0, 0, 0.8)';
        loadingMessage.style.color = 'white';
        loadingMessage.style.padding = '20px';
        loadingMessage.style.borderRadius = '5px';
        loadingMessage.style.zIndex = '9999';
        document.body.appendChild(loadingMessage);

        try {
            const canvas = await html2canvas(element, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                logging: true,
                backgroundColor: '#fff',
                onclone: (clonedDoc) => {
                    const style = document.createElement('style');
                    style.textContent = `
                        .contenido-filosofia {
                            margin: 0 !important;
                            padding: 20px !important;
                            box-shadow: none !important;
                            width: 100% !important;
                            max-width: 100% !important;
                            box-sizing: border-box !important;
                            background: white !important;
                        }
                        .contenido-filosofia * {
                            max-width: 100% !important;
                            font-size: 95% !important;
                            line-height: 1.3 !important;
                        }
                        .contenido-filosofia img {
                            max-height: 120mm !important;
                            width: auto !important;
                            margin: 0 auto !important;
                            display: block !important;
                        }
                        @media print {
                            @page { margin: 0; size: A4; }
                            body { margin: 1.6cm; }
                        }
                    `;
                    clonedDoc.head.appendChild(style);
                }
            });

            // Calcular el tamaño de la imagen en mm
            const imgWidth = contentWidth;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            const pageHeightPx = (pageHeight - 2 * margin) * (canvas.width / imgWidth); // alto de página en px

            let position = 0;
            let pageNum = 1;
            while (position < canvas.height) {
                // Crear un canvas temporal para cada página
                const pageCanvas = document.createElement('canvas');
                pageCanvas.width = canvas.width;
                pageCanvas.height = Math.min(pageHeightPx, canvas.height - position);
                const ctx = pageCanvas.getContext('2d');
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, pageCanvas.width, pageCanvas.height);
                ctx.drawImage(
                    canvas,
                    0, position, pageCanvas.width, pageCanvas.height, // origen
                    0, 0, pageCanvas.width, pageCanvas.height // destino
                );
                const imgData = pageCanvas.toDataURL('image/png');
                if (pageNum > 1) pdf.addPage();
                pdf.addImage(imgData, 'PNG', margin, margin, imgWidth, (pageCanvas.height * imgWidth) / pageCanvas.width);
                position += pageHeightPx;
                pageNum++;
            }

            if (loadingMessage && loadingMessage.parentNode) {
                loadingMessage.parentNode.removeChild(loadingMessage);
            }

            // Generar nombre de archivo con el nombre de la receta si está disponible
            let nombreArchivoFinal = 'receta.pdf';
            if (nombreReceta) {
                const nombreLimpio = nombreReceta
                    .toLowerCase()
                    .replace(/[^a-z0-9áéíóúüñ\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/--+/g, '-')
                    .replace(/^-+|-+$/g, '');
                nombreArchivoFinal = `receta-${nombreLimpio}.pdf`;
            } else if (nombreArchivo) {
                nombreArchivoFinal = nombreArchivo;
            }
            pdf.save(nombreArchivoFinal);
        } catch (error) {
            console.error('Error al generar el PDF:', error);
            alert('Ocurrió un error al generar el PDF. Por favor, inténtalo de nuevo.');
        } finally {
            if (loadingMessage && document.body.contains(loadingMessage)) {
                document.body.removeChild(loadingMessage);
            }
            if (header) header.style.display = headerDisplay;
            if (footer) footer.style.display = footerDisplay;
        }
    } catch (error) {
        console.error('Error al generar el PDF:', error);
        alert('Ocurrió un error al generar el PDF. Por favor, inténtalo de nuevo.');
    }
}