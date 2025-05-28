<?php 
$titulo_pagina = 'Acceso Premium Requerido';
$css_extra = '';
include 'header.php'; 
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h2><i class="fas fa-crown me-2"></i>Contenido Exclusivo Premium</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <i class="fas fa-lock fa-5x text-warning mb-3"></i>
                        <h3 class="card-title">¡Acceso Restringido!</h3>
                        <p class="card-text">La generación de dietas personalizadas es una función exclusiva para usuarios Premium.</p>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-primary">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">¿Ya eres Premium?</h5>
                                    <p class="card-text">Inicia sesión con tu cuenta Premium para acceder a todas las funciones.</p>
                                    <a href="login.php" class="btn btn-primary w-100">Iniciar Sesión</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-success">
                                <div class="card-body">
                                    <h5 class="card-title text-success">Hazte Premium</h5>
                                    <p class="card-text">Desbloquea todas las funciones convirtiéndote en usuario Premium.</p>
                                    <a href="planes.php" class="btn btn-success w-100">Ver Planes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
