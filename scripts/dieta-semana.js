document.addEventListener('DOMContentLoaded', function() {
    const vistaPorSelect = document.getElementById('ordenar');
    const allMealTimeRows = document.querySelectorAll('.dieta-semana .meal-time-row');
    const mobileDayNavContainer = document.querySelector('.mobile-day-nav');
    
    let activeDay = 'lunes'; // Día activo por defecto

    // --- Preparación Inicial (Añadir data-day si no existen) ---
    // Es MUY RECOMENDABLE que los data-day vengan del backend.
    // Este código es un fallback.
    const daysOrder = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    allMealTimeRows.forEach(row => {
        const mealItems = row.querySelectorAll('.meal-container .meal-item');
        mealItems.forEach((item, index) => {
            if (!item.dataset.day && daysOrder[index]) {
                item.dataset.day = daysOrder[index];
            }
            // Asegurar que el H3 con el día existe y es correcto (opcional, mejora UI)
            let h3 = item.querySelector('h3');
            if (daysOrder[index]) {
                if (!h3) {
                    h3 = document.createElement('h3');
                    item.insertBefore(h3, item.firstChild);
                    const br = document.createElement('br');
                    item.insertBefore(br, h3.nextSibling);
                }
                // Para consistencia, podemos poner el nombre del día si no estaba o es incorrecto
                // h3.textContent = daysOrder[index].charAt(0).toUpperCase() + daysOrder[index].slice(1);
            }
        });
    });
    // --- Fin Preparación Inicial ---

    function updateDisplay() {
        const selectedVista = vistaPorSelect ? vistaPorSelect.value : 'des'; // Default a desayuno
        const isMobile = window.innerWidth <= 768;

        // Ocultar/Mostrar barra de días móvil
        if (mobileDayNavContainer) {
            mobileDayNavContainer.style.display = isMobile ? 'flex' : 'none';
        }
        
        // Ocultar opción "Dieta Completa" en móvil
        if (vistaPorSelect) {
            const dietaCompletaOption = vistaPorSelect.querySelector('option[value="todo"]');
            if (dietaCompletaOption) {
                dietaCompletaOption.style.display = isMobile ? 'none' : '';
            }
            // Si estamos en móvil y "todo" está seleccionado, cambiar a "desayuno"
            if (isMobile && vistaPorSelect.value === 'todo') {
                vistaPorSelect.value = 'des';
                // Disparar el cambio manualmente si el valor se actualiza por JS
                // return updateDisplay(); // O llamar a cambiarVistaComidas directamente
            }
        }


        // Ocultar todas las filas y todos los items
        allMealTimeRows.forEach(row => {
            row.classList.remove('visible-meal-row');
            row.style.display = 'none'; // Para desktop y reset inicial
            const mealItems = row.querySelectorAll('.meal-container .meal-item');
            mealItems.forEach(item => item.classList.remove('active-day-meal'));
            
            // Limpiar títulos de tipo de comida previos en móvil
            const existingMobileTitle = row.querySelector('.meal-type-title-mobile');
            if (existingMobileTitle) existingMobileTitle.remove();
        });

        let mealTypesToShow = [];
        if (selectedVista === 'des') mealTypesToShow.push('desayuno');
        else if (selectedVista === 'comida') mealTypesToShow.push('entrante', 'principal', 'postre');
        else if (selectedVista === 'cena') mealTypesToShow.push('cena');
        else if (selectedVista === 'todo' && !isMobile) { // 'todo' solo en desktop
            mealTypesToShow.push('desayuno', 'entrante', 'principal', 'postre', 'cena');
        }

        mealTypesToShow.forEach(type => {
            const targetRow = document.querySelector(`.dieta-semana .meal-time-row[data-tipo="${type}"]`);
            if (targetRow) {
                if (isMobile) {
                    targetRow.classList.add('visible-meal-row'); // Para aplicar CSS de móvil
                    targetRow.style.display = 'block'; // Asegurar visibilidad
                    
                    // Añadir título para "Comida" en móvil
                    if (selectedVista === 'comida') {
                        let titleText = type.charAt(0).toUpperCase() + type.slice(1);
                        if(type === 'principal') titleText = "Plato Principal";
                        
                        const mobileTitle = document.createElement('h4');
                        mobileTitle.className = 'meal-type-title-mobile';
                        mobileTitle.textContent = titleText;
                        targetRow.insertBefore(mobileTitle, targetRow.querySelector('.meal-container'));
                    }

                    const mealItemToShow = targetRow.querySelector(`.meal-container .meal-item[data-day="${activeDay}"]`);
                    if (mealItemToShow) {
                        mealItemToShow.classList.add('active-day-meal');
                    }
                } else { // Lógica Desktop
                    targetRow.style.display = 'flex'; // Display original de desktop
                    // En desktop, todos los meal-item de la fila son visibles por defecto por CSS
                }
            }
        });
    }

    // Event Listeners
    if (vistaPorSelect) {
        vistaPorSelect.addEventListener('change', updateDisplay);
    }

    if (mobileDayNavContainer) {
        mobileDayNavContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('day-tab')) {
                mobileDayNavContainer.querySelectorAll('.day-tab').forEach(tab => tab.classList.remove('active'));
                event.target.classList.add('active');
                activeDay = event.target.dataset.daynav;
                updateDisplay();
            }
        });
    }

    window.addEventListener('resize', updateDisplay);

    // Llamada inicial
    updateDisplay();

    // Hacer la función global si el onchange está en el HTML
    // Si ya no está en el HTML, no necesitas esto.
    // window.cambiarVistaComidas = (value) => {
    //     if(vistaPorSelect) vistaPorSelect.value = value; // Sincronizar el select
    //     updateDisplay();
    // };
});