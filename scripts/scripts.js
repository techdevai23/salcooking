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

    // Smooth scrolling for anchor links
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

    // Add active class to current page in navigation
    const currentPage = window.location.pathname.split('/').pop();
    
    if (currentPage === '' || currentPage === 'index.html') {
        $('.nav-tabs li:first-child').addClass('active');
        $('.mobile-nav li:first-child').addClass('active');
    } else {
        $(`.nav-tabs li a[href="${currentPage}"]`).parent().addClass('active');
        $(`.mobile-nav li a[href="${currentPage}"]`).parent().addClass('active');
    }
});