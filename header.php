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

     <!-- hago un truco para evitar problemas de caché que pueden volver loco pensando que no
      se actualizan los cambios -->
    <link rel="stylesheet" href="styles/styles.css?v=<?php echo filemtime('styles/styles.css'); ?>">
<script src="scripts/descargarListaPDF.js?v=<?php echo filemtime('scripts/descargarListaPDF.js'); ?>"></script>

    <!-- cargo hoja de estilos propias -->
    <?php if (isset($css_extra)) echo $css_extra; ?>


</head>

<body>
    <header class="main-header">
        <div class="logo-cabecera">
            <a href="index.php"><img src="images/logos/cabecera.png" alt="SalCooking cabecera Logo"></a>
        </div>
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
                    <li><a href="contacto.php">Contacto</a></li>
                </ul>
            </div>
            <div class="container mb-3">
                <div class="header-content">
                    <div class="logo d-none d-md-block">
                        <a href="index.php"><img src="images//logos/logo.png" alt="SalCooking Logo"></a>
                    </div>
                    <div class="search-box">
                        <form action="resultado-recetas.php" method="get">
                            <input type="text" placeholder="Busca recetas" name="query">
                            <button type="submit"><img src="images/iconos/Search-Circle--Streamline-Ultimate.svg" alt="User Icon" style="width: 24px; height: 24px;"></button>
                        </form>
                    </div>
                    <div class="premium-button">
                        <a href="contacto.php" class="btn-premium">Hazte Premium</a>
                    </div>
                    <!-- icono de usuario con enlace a web de usuario -->
                    <div class="header-actions">

                        <div class="user-icon">
                            <a href="login.php"><img src="images/iconos/Single-Neutral-Circle--Streamline-Ultimate.svg" alt="User Icon" style="width: 34px; height: 34px;"></a>
                        </div>
                    </div>


                    <div class="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <nav class="mobile-nav">
        <ul>
            <li class="active"><a href="index.php">Inicio</a></li>
            <li><a href="filosofia.php">Nuestra Filosofía</a></li>
            <li><a href="recetas.php">Recetas</a></li>
            <li><a href="dieta.php">Dieta</a></li>
            <li><a href="trucos.php">Trucos</a></li>
            <li><a href="planes.php">Planes</a></li>
            <li><a href="ayuda.php">Ayuda</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="profile.php">Editar Perfil</a></li>
        </ul>
    </nav>