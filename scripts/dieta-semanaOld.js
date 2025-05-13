// <!-- script que maneja la seleccion del desplegable -->

    // Función para cambiar la vista de comidas según la selección
    function cambiarVistaComidas(valor) {
        // Ocultar todas las secciones primero
        const seccionesComidas = document.querySelectorAll('.meal-time-row');
        seccionesComidas.forEach(seccion => {
            seccion.style.display = 'none';
        });
        
        // Mostrar secciones según la selección
        if (valor === "des") {
            // Mostrar solo desayunos
            const desayunos = document.querySelector('.meal-time-row[data-tipo="desayuno"]');
            if (desayunos) desayunos.style.display = 'flex';
        } else if (valor === "comida") {
            // Mostrar las tres secciones de comida
            const entrantes = document.querySelector('.meal-time-row[data-tipo="entrante"]');
            const principales = document.querySelector('.meal-time-row[data-tipo="principal"]');
            const postres = document.querySelector('.meal-time-row[data-tipo="postre"]');
            
            if (entrantes) entrantes.style.display = 'flex';
            if (principales) principales.style.display = 'flex';
            if (postres) postres.style.display = 'flex';
        } else if (valor === "cena") {
            // Mostrar solo cenas
            const cenas = document.querySelector('.meal-time-row[data-tipo="cena"]');
            if (cenas) cenas.style.display = 'flex';
        } else if (valor === "todo") {
            // Mostrar todas las secciones
            seccionesComidas.forEach(seccion => {
                seccion.style.display = 'flex';
            });
        } 
    }
    
    // Inicializar la vista al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        cambiarVistaComidas("des"); // Mostrar desayunos por defecto
    });
