<?php include 'header.php'; ?>
<?php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/plantilla.css?v=' . filemtime('styles/plantilla.css') . '">';
?>





<!-- migas -->

<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li class="current">nombre-landing</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
    </div>
  </div>
</div>



<!-- Contenido principal-->
<section class="nombre-landing">
    <div class="contenedor-nombre-landing">

    <div class="titulo">
  <img src="sources/iconos/Book-Star--Streamline-Ultimate.svg"  alt="Book Star - Libro destacado">
  <h1>Plantilla: Nombre de la landing</h1>
  </div>
       
    <div class="contenido-nombre-landing">
        <p>Texto de la landing</p>

    <p>Texto de la landing</p>

    <!-- div contenido -->
    </div>

    
   

    <!-- ultimo div contenedor principal -->
    </div>
</section>

<?php include 'footer.php'; ?>