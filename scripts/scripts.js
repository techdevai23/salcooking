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