<?php
session_start();

$page = $_GET['page'] ?? 'inicio';

if ($page === 'buscar' || $page === 'detalle-receta') {
    require_once 'controllers/conexion.php'; 
    require_once 'controllers/receta-controller.php';
    $controller = new RecetaController();

    if ($page === 'buscar') {
        $controller->buscar();
    } elseif ($page === 'detalle-receta') {
        $controller->verDetalle();
    }

    exit; // Muy importante: evita que el resto del index.php se siga ejecutando
}
?>

<?php include 'header.php'; ?>
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Te damos la bienvenida!</h1>
            <div class="contenedor-tarjeta row align-items-stretch">

                <div class="platos row-md-6 col-md-3 d-flex flex-column align-items-center">
                    <img src="sources/platos/entrante1.png" class="img-fluid mb-2" alt="Plato 1">
                    <img src="sources/platos/principal2.png" class="img-fluid mb-2" alt="Plato 2">
                    <img src="sources/platos/postre3.png" class="img-fluid" alt="Plato 3">
                </div>

                <div class="tarjeta-logo row-md-6 col-md-6 text-center fondo-tarjeta">
                    <img src="sources/logos/composicion-tarjeta-completa.png" class="img-fluid" alt="Tarjeta Logo">
                    <div class="texto-tarjeta">
                        <h4>SalCooking permite planificar la alimentación de forma inteligente con menús semanales,
                            equilibrados, totalmente personalizados, teniendo en cuenta tanto los gustos personales como
                            las intolerancias, alergias y enfermedades del usuario.</h4>
                    </div>
                </div>

                <div class="mensaje row-md-6 col-md-3 fondo-tarjeta d-flex flex-column justify-content-center">
                    <p>Puedes <i>consultar y descargar</i> las más de <strong>200 recetas</strong> que tenemos, incluyendo información de <b>alérgenos</b> que tiene cada una, de manera <b>gratuita</b>.
</br> Y haciéndote <span class="premium">Prémium</span>,
                        da un paso más hacia una <span class="saludable"> alimentación saludable y segura</span> encontrando recetas <strong>aptas para distintas enfermedades</strong>,
                        crear un <strong>plan de dietas semanal</strong>, hasta podrás <strong> descargar listas de la compra</strong>... ¡Y muchas funciones más! ¿A qué estas esperando? 
                    </p>
                    <div>
                        <a href="contacto.php" title="Solo puedes ganar: Hazte Prémium" class="btn-premium">Hazte Prémium</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>