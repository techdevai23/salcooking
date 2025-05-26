document.addEventListener('DOMContentLoaded', function () {
    // Configuración del carrusel
    const carrusel = document.querySelector('.recipiente-carrusel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const indicators = document.querySelectorAll('.indicator');
    const cards = carrusel.querySelectorAll('.recipiente-card');
    const totalCards = cards.length;
    let currentIndex = 0; // Comenzamos con la primera receta en el centro

    // Función para actualizar el carrusel
    function updateCarrusel() {
        cards.forEach((card, index) => {
            // Remover todas las clases
            card.classList.remove('featured-card', 'side-card', 'hidden');
            
            // Calcular la posición relativa
            const relativePosition = (index - currentIndex + totalCards) % totalCards;
            
            // Aplicar clases según la posición
            if (relativePosition === 0) {
                // Tarjeta central (featured)
                card.classList.add('featured-card');
            } else if (relativePosition === 1 || relativePosition === 2) {
                // Tarjetas derechas
                card.classList.add('side-card');
            } else if (relativePosition === totalCards - 1 || relativePosition === totalCards - 2) {
                // Tarjetas izquierdas (solo visibles después de avanzar)
                card.classList.add('side-card');
            } else {
                // Tarjetas ocultas
                card.classList.add('side-card', 'hidden');
            }
        });

        // Actualizar indicadores
        const activeIndicator = Math.floor(currentIndex / 2);
        indicators.forEach((indicator, index) => {
            if (index === activeIndicator) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }

    // Eventos para los botones de navegación
    nextBtn.addEventListener('click', function () {
        currentIndex = (currentIndex + 1) % totalCards;
        updateCarrusel();
    });

    prevBtn.addEventListener('click', function () {
        currentIndex = (currentIndex - 1 + totalCards) % totalCards;
        updateCarrusel();
    });

    // Eventos para los indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function () {
            currentIndex = index * 2;
            updateCarrusel();
        });
    });

    // Inicializar carrusel
    updateCarrusel();

    // Opcional: Añadir funcionalidad de autoplay
    // let autoplayInterval = setInterval(() => {
    //     currentIndex = (currentIndex + 1) % totalCards;
    //     updateCarrusel();
    // }, 5000);

    // Opcional: Pausar autoplay cuando el mouse está sobre el carrusel
    // carrusel.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
    // carrusel.addEventListener('mouseleave', () => {
    //     autoplayInterval = setInterval(() => {
    //         currentIndex = (currentIndex + 1) % totalCards;
    //         updateCarrusel();
    //     }, 5000);
    // });
});