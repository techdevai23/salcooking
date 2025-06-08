document.addEventListener('DOMContentLoaded', function () {
    // Verificar si hay recetas
    if (typeof window.recetasData === 'undefined' || !window.recetasData || window.recetasData.length === 0) {
        console.log('No hay recetas disponibles');
        return;
    }

    // Configuración del carrusel
    const carrusel = document.querySelector('.recipiente-carrusel');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const indicators = document.querySelectorAll('.indicator');
    const recetas = window.recetasData;
    const totalRecetas = recetas.length;
    let currentIndex = 0;
    const isMobile = window.innerWidth <= 767;

    // Obtener las tarjetas por posición
    const cards = {
        'left-2': carrusel.querySelector('[data-position="left-2"]'),
        'left-1': carrusel.querySelector('[data-position="left-1"]'),
        'center': carrusel.querySelector('[data-position="center"]'),
        'right-1': carrusel.querySelector('[data-position="right-1"]'),
        'right-2': carrusel.querySelector('[data-position="right-2"]')
    };

    // Función para actualizar el contenido de una tarjeta
    function updateCard(card, receta) {
        if (!card || !receta) return;

        const link = card.querySelector('a');
        const img = card.querySelector('img');
        const title = card.querySelector('h4');
        const tagsContainer = card.querySelector('.recipiente-tags');

        link.href = `index.php?page=detalle-receta&id=${receta.id}`;
        img.src = `sources/platos/id${receta.id}.png`;
        img.alt = receta.nombre;
        title.textContent = receta.nombre;

        // Actualizar tags
        tagsContainer.innerHTML = '';
        if (receta.tipo_plato) {
            tagsContainer.innerHTML += `<span class="tag tag-plato">${receta.tipo_plato.toUpperCase()}</span>`;
        }
        if (receta.alergenos && receta.alergenos.length > 0) {
            receta.alergenos.forEach(alergeno => {
                const clase = alergeno.nombre.toLowerCase().replace(/ /g, '-');
                tagsContainer.innerHTML += `<span class="tag ${clase}">${alergeno.nombre}</span>`;
            });
        }
        if (receta.enfermedades && receta.enfermedades.length > 0) {
            receta.enfermedades.forEach(enfermedad => {
                const clase = enfermedad.nombre.toLowerCase();
                tagsContainer.innerHTML += `<span class="tag ${clase}">No apto ${enfermedad.nombre}</span>`;
            });
        }
    }

    // Función para actualizar el carrusel
    function updateCarrusel() {
        if (isMobile) {
            // En móvil, solo mostramos la receta actual
            const centerCard = cards['center'];
            const receta = recetas[currentIndex];
            
            centerCard.classList.remove('featured-card', 'side-card', 'hidden');
            centerCard.classList.add('featured-card');
            
            updateCard(centerCard, receta);
            
            // Ocultar las otras tarjetas
            Object.keys(cards).forEach(position => {
                if (position !== 'center') {
                    cards[position].classList.add('hidden');
                }
            });
        } else {
            // En escritorio, mantenemos la lógica original
            const indices = {
                'left-2': (currentIndex - 2 + totalRecetas) % totalRecetas,
                'left-1': (currentIndex - 1 + totalRecetas) % totalRecetas,
                'center': currentIndex,
                'right-1': (currentIndex + 1) % totalRecetas,
                'right-2': (currentIndex + 2) % totalRecetas
            };

            Object.keys(cards).forEach(position => {
                const card = cards[position];
                const recetaIndex = indices[position];
                const receta = recetas[recetaIndex];

                card.classList.remove('featured-card', 'side-card', 'hidden');

                if (position === 'center') {
                    card.classList.add('featured-card');
                } else {
                    card.classList.add('side-card');
                    if ((position === 'left-1' || position === 'left-2') && currentIndex === 0) {
                        card.classList.add('hidden');
                    }
                }

                updateCard(card, receta);
            });
        }

        // Actualizar indicadores
        const activeIndicator = Math.floor(currentIndex / (isMobile ? 1 : 2));
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === activeIndicator);
        });

        // Actualizar estado de los botones
        prevBtn.style.visibility = currentIndex === 0 ? 'hidden' : 'visible';
        nextBtn.style.visibility = currentIndex === totalRecetas - 1 ? 'hidden' : 'visible';
    }

    // Eventos para los botones de navegación
    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            if (currentIndex < totalRecetas - 1) {
                currentIndex++;
                updateCarrusel();
            }
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarrusel();
            }
        });
    }

    // Eventos para los indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function () {
            currentIndex = index * (isMobile ? 1 : 2);
            updateCarrusel();
        });
    });

    // Inicializar carrusel
    updateCarrusel();

    // Actualizar en cambio de tamaño de ventana
    window.addEventListener('resize', function() {
        const wasMobile = isMobile;
        isMobile = window.innerWidth <= 767;
        
        if (wasMobile !== isMobile) {
            updateCarrusel();
        }
    });

    // Opcional: Añadir funcionalidad de autoplay
    // let autoplayInterval = setInterval(() => {
    //     currentIndex = (currentIndex + 1) % totalRecetas;
    //     updateCarrusel();

    // }, 5000);

    // Opcional: Pausar autoplay cuando el mouse está sobre el carrusel
    // carrusel.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
    // carrusel.addEventListener('mouseleave', () => {
    //     autoplayInterval = setInterval(() => {
    //         currentIndex = (currentIndex + 1) % totalRecetas;
    //         updateCarrusel();

    //     }, 5000);
    // });
});