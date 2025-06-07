<?php
// header.php se ve?
?>

<?php
require_once 'controllers/session.php';
startSession();
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
    <!-- CSS para los modales DE ALERTAS -->
    <link rel="stylesheet" href="styles/modal.css?v=<?php echo filemtime('styles/modal.css');?>">
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
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                        <a href="index.php">Inicio</a>
                    </li>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'filosofia.php' ? 'active' : ''; ?>">
                        <a href="filosofia.php">Nuestra Filosofía</a>
                    </li>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'recetas-categoria.php' ? 'active' : ''; ?>">
                        <a href="recetas-categoria.php">Recetas</a>
                    </li>
                    <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['dieta-semana-por-dias.php', 'primera-vez.php', 'no-premium.php']) ? 'active' : ''; ?>">
                        <a id="dieta" href="<?php echo isLoggedIn() ? 'dieta-semana-por-dias.php' : '#'; ?>">Dieta</a>
                    </li>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'trucos.php' ? 'active' : ''; ?>">
                        <a id="trucos" href="trucos.php">Trucos</a>
                    </li>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'planes.php' ? 'active' : ''; ?>">
                        <a href="planes.php">Planes</a>
                    </li>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'ayuda.php' ? 'active' : ''; ?>">
                        <a href="ayuda.php">Ayuda</a>
                    </li>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contacto.php' ? 'active' : ''; ?>">
                        <a href="contacto.php">Contáctanos</a>
                    </li>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'perfil-logueado.php' ? 'active' : ''; ?>">
                        <a href="<?php echo isLoggedIn() ? 'perfil-logueado.php' : 'login.php'; ?>">
                            Perfil-Ajustes
                        </a>
                    </li>

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
                        <form action="index.php" method="get">
                            <input type="hidden" name="page" value="buscar">
                            <input type="text" placeholder="Busca titulo de receta, deja en blanco para ver todas" name="q">
                            <button type="submit">
                                <img src="sources/iconos/Search-Circle--Streamline-Ultimate.svg" width="28px" alt="búsqueda Icon"></button>
                        </form>
                    </div>
                    <!-- boton premium -->
                    <?php if (!isLoggedIn()): ?>
                        <!-- <div class="premium-button">
                        <a href="perfil.php" title="Solo puedes ganar: Registrate gratis" class="btn-premium">Regístrate gratis</a>
                    </div> -->
                    <?php endif; ?>
                    <!-- icono de usuario con enlace a web de usuario -->
                    <div class="header-actions">
                        <!-- Mostraremos el icono o el nick de usuario, según si el usuario está logueado o no -->
                        <!-- si se muestra el icono llevará a una página u otra, dependiendo de si está logueado o no -->
                        <?php if (!isLoggedIn()): ?>
                            <!-- el usuario no está logueado, por lo que se le ofrece registrarse gratis y el icono -->
                            <div class="user-panel-visitante">
                                <a href="perfil.php" class="btn-premium">Regístrate gratis</a>
                                <a href="login.php" class="user-icon-link">
                                    <img src="sources/iconos/Single-Neutral-Circle--Streamline-Ultimate.svg" title="Accede a tu perfil" alt="User Icon" class="user-icon-img">
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- el usuario está logueado, se muestra su info y opciones -->
                            <div class="user-panel-logueado">
                                <!-- Columna izquierda: CTA si no es premium -->
                                <div class="user-panel-col user-panel-col-cta">
                                    <?php if (!isset($_SESSION['es_premium']) || !$_SESSION['es_premium']): ?>
                                        <a href="contacto.php" class="btn-premium">Hazte Prémium</a>
                                    <?php endif; ?>
                                </div>
                                <!-- Columna derecha: info usuario y cerrar sesión -->
                                <div class="user-panel-col user-panel-col-info">
                                    <div class="user-nick">
                                        Usuario/a:<br>
                                        <span class="user-nick-nombre"><?php echo htmlspecialchars((string)(getUserNick() ?? '')); ?></span>
                                    </div>
                                    <a href="logout.php" class="btn-cerrar-sesion">Cerrar sesión</a>
                                </div>
                            </div>
                        <?php endif; ?>
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
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <a href="index.php">Inicio</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'filosofia.php' ? 'active' : ''; ?>">
                <a href="filosofia.php">Nuestra Filosofía</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'recetas-categoria.php' ? 'active' : ''; ?>">
                <a href="recetas-categoria.php">Recetas</a>
            </li>
            <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['dieta-semana-por-dias.php', 'primera-vez.php', 'no-premium.php']) ? 'active' : ''; ?>">
                <a id="dietaMobile" href="<?php echo isLoggedIn() ? 'dieta-semana-por-dias.php' : '#'; ?>">Dieta</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'trucos.php' ? 'active' : ''; ?>">
                <a id="trucosMobile" href="trucos.php">Trucos</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'planes.php' ? 'active' : ''; ?>">
                <a href="planes.php">Planes</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'ayuda.php' ? 'active' : ''; ?>">
                <a href="ayuda.php">Ayuda</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contacto.php' ? 'active' : ''; ?>">
                <a href="contacto.php">Contáctanos</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'perfil-logueado.php' ? 'active' : ''; ?>">
                <a href="<?php echo isLoggedIn() ? 'perfil-logueado.php' : 'login.php'; ?>">
                    <?php echo isLoggedIn() ? 'Mi Perfil' : 'Iniciar Sesión'; ?>
                </a>
            </li>
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
            <li><a id="trucosDesplegable" href="trucos.php">Trucos de cocina</a></li>
            <hr style="border: 0.5px solid #ccc; margin: 0;">
            <li class="cabecera">INFORMACIÓN</li>
            <li><a href="filosofia.php">Nuestra filosofía</a></li>
            <li><a href="contacto.php">Contáctanos</a></li>
            <li><a href="ayuda.php">Ayuda</a></li>
            <li><a href="planes.php">Planes</a></li>
            <hr style="border: 0.5px solid #ccc; margin: 0;">

            <!-- solo boton de selecccion no redirección -->
            <!-- <li class="cabecera">PERFIL</li>
            <li><a href="perfil-logueado.php">Mi Perfil</a></li> -->
            <li class="cabeceraP">ZONA PRÉMIUM- DIETAS</li>
            <li class="cabeceraPF"><a id="dietaDesplegable" href="<?php echo isLoggedIn() ? 'dieta-semana-por-dias.php' : '#'; ?>">Dieta semanal</a></li>
            <li class="cabeceraPF"><a href="dieta-dia.php">Dieta del día</a></li>
            <li class="cabeceraPF"><a href="lista-semana.php">Lista compra semanal</a></li>
            <li class="cabeceraPF"><a href="lista-dia.php">Lista compra del día</a></li>
            <hr style="border: 0.5px solid #ccc; margin: 0;">

            <li class="cabecera">GESTIÓN DE CUENTA</li>
            <li><a href="login.php">Login</a></li>
            <li><a href="perfil-logueado.php">Perfil-Ajustes</a></li>
            <li><a href="cambio-pass.php">Cambio de contraseña</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>


        </ul>
    </div>

    <!-- Scripts para manejar los swal de error para los usuarios que no estan registrados -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Función para comprobar si el usuario está logueado (PHP -> JS)
        const usuarioLogueadoHeader = <?php echo isset($_SESSION['id_usuario']) ? 'true' : 'false'; ?>;

        document.querySelectorAll('#trucos, #trucosMobile, #trucosDesplegable').forEach(element => {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                if (!usuarioLogueadoHeader) {
                    Swal.fire({
                        title: "¡Acceso solo para usuarios registrados!",
                        html: "Debes registrarte gratis para poder acceder a esta página:<strong> Trucos de cocina</strong>.",
                        icon: "info",
                        showCancelButton: true,
                        showCloseButton: true,
                        confirmButtonText: 'Registrarme ahora',
                        cancelButtonText: 'Volver a la página principal',
                        buttonsStyling: true,
                        customClass: {
                            container: "my-swal-container",
                            popup: "my-swal-popup",
                            header: "my-swal-header",
                            title: "my-swal-title",
                            content: "my-swal-content",
                            confirmButton: "my-swal-confirm-button",
                            cancelButton: "my-swal-cancel-button-trucos",
                            closeButton: 'my-swal-close-button',
                            footer: 'my-swal-footer-trucos'
                        },
                        footer: '<a href="planes.php">Ver tipos de acceso</a>'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'perfil.php';
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            window.location.href = 'index.php';
                        }
                    });
                } else {
                    window.location.href = 'trucos.php';
                }
                 
            });
        });

        //evento para los enlaces pra entrar a la sección de dietas
        // Evento para los enlaces de dieta
        document.querySelectorAll('#dieta, #dietaMobile, #dietaDesplegable').forEach(element => {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                if (!usuarioLogueadoHeader) {
                    Swal.fire({
                        title: "¡Acceso solo para usuarios Prémium!",
                        html: "Debes registrarte gratis para poder acceder a esta página:<strong> Dieta semanal</strong>.",
                        icon: "info",
                        showCancelButton: true,
                        showCloseButton: true,
                        confirmButtonText: 'Registrarme ahora',
                        cancelButtonText: 'Volver a la página principal',
                        buttonsStyling: true,
                        customClass: {
                            container: "my-swal-container",
                            popup: "my-swal-popup",
                            header: "my-swal-header",
                            title: "my-swal-title",
                            content: "my-swal-content",
                            confirmButton: "my-swal-confirm-button",
                            cancelButton: "my-swal-cancel-button-dieta",
                            closeButton: 'my-swal-close-button',
                            footer: 'my-swal-footer-dieta'
                        },
                        footer: '<a href="planes.php">Ver tipos de acceso</a>'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'perfil.php';
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            window.location.href = 'index.php';
                        }
                    });
                } else {
                    window.location.href = 'dieta-semana-por-dias.php';
                }
                 
            });
        });
    </script>