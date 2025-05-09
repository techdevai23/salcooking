$(document).ready(function() {
    // Mobile menu toggle
    $('.mobile-menu-toggle').click(function() {
        $('.mobile-nav').toggleClass('active');
    });

    // Close mobile menu when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('.mobile-menu-toggle, .mobile-nav').length) {
            $('.mobile-nav').removeClass('active');
        }
    });

    // Desplazamiento suave para enlaces de anclaje
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        
        $('html, body').animate(
            {
                scrollTop: $($(this).attr('href')).offset().top - 70
            },
            500,
            'linear'
        );
    });

    // Agregar clase activa a la página actual en la navegación
    const currentPage = window.location.pathname.split('/').pop();
    
    // Si la página actual es la raíz o index.html, activa el primer elemento
    if (currentPage === '' || currentPage === 'index.html') {
        $('.nav-tabs li:first-child').addClass('active');
        $('.mobile-nav li:first-child').addClass('active');
    } else {
        // Agregar clase activa a la pestaña de navegación correspondiente
        $(`.nav-tabs li a[href="${currentPage}"]`).parent().addClass('active');
        $(`.mobile-nav li a[href="${currentPage}"]`).parent().addClass('active');
        // y quitar la clase activa de la pestaña de navegación principal
        $(`.nav-tabs li a[href="${currentPage}"]`).parent().siblings().removeClass('active');
        $(`.mobile-nav li a[href="${currentPage}"]`).parent().siblings().removeClass('active');
    }
});