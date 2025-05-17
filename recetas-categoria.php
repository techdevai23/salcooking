
<?php
$css_extra = '';
// comparto la hoja de estilos de trucos.php
$css_extra .= '<link rel="stylesheet" href="styles/trucos.css?v=' . filemtime('styles/trucos.css') . '">';
?>

<?php include 'header.php'; ?>


<!-- migas -->

<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li class="current">Categoría Recetas</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>



<!-- Contenido principal-->
<section class="categorias-recetas">
  <div class="contenedor-categorias-recetas">

    <div class="titulo">
      <div class="container-trucos">

        <div class="titulo">
          <img src="sources/iconos/Navigation-Menu-1--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
          <h1>Categorias de recetas</h1>
        </div>

        <div class="contenido-trucos">
          <a href="resultado-recetas.php" class="tarjeta-receta">
            <img class="foto-truco" src="sources/platos/entrante1.png" alt="plato entrante" style="width: 150px;">
            <div class="texto-truco">
              <h2>Entrante</h2>
              <div class="tip-content">
                <p>Refrigera la cebolla durante 15 minutos antes de cortarla. El frío adormece las enzimas que liberan el gas irritante, ¡evitando el lagrimeo y haciendo el proceso mucho más agradable! Además, puedes cortar la cebolla bajo un chorro de agua fría para un efecto similar.</p>
              </div>
            </div>
          </a>

          <a href="resultado-recetas.php" class="tarjeta-receta">
            <img class="foto-truco" src="sources/platos/principal1.png" alt="plato principal" style="width: 150px;">
            <div class="texto-truco">
              <h2>Plato principal</h2>
              <div class="tip-content">
                <p>Rocía la superficie del aguacate con zumo de limón o lima. El ácido cítrico actúa como antioxidante, previniendo la oxidación y manteniendo su color verde vibrante y frescura por más tiempo. Este truco es ideal para guacamole o aguacates en ensaladas.</p>
              </div>
            </div>
          </a>

          <a href="resultado-recetas.php" class="tarjeta-receta">
            <img class="foto-truco" src="sources/platos/postre3.png" alt="ajo" style="width: 150px;">
            <div class="texto-truco">
              <h2>Postre</h2>
              <div class="tip-content">
                <p>Aplasta el diente de ajo con el lado plano de un cuchillo ancho. La presión afloja la piel, permitiendo que se desprenda fácilmente. Este método es rápido, eficiente y evita que tus manos se impregnen del fuerte olor a ajo. También puedes remojar los dientes de ajo en agua tibia durante unos minutos para ablandar la piel.</p>
              </div>
            </div>
          </a>


        </div>
      </div>
</section>

<?php include('footer.php'); ?>