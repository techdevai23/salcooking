<?php
$css_extra = '<link rel="stylesheet" href="styles/accion.css">';
$js_extra = '<script src="scripts/accion-completada.js"></script>';
?>

<?php include 'header.php'; ?>

<!-- No necesitamos migas de pan en esta página -->

<!-- Contenido principal-->
<section class="accion-completada-section">
    <div class="overlay"></div>
    <div class="modal-accion-completada">
        <div class="modal-content">
            <h2>Acción realizada con éxito. Muchas gracias.</h2>
            <div class="boton-volver">
                <a href="index.php" class="btn-aceptar">
                    <span class="icono-volver">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="11" stroke="currentColor" stroke-width="2"/>
                            <path d="M15 8L9 12L15 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>