<?php 
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['redirect_after_login'] = 'primera-vez.php';
    header('Location: login.php');
    exit;
}

$titulo_pagina = 'Generar tu Primera Dieta';
$css_extra = '';
include 'header.php'; 
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-utensils fa-2x me-3"></i>
                        <div>
                            <h2 class="h4 mb-0">¡Bienvenido a tu Planificador de Dieta!</h2>
                            <p class="mb-0">Genera tu primera dieta personalizada</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="sources/iconos/chef-hat.svg" alt="Chef" class="img-fluid mb-3" style="max-height: 120px;">
                        <h3 class="h4">¿Listo para comenzar?</h3>
                        <p class="text-muted">Genera tu primera dieta personalizada basada en tus preferencias y restricciones alimentarias.</p>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="h6 mb-1">Personalizada para ti</h5>
                                    <p class="small text-muted mb-0">Considera tus alergias y preferencias alimentarias.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-utensils fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="h6 mb-1">Variedad de platos</h5>
                                    <p class="small text-muted mb-0">Descubre nuevas recetas cada semana.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-list-alt fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="h6 mb-1">Lista de compras</h5>
                                    <p class="small text-muted mb-0">Genera automáticamente tu lista de la compra.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-sync-alt fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="h6 mb-1">Siempre fresco</h5>
                                    <p class="small text-muted mb-0">Puedes generar una nueva dieta cuando quieras.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-4">
                        <button id="generarDietaBtn" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-magic me-2"></i> Generar mi dieta
                        </button>
                        <a href="perfil-logueado.php" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="fas fa-user-edit me-2"></i> Ver mi perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-white d-flex justify-content-center align-items-center" style="display: none; z-index: 1050; background-color: rgba(255,255,255,0.9);">
    <div class="text-center">
        <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <h4 class="h5">Generando tu dieta personalizada</h4>
        <p class="text-muted">Esto puede tomar unos segundos...</p>
    </div>
</div>

<script>
document.getElementById('generarDietaBtn').addEventListener('click', function() {
    const overlay = document.getElementById('loadingOverlay');
    overlay.style.display = 'flex';
    
    // Llamada AJAX para generar la dieta
    fetch('generar-dieta.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url;
        } else {
            return response.json();
        }
    })
    .then(data => {
        if (data && data.redirect) {
            window.location.href = data.redirect;
        } else {
            throw new Error('Respuesta inesperada del servidor');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        overlay.style.display = 'none';
        alert('Ocurrió un error al generar la dieta. Por favor, inténtalo de nuevo.');
    });
});
</script>

<?php include 'footer.php'; ?>
