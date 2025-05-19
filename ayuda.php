<?php
$css_extra = '';

$css_extra .= '<link rel="stylesheet" href="styles/ayuda.css?v=' . filemtime('styles/ayuda.css') . '">';
?>


<?php include 'header.php'; ?>

<!-- migas -->

<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li class="current">Ayuda</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
    </div>
  </div>
</div>



<!-- Contenido principal-->
<section class="Ayuda">
    <div class="contenedor-Ayuda">

    <div class="titulo">
  <img src="sources/iconos/Headphones-Customer-Support-Question--Streamline-Ultimate.svg"  alt="Book Star - Libro destacado">
  <h1>Ayuda</h1>
  </div>
       
    <div class="contenido-Ayuda">
        
    <img src="sources/iconos/Information-Circle--Streamline-Ultimate.svg"  alt="Book Star - Libro destacado">
    <img src="sources/iconos/Question-Help-Message--Streamline-Ultimate.svg"  alt="Book Star - Libro destacado">
 
    <p>Texto de la Ayuda</p>

    <!-- div contenido -->
    </div>

    
   

    <!-- ultimo div contenedor principal -->
    </div>
</section>

<?php include 'footer.php'; ?>