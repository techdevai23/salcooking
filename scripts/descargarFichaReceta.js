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
        const margin = 15; // Aumentado el margen para mejor legibilidad
        const contentWidth = pageWidth - (2 * margin);
        
        // Función para capturar y añadir páginas al PDF
        async function captureAndAddPage(element, position = 0, currentPage = 1) {
            console.log(`[14] Capturando página ${currentPage}, posición inicial: ${position}px`);
            
            const options = {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                logging: true,
                windowHeight: window.innerHeight,
                scrollY: position,
                height: element.scrollHeight,
                width: element.scrollWidth,
                y: position,
                onclone: (clonedDoc) => {
                    // Asegurarse de que el clon no tenga estilos que afecten la captura
                    const style = document.createElement('style');
                    style.textContent = `
                        .contenido-filosofia {
                            margin: 0 !important;
                            padding: 15px !important;
                            min-height: 200px !important;
                            box-shadow: none !important;
                        }
                        .contenido-filosofia h1 {
                            margin-top: 0 !important;
                            min-height:50px !important;
                            margin-bottom: 40px !important;
                            font-size: 22px !important;
                        }
                        .contenido-filosofia h3 {
                            margin-top: 15px !important;
                            margin-bottom: 25px !important;
                            font-size: 18px !important;
                        }
                        .contenido-filosofia ul {
                            margin-top: 10px !important;
                            margin-bottom: 15px !important;
                            padding-left: 20px !important;
                        }
                        .contenido-filosofia li {
                            margin-bottom: 5px !important;
                            line-height: 1.4 !important;
                        }
                        .contenido-filosofia p {
                            margin-top: 10px !important;
                            margin-bottom: 15px !important;
                            min-height: 100px !important;
                            line-height: 1.4 !important;
                        }
                        @media print {
                            @page { margin: 0; }
                            body { margin: 1.6cm; }
                        }
                    `;
                    clonedDoc.head.appendChild(style);
                }
            };
            
            // Mostrar mensaje de carga solo en la primera página
            if (currentPage === 1) {
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
            } else {
                loadingMessage.textContent = `Generando PDF (página ${currentPage})...`;
            }
            
            try {
                console.log(`[15] Iniciando captura de la página ${currentPage}`);
                const canvas = await html2canvas(element, options);
                console.log(`[16] Captura de la página ${currentPage} completada`);
                
                // Calcular dimensiones manteniendo la relación de aspecto
                const imgWidth = contentWidth;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                
                // Añadir nueva página si no es la primera
                if (currentPage > 1) {
                    pdf.addPage();
                }
                
                // Añadir la imagen al PDF
                pdf.addImage(canvas, 'PNG', margin, margin, imgWidth, imgHeight);
                
                // Verificar si necesitamos más páginas
                const remainingHeight = element.scrollHeight - (position + window.innerHeight);
                console.log(`[17] Altura restante: ${remainingHeight}px`);
                
                if (remainingHeight > 0) {
                    // Capturar la siguiente página
                    return captureAndAddPage(element, position + window.innerHeight, currentPage + 1);
                }
                
                return Promise.resolve();
                
            } catch (error) {
                console.error(`Error al capturar la página ${currentPage}:`, error);
                throw new Error(`Error al capturar la página ${currentPage}: ${error.message}`);
            }
        }
        
        // Iniciar la captura de la primera página
        console.log('[13] Iniciando captura de páginas...');
        await captureAndAddPage(element, 0, 1);
        
        // Eliminar el mensaje de carga una vez completado
        if (loadingMessage && loadingMessage.parentNode) {
            loadingMessage.parentNode.removeChild(loadingMessage);
        }
        
        // Generar nombre de archivo con el nombre de la receta si está disponible
        let nombreArchivoFinal = 'receta.pdf';
        if (nombreReceta) {
            // Limpiar el nombre de la receta para usarlo en el nombre del archivo
            const nombreLimpio = nombreReceta
                .toLowerCase()
                .replace(/[^a-z0-9áéíóúüñ\s-]/g, '') // Eliminar caracteres especiales
                .replace(/\s+/g, '-') // Reemplazar espacios con guiones
                .replace(/--+/g, '-') // Reemplazar múltiples guiones con uno solo
                .replace(/^-+|-+$/g, ''); // Eliminar guiones al inicio y final
                
            nombreArchivoFinal = `receta-${nombreLimpio}.pdf`;
        } else if (nombreArchivo) {
            nombreArchivoFinal = nombreArchivo;
        }
        
        console.log(`[18] Descargando PDF (${pdf.internal.getNumberOfPages()} páginas) con nombre:`, nombreArchivoFinal);
        pdf.save(nombreArchivoFinal);
        
    } catch (error) {
        console.error('Error al generar el PDF:', error);
        alert('Ocurrió un error al generar el PDF. Por favor, inténtalo de nuevo.');
    } finally {
        // Eliminar el mensaje de carga si existe
        if (loadingMessage && document.body.contains(loadingMessage)) {
            document.body.removeChild(loadingMessage);
        }
        
        // Restaurar header y footer
        if (header) header.style.display = headerDisplay;
        if (footer) footer.style.display = footerDisplay;
    }
}