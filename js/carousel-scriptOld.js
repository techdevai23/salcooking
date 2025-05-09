document.addEventListener('DOMContentLoaded', function() {
    // Configuración del carrusel
    const carousel = document.querySelector('.recipe-carousel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const indicators = document.querySelectorAll('.indicator');
    
    // Datos de las recetas (estas serían reemplazadas por datos reales de PHP)
    const recetas = [
        {
            imagen: "images/platos/postre1.png",
            titulo: "Tarta con frutos rojos y nueces (con edulcorante)",
            tags: [{ clase: "secos", texto: "Frutos secos" }],
            url: "receta-ejemplo.php"
        },
        {
            imagen: "images/platos/entrante1.png",
            titulo: "Ensalada César Clásica",
            tags: [{ clase: "gluten", texto: "Contiene Gluten" }],
            url: "receta-detalle.php"
        },
        {
            imagen: "images/platos/entrante1.png",
            titulo: "Pescado con verduras",
            tags: [{ clase: "pescado", texto: "Contiene Pescado" }],
            url: "receta-detalle.php"
        },
        {
            imagen: "images/recipes/albondigas.jpg",
            titulo: "Albóndigas en salsa de tomate",
            tags: [],
            url: "receta-detalle.php"
        },
        {
            imagen: "images/platos/entrante2.png",
            titulo: "Pasta con gambas y piñones",
            tags: [
                { clase: "secos", texto: "Frutos secos" },
                { clase: "marisco", texto: "Contiene Marisco" }
            ],
            url: "receta-detalle.php"
        },
        {
            imagen: "images/platos/postre3.png",
            titulo: "Tarta de queso y frutos rojos",
            tags: [{ clase: "diabetes", texto: "No apto diabetes" }],
            url: "receta-detalle.php"
        }
    ];
    
    let currentIndex = 0;
    const totalRecipes = recetas.length;
    
    // Función para actualizar el carrusel
    function updateCarousel() {
        // Cálculo de índices para las recetas visibles
        const leftIndex2 = (currentIndex - 2 + totalRecipes) % totalRecipes;
        const leftIndex1 = (currentIndex - 1 + totalRecipes) % totalRecipes;
        const centerIndex = currentIndex;
        const rightIndex1 = (currentIndex + 1) % totalRecipes;
        const rightIndex2 = (currentIndex + 2) % totalRecipes;
        
        // Obtener todas las cards y actualizar su contenido
        const cards = carousel.querySelectorAll('.recipe-card');
        
        // Actualizar leftIndex2 (primera tarjeta a la izquierda)
        updateCardContent(cards[0], recetas[leftIndex2]);
        
        // Actualizar leftIndex1 (segunda tarjeta a la izquierda)
        updateCardContent(cards[1], recetas[leftIndex1]);
        
        // Actualizar centerIndex (tarjeta central)
        updateCardContent(cards[2], recetas[centerIndex]);
        
        // Actualizar rightIndex1 (primera tarjeta a la derecha)
        updateCardContent(cards[3], recetas[rightIndex1]);
        
        // Actualizar rightIndex2 (segunda tarjeta a la derecha)
        updateCardContent(cards[4], recetas[rightIndex2]);
        
        // Actualizar indicadores
        indicators.forEach((indicator, index) => {
            if (index === Math.floor(currentIndex / 2)) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }
    
    // Función para actualizar el contenido de una tarjeta
    function updateCardContent(card, receta) {
        const img = card.querySelector('img');
        const title = card.querySelector('h4');
        const tagsContainer = card.querySelector('.recipe-tags');
        const link = card.querySelector('a');
        
        img.src = receta.imagen;
        img.alt = receta.titulo;
        title.textContent = receta.titulo;
        
        // Actualizar tags
        tagsContainer.innerHTML = '';
        receta.tags.forEach(tag => {
            const tagSpan = document.createElement('span');
            tagSpan.className = `tag ${tag.clase}`;
            tagSpan.textContent = tag.texto;
            tagsContainer.appendChild(tagSpan);
        });
        
        link.href = receta.url;
    }
    
    // Eventos para los botones de navegación
    nextBtn.addEventListener('click', function() {
        currentIndex = (currentIndex + 1) % totalRecipes;
        updateCarousel();
    });
    
    prevBtn.addEventListener('click', function() {
        currentIndex = (currentIndex - 1 + totalRecipes) % totalRecipes;
        updateCarousel();
    });
    
    // Eventos para los indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            currentIndex = index * 2 % totalRecipes;
            updateCarousel();
        });
    });
    
    // Inicializar carrusel
    updateCarousel();
    
    // Opcional: Añadir funcionalidad de autoplay
    // let autoplayInterval = setInterval(() => {
    //     currentIndex = (currentIndex + 1) % totalRecipes;
    //     updateCarousel();
    // }, 5000);
    
    // Opcional: Pausar autoplay cuando el mouse está sobre el carrusel
    // carousel.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
    // carousel.addEventListener('mouseleave', () => {
    //     autoplayInterval = setInterval(() => {
    //         currentIndex = (currentIndex + 1) % totalRecipes;
    //         updateCarousel();
    //     }, 5000);
    // });
});