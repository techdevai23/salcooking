<?php
// header.php se ve?
?>

<?php
// Comprobamos si la sesión está iniciada para no iniciarla de nuevo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SalCooking: Planifica tu alimentación con menús semanales inteligentes, personalizados según tus gustos, alergias, intolerancias y enfermedades. Cocina con salud.">

    <title>SalCooking - Menús personalizados e inteligentes</title>

    <!-- Seguridad: Content Security Policy (CSP) -->
    <!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:;"> -->

    <!-- Seguridad: Prevención XSS, Clickjacking, MIME sniffing -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta http-equiv="Cross-Origin-Opener-Policy" content="same-origin">
    <meta http-equiv="Cross-Origin-Embedder-Policy" content="require-corp">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-...hash..." crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha384-...hash..." crossorigin="anonymous">

    <!-- Google Fonts con Copse (titulos y que usamos en el logo), Poppins(textos) y Nunito(botones) -->
    <link href="https://fonts.googleapis.com/css2?family=Copse&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Icono en la pestaña-->
    <link rel="icon" type="image/png" href="sources/logos/icono-salcooking.ico">

    <!-- Truco para evitar problemas de caché que pueden hacer ver al usuario estilos antiguos, por el comportamiento
   del servidor gratuito elegido -->
    <link rel="stylesheet" href="styles/styles.css?v=<?php echo filemtime('styles/styles.css'); ?>">

    <!-- Script para la descarga de la lista de la compra en PDF -->
    <script src="scripts/descargarListaPDF.js?v=<?php echo filemtime('scripts/descargarListaPDF.js'); ?>"></script>

    <!-- CSS adicional si se define -->
    <?php if (isset($css_extra)) echo $css_extra; ?>
</head>


<body>
    <!-- tener en cuenta la vision de la cabecera en versión escritorio y movil -->
    <header class="main-header">
        <!-- logotipo principal -->
        <div class="logo-cabecera">
            <a href="index.php"><img src="sources/logos/logo salcooking alargado.png" title="Ir al inicio" alt="SalCooking cabecera Logo">

            </a>
        </div>
        <!-- menú en tamaño grande de pantalla como barra de navegación -->
        <nav class="top-nav mb-2">
            <div class="container">
                <ul class="nav-tabs">
                    <li class="active"><a href="index.php">Inicio</a></li>
                    <li><a href="filosofia.php">Nuestra Filosofía</a></li>
                    <li><a href="recetas-categoria.php">Recetas</a></li>
                    <li><a href="dieta-semana-por-dias.php">Dieta</a></li>
                    <li><a href="trucos.php">Trucos</a></li>
                    <li><a href="planes.php">Planes</a></li>
                    <li><a href="ayuda.php">Ayuda</a></li>
                    <li><a href="contacto.php">Contáctanos</a></li>
                    <!-- Pulsando el enlace llevará a un lugar u otro, según si el usuario está logueado o no -->
                    <li> <a href="<?php echo isset($_SESSION['id_usuario']) ? 'perfil-logueado.php' : 'login.php'; ?>">
                            Perfil-Ajustes</a></li>

                </ul>
            </div>
            <!-- Contenedor principal - Elementos comunes -->
            <div class="container mb-3">
                <div class="header-content">
                    <!-- logotipo para ver el menu completo -->
                    <div class="logo d-none d-md-block">
                        <img src="sources/logos/logo.png" title="Accede a todas las secciones"" alt=" SalCooking Logo">
                    </div>
                    <!-- barra de búsqueda -->
                    <div class="search-box">
                        <form action="resultado-recetas.php" method="get">
                            <input type="text" placeholder="Busca recetas" name="query">
                            <button type="submit"><img src="sources/iconos/Search-Circle--Streamline-Ultimate.svg" width="28px" alt="búsqueda Icon"></button>
                        </form>
                    </div>
                    <!-- boton premium -->
                    <div class="premium-button">
                        <a href="contacto.php" class="btn-premium">Hazte Prémium</a>
                    </div>
                    <!-- icono de usuario con enlace a web de usuario -->
                    <div class="header-actions">
                        <div class="user-icon">
                            <!-- Mostraremos el icono o el nick de usuario, según si el usuario está logueado o no -->
                            <!-- si se muestra el icono llevará a una página u otra, dependiendo de si está logueado o no -->
                            <?php if (!isset($_SESSION['id_usuario'])): ?>
                                <a href="<?php echo isset($_SESSION['id_usuario']) ? 'perfil-logueado.php' : 'login.php'; ?>">
                                    <img src="sources/iconos/Single-Neutral-Circle--Streamline-Ultimate.svg" alt="User Icon" width="34px">
                                </a>
                            <?php else: ?>
                                <p style="color:var(--text-color);">Acceso con Nick: <?php echo htmlspecialchars($_SESSION['nick']); ?></p>
                            <?php endif; ?>


                            <!-- inserción para cerrar sesión si está iniciada -->
                            <?php if (isset($_SESSION['id_usuario'])): ?>
                                <a href="logout.php" class="btn-cerrar-sesion" style="margin-left:10px;">Cerrar sesión</a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <!-- icono de menú hambirguesa desplegable -->
                <div class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
            </div>
        </nav>
    </header>
    <!-- ************* menú en tamaño pequeño **************-->
    <nav class="mobile-nav">
        <ul>
            <li class="active"><a href="index.php">Inicio</a></li>
            <li><a href="filosofia.php">Nuestra Filosofía</a></li>
            <li><a href="recetas-categoria.php">Categorías de Recetas</a></li>
            <li><a href="dieta-semana-por-dias.php">Dietas</a></li>
            <li><a href="trucos.php">Trucos de cocina</a></li>
            <li><a href="planes.php">Planes</a></li>
            <!-- <li><a href="ayuda.php">Ayuda</a></li> -->
            <li><a href="contacto.php">Contáctanos</a></li>
            <li><a href="sitemap.php">Mapa del sitio</a></li>

        </ul>
    </nav>
    <!-- menú desplegable izquierdo -->
    <div class="slide-menu" id="slideMenu">
        <div class="slide-menu-header">
            <span id="closeSlideMenu" class="close-slide-menu">&times;</span>
            <h3>Menú</h3>
        </div>
        <ul>
            <li><a href="index.php">inicio</a></li>
            <hr style="border: 0.5px solid #ccc; margin: 0;">
            <li class="cabecera">RECETAS</li>
            <li><a href="recetas-categoria.php">Categorías</a></li>
            <li><a href="resultado-recetas.php">Búsqueda de recetas</a></li>
            <li><a href="detalle-receta.php?id=23">La receta del día</a></li>
            <li><a href="trucos.php">Trucos de cocina</a></li>
            <hr style="border: 0.5px solid #ccc; margin: 0;">
            <li class="cabecera">ZONA PRÉMIUM</li>
            <!-- solo boton de selecccion no redirección -->
            <li class="cabecera">PERFIL</li>
            <li><a href="perfil-logueado.php">Mi Perfil</a></li>
            <li class="cabecera">DIETAS</li>
            <li><a href="dieta-semana-por-dias.php">Dieta semanal</a></li>
            <li><a href="dieta-dia.php">Dieta del día</a></li>
            <li><a href="lista-semana.php">Lista de la compra semanal</a></li>
            <li><a href="lista-dia.php">Lista de la compra del día</a></li>
            <hr style="border: 0.5px solid #ccc; margin: 0;">
            <li class="cabecera">INFORMACIÓN</li>
            <li><a href="filosofia.php">Nuestra filosofía</a></li>
            <li><a href="contacto.php">Contáctanos</a></li>
            <li><a href="ayuda.php">Ayuda</a></li>
            <li><a href="planes.php">Planes</a></li>
            <hr style="border: 0.5px solid #ccc; margin: 0;">
            <li class="cabecera">GESTIÓN DE CUENTA</li>
            <li><a href="login.php">Login</a></li>
            <li><a href="perfil.php">Perfil-Ajustes</a></li>
            <li><a href="cambio-pass.php">Cambio de contraseña</a></li>
            <li><a href="accion-completada.php">Cerrar sesión</a></li>


        </ul>
    </div>