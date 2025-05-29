<?php 
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['redirect_after_login'] = 'primera-vez.php';
    header('Location: login.php');
    exit;
}

$titulo_pagina = 'Generar tu Primera Dieta';
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/primera-vez.css?v=' . filemtime('styles/primera-vez.css') . '">';
include 'header.php'; 
?>

<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Mi Primera Dieta</li>
        </ul>
    </div>
</div>

<!-- Main Content -->
<section class="primera-vez">
    <div class="container-primera-vez">
        <div class="contenido-primera-vez">
            <div class="tarjeta-primera-vez">
                <!-- Vista para usuarios premium -->
                <div id="vistaPremium" class="card-body p-4" style="display: <?php echo isset($_SESSION['es_premium']) && $_SESSION['es_premium'] ? 'block' : 'none'; ?>">
                    <div class="container">
                        <div class="text-center mb-4">
                            <img src="sources/iconos/chef-hat.svg" alt="Chef" class="img-fluid mb-3" style="max-height: 120px;">
                            <h3 class="h4">¡Genera tu primera dieta!</h3>
                            <p class="text-muted">Crea tu plan de alimentación personalizado en un solo clic.</p>
                        </div>

                        <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-4">
                            <button id="generarDietaBtn" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-magic me-2"></i> Generar mi dieta
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Vista para usuarios no premium -->
                <div id="vistaNoPremium" class="card-body p-4" style="display: <?php echo isset($_SESSION['es_premium']) && $_SESSION['es_premium'] ? 'none' : 'block'; ?>">
                    <div class="container">
                        <div class="text-center mb-4">
                            <img src="sources/iconos/crown.svg" alt="Premium" class="img-fluid mb-3" style="max-height: 120px;">
                            <h3 class="h4">¡Hazte Premium!</h3>
                            <p class="text-muted">Desbloquea todas las funciones para generar tu dieta personalizada.</p>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="me-3 text-primary">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="h6 mb-1">Dietas personalizadas</h5>
                                        <p class="small text-muted mb-0">Genera dietas adaptadas a ti.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="me-3 text-primary">
                                        <i class="fas fa-list-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="h6 mb-1">Listas de compra</h5>
                                        <p class="small text-muted mb-0">Genera automáticamente tu lista.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-4">
                            <a href="premium.php" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-crown me-2"></i> Hacerme Premium
                            </a>
                            <a href="index.php" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-home me-2"></i> Volver al inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
    
    fetch('generar-dieta.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            throw new Error('Respuesta inesperada del servidor');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        overlay.style.display = 'none';
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Ocurrió un error al generar la dieta. Por favor, inténtalo de nuevo.',
            confirmButtonText: 'Aceptar'
        });
    });
});
</script>

<?php include 'footer.php'; ?>
