// scripts generales que se ejecutan en todas las páginas, 
// ya que se CARGA en el FOOTER

/***** Función para  para mostrar u ocultar la barra de navegación en la vista móvil pasa a menú derecho****/
//
$(document).ready(function() {
    // Alternar menú móvil
    $('.mobile-menu-toggle').click(function() {
        $('.mobile-nav').toggleClass('active');
    });

    // Cerrar el menú móvil al hacer clic fuera
    $(document).click(function(event) {
        if (!$(event.target).closest('.mobile-menu-toggle, .mobile-nav').length) {
            $('.mobile-nav').removeClass('active');
        }
    });

    // Desplazamiento suave solo para enlaces de anclaje internos
    $('a[href^="#"]').not('.dieta-link').on('click', function(e) {
        // Verificar si el enlace es un anclaje interno (comienza con # seguido de caracteres)
        if ($(this).attr('href').match(/^#[^#\/]+$/)) {
            e.preventDefault();
            const target = $(this).attr('href');
            if ($(target).length) {
                $('html, body').animate(
                    {
                        scrollTop: $(target).offset().top - 70
                    },
                    500,
                    'linear'
                );
            }
        }
        // Si no es un anclaje interno, permitir el comportamiento predeterminado
    });

    // Agregar clase activa a la página actual en la navegación
    const currentPage = window.location.pathname.split('/').pop();

    // si la página actual es la raíz o index.html, se activa el primer elemento
    if (currentPage === '' || currentPage === 'index.html') {
        $('.nav-tabs li:first-child').addClass('active');
        $('.mobile-nav li:first-child').addClass('active');
    } else {
        // si la página actual no es la raíz, se activa el elemento correspondiente
        // y se quita la clase active de los demás
        $(`.nav-tabs li a[href="${currentPage}"]`).parent().addClass('active');
        $(`.mobile-nav li a[href="${currentPage}"]`).parent().addClass('active');
        // y quitar la clase active de los demás
        $(`.nav-tabs li a[href="${currentPage}"]`).parent().siblings().removeClass('active');
        $(`.mobile-nav li a[href="${currentPage}"]`).parent().siblings().removeClass('active');
    }
});

/********** menú desplegable izquierdo ************ */
document.addEventListener("DOMContentLoaded", function () {
    const slideMenu = document.getElementById("slideMenu");
    const openMenuButton = document.querySelector(".logo img"); // Imagen de la línea 54
    const closeMenuButton = document.getElementById("closeSlideMenu");

    // Abrir el menú
    openMenuButton.addEventListener("click", function () {
        slideMenu.classList.add("open");
    });

    // Cerrar el menú
    closeMenuButton.addEventListener("click", function () {
        slideMenu.classList.remove("open");
    });

    // Cerrar el menú al hacer clic fuera de él
    window.addEventListener("click", function (e) {
        if (!slideMenu.contains(e.target) && e.target !== openMenuButton) {
            slideMenu.classList.remove("open");
        }
    });

    // Desplazamiento suave para enlaces dentro del menú deslizante
    document.querySelectorAll('#slideMenu a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();

            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 70, // Ajusta el desplazamiento según sea necesario
                    behavior: "smooth",
                });
            }

            // Cerrar el menú después de hacer clic en un enlace
            slideMenu.classList.remove("open");
        });
    });
});