document.addEventListener('DOMContentLoaded', function () {
    // Configuración del carrusel
    const carrusel = document.querySelector('.recipiente-carrusel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const indicators = document.querySelectorAll('.indicator');

    // Datos de las recetas (estas serían reemplazadas por datos reales de PHP)
    const recetas = [
        {
            imagen: "sources/platos/postre1.png",
            titulo: "Tarta con frutos rojos y nueces (con edulcorante)",
            tags: [{ clase: "tag-plato", texto: "POSTRE" },
            { clase: "secos", texto: "Frutos secos" },
            ],

            url: "detalle-receta.php?id=23"
        },
        {
            imagen: "sources/platos/entrante1.png",
            titulo: "Ensalada César Clásica",
            tags: [
                { clase: "tag-plato", texto: "ENTRANTE" },
                { clase: "gluten", texto: "Contiene Gluten" }],
            url: "detalle-receta.php?id=23"
        },
        {
            imagen: "sources/platos/principal1.png",
            titulo: "Pescado con verduras",
            tags: [{ clase: "tag-plato", texto: "PRINCIPAL" },
                { clase: "pescado", texto: "Contiene Pescado" }],
            url: "detalle-receta.php?id=23"
        },
        {
            imagen: "sources/PLATOS/PRINCIPAL2.PNG",
            titulo: "Atún con verduras asadas y piñones",
            tags: [{ clase: "tag-plato", texto: "PRINCIPAL" },
                { clase: "secos", texto: "Frutos secos" },
                { clase: "pescado", texto: "Contiene Pescado" }],
            url: "detalle-receta.php?id=23"
        },
        {
            imagen: "sources/platos/entrante2.png",
            titulo: "Pasta con gambas y almendras",
            tags: [{ clase: "tag-plato", texto: "ENTRANTE" },
                { clase: "secos", texto: "Frutos secos" },
                { clase: "marisco", texto: "Contiene Marisco" }
            ],
            url: "detalle-receta.php?id=23"
        },
        {
            imagen: "sources/platos/postre3.png",
            titulo: "Tarta de queso y frutos rojos",
            tags: [{ clase: "tag-plato", texto: "POSTRE" },
                { clase: "diabetes", texto: "No apto diabetes" }],
            url: "detalle-receta.php?id=23"
        }
    ];

    let currentIndex = 0;
    let isFirstLoad = true; // Variable para controlar si es la primera carga

    const totalRecipientes = recetas.length;

    // Función para actualizar el carrusel
    function updatecarrusel() {
        // Cálculo de índices para las recetas visibles
        const leftIndex2 = (currentIndex - 2 + totalRecipientes) % totalRecipientes;
        const leftIndex1 = (currentIndex - 1 + totalRecipientes) % totalRecipientes;
        const centerIndex = currentIndex;
        const rightIndex1 = (currentIndex + 1) % totalRecipientes;
        const rightIndex2 = (currentIndex + 2) % totalRecipientes;

        // Obtener todas las cards y actualizar su contenido
        const cards = carrusel.querySelectorAll('.recipiente-card');

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

        // Ocultar las imágenes de la izquierda en la primera carga
        if (currentIndex === 0) {
            cards[0].classList.add('hidden'); // Oculta la primera tarjeta a la izquierda
            cards[1].classList.add('hidden'); // Oculta la segunda tarjeta a la izquierda
            
        } else {
            cards[0].classList.remove('hidden'); // Muestra la primera tarjeta a la izquierda
            cards[1].classList.remove('hidden'); // Muestra la segunda tarjeta a la izquierda
        }

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
        const tagsContainer = card.querySelector('.recipiente-tags');
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
    nextBtn.addEventListener('click', function () {
        currentIndex = (currentIndex + 1) % totalRecipientes;
        updatecarrusel();
    });

    prevBtn.addEventListener('click', function () {
        currentIndex = (currentIndex - 1 + totalRecipientes) % totalRecipientes;
        updatecarrusel();
    });

    // Eventos para los indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function () {
            currentIndex = index * 2 % totalRecipientes;
            updatecarrusel();
        });
    });

    // Inicializar carrusel
    updatecarrusel();

    // Opcional: Añadir funcionalidad de autoplay
    // let autoplayInterval = setInterval(() => {
    //     currentIndex = (currentIndex + 1) % totalRecipientes;
    //     updatecarrusel();
    // }, 5000);

    // Opcional: Pausar autoplay cuando el mouse está sobre el carrusel
    // carrusel.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
    // carrusel.addEventListener('mouseleave', () => {
    //     autoplayInterval = setInterval(() => {
    //         currentIndex = (currentIndex + 1) % totalRecipientes;
    //         updatecarrusel();
    //     }, 5000);
    // });
});