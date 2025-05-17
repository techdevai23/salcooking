<?php
// header.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalCooking - Menús personalizados e inteligentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
      <!-- Google Fonts con Copse (titulos y que usamos en el logo), Poppins(textos) y Nunito(botones) -->
  <link href="https://fonts.googleapis.com/css2?family=Copse&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <!-- // Font Awesome para iconos -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- icono web -->
        <link rel="icon" type="image/png" href="sources/logos/icono-salcooking.ico">
     <!-- hago un truco para evitar problemas de caché que pueden volver loco pensando que no
      se actualizan los cambios -->
    <link rel="stylesheet" href="styles/styles.css?v=<?php echo filemtime('styles/styles.css'); ?>">
<script src="scripts/descargarListaPDF.js?v=<?php echo filemtime('scripts/descargarListaPDF.js'); ?>"></script>

    <!-- cargo hoja de estilos propias -->
    <?php
if (!isset($css_extra)) $css_extra = '';
if (isset($css_extra)) echo $css_extra;
?>


</head>

<body>
<!-- tener en cuenta la vision de la cabecera en versión escritorio y movil -->
    <header class="main-header">
        <!-- logotipo principal -->
        <div class="logo-cabecera">
            <a href="index.php"><img src="sources/logos/logo salcooking alargado.png" title="Ir al inicio" alt="SalCooking cabecera Logo">
        <img src="sources/logos/s" alt="">
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
                </ul>
            </div>
            <!-- Contenedor principal - Elementos comunes -->
            <div class="container mb-3">
                <div class="header-content">
                    <!-- logotipo para ver el menu completo -->
                    <div class="logo d-none d-md-block">
                        <img src="sources/logos/logo.png" title="Accede a todas las secciones"" alt="SalCooking Logo">
                    </div>
                    <!-- barra de búsqueda -->
                    <div class="search-box">
                        <form action="resultado-recetas.php" method="get">
                            <input type="text" placeholder="Busca recetas" name="query">
                            <button type="submit"><img src="sources/iconos/Search-Circle--Streamline-Ultimate.svg" width="28px" alt="búsqueda Icon" ></button>
                        </form>
                    </div>
                    <!-- boton premium -->
                    <div class="premium-button">
                        <a href="perfil.php" class="btn-premium">Hazte Prémium</a>
                    </div>
                    <!-- icono de usuario con enlace a web de usuario -->
                    <div class="header-actions">
                        <div class="user-icon">
                            <a href="login.php"><img src="sources/iconos/Single-Neutral-Circle--Streamline-Ultimate.svg" alt="User Icon"width= "34px "></a>
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
    <!-- menú en tamaño pequeño -->
    <nav class="mobile-nav">
        <ul>
            <li class="active"><a href="index.php">Inicio</a></li>
            <li><a href="filosofia.php">Nuestra Filosofía</a></li>
            <li><a href="recetas-categoria.php">Categorías de Recetas</a></li>
            <li><a href="dieta-semana-por-dias.php">Dietas</a></li>
            <li><a href="trucos.php">Trucos de cocina</a></li>
            <li><a href="planes.php">Planes</a></li>
            <li><a href="ayuda.php">Ayuda</a></li>
            <li><a href="contacto.php">Contáctanos</a></li>
            
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
        <li class="cabecera" >ZONA PRÉMIUM</li>
        <!-- solo boton de selecccion no redirección -->
        <li class="cabecera">PERFILES</li>
        <li>
            <label>
                <input type="radio" name="perfil" id="input-menu" value="principal" checked>
                Perfil principal
            </label>
        </li>
        <li>
            <label>
                <input type="radio" name="perfil" value="secundario">
                Perfil secundario
            </label>
        </li>
        <li class="cabecera" >DIETAS</li>
        <li><a href="dieta-semana-por-dias.php">Dieta semanal</a></li>
        <li><a href="dieta-dia.php" >Dieta del día</a></li>
        <li><a href="lista-semana.php">Lista de la compra semanal</a></li>
    <li><a href="lista-dia.php">Lista de la compra del día</a></li>
    <hr style="border: 0.5px solid #ccc; margin: 0;">
    <li class="cabecera" >INFORMACIÓN</li>
    <li><a href="filosofia.php">Nuestra filosofía</a></li>
        <li><a href="contacto.php">Contáctanos</a></li>
        <li><a href="ayuda.php">Ayuda</a></li>
        <li><a href="planes.php">Planes</a></li>
        <hr style="border: 0.5px solid #ccc; margin: 0;">
        <li class="cabecera" >GESTIÓN DE CUENTA</li>
    <li><a href="login.php">Login</a></li>
     <li><a href="perfil.php">Perfil-Ajustes</a></li>
        <li><a href="cambio-pass.php">Cambio de contraseña</a></li>
        <li><a href="accion-completada.php">Cerrar sesión</a></li>


    </ul>
</div>