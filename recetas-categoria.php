<?php
$css_extra = '';
// se comparte esta hoja por estructura con recetas categoría
$css_extra .= '<link rel="stylesheet" href="styles/trucos.css?v=' . filemtime('styles/trucos.css') . '">';
?>
<?php include('header.php'); ?>



<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Trucos de cocina</li>
        </ul>
    </div>
</div>

<!-- Main Content -->
<section class="trucos-cocina">
    <div class="contenedor-categorias-recetas">
        <div class="titulo">
            <div class="container-trucos">

                <div class="titulo">
                    <img src="sources/iconos/Notes-Book-Text--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
                    <h1>Categoría de recetas</h1>
                </div>

                <div class="contenido-trucos">
                  <div class="intro">
 <p>Desde un desayuno energético para empezar el día, hasta el postre más dulce para acabarlo con una sonrisa. En esta sección encontrarás recetas saludables clasificadas por tipo de plato: ideas rápidas y nutritivas para el desayuno, entrantes ligeros que despiertan el apetito, platos principales completos y equilibrados, y postres que combinan sabor y bienestar. Cada tarjetón te llevará a un mundo de opciones adaptadas a tus gustos, necesidades y estilo de vida. ¡Elige por dónde empezar tu próxima comida saludable!</p>

                  </div>
                 
                  <article class="tarjeta-truco receta">
                        <img class="foto-truco" src="sources/platos/id41.png" alt="foto Desayuno" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Desayuno</h2>
                            <div class="tip-content">
                                <p>Empieza el día con energía y equilibrio. En nuestra categoría de desayunos encontrarás opciones saludables y deliciosas como porridge de avena sin gluten, tortitas de plátano y tostadas integrales con aguacate. Platos diseñados para nutrir cuerpo y mente desde la primera comida del día, aptos para todos los gustos y necesidades alimentarias.</div>
                        </div>
                    </article>

                    <article class="tarjeta-truco receta" >
                        <img class="foto-truco" src="sources/platos/entrante1.png" alt="fot entrante" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Entrante</h2>
                            <div class="tip-content">
                                <p>Abre el apetito con ideas ligeras y llenas de sabor. Desde ensaladas frescas hasta cremas suaves o rollitos vegetales, los entrantes de SalCooking están pensados para sorprender sin saturar. Son el complemento perfecto para comenzar una comida completa y saludable, adaptada a tus restricciones o intolerancias.</p>
                            </div>
                        </div>
                    </article>

                    <article class="tarjeta-truco receta">
                        <img class="foto-truco" src="sources/platos/principal1.png"" alt="fotro principal" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Plato principal</h2>
                            <div class="tip-content">
                                <p>Descubre recetas completas, equilibradas y adaptadas a distintos estilos de vida. Platos como lasañas de verduras, guisos veganos, carnes al horno o pescados con acompañamientos naturales, forman parte de esta selección pensada para cuidar tu salud sin renunciar al sabor. Perfectos para almuerzos o cenas nutritivas.</p>
                            </div>
                        </div>
                    </article>

                    <article class="tarjeta-truco receta">
                        <img class="foto-truco" src="sources/platos/postre3.png" alt="foto postre" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Postre</h2>
                            <div class="tip-content">
                                <p>El toque final ideal para cualquier menú. Aquí te esperan postres dulces y saludables como puddings de chía, parfaits con fruta fresca o bizcochos sin gluten ni azúcares añadidos. Disfruta del placer sin culpa con nuestras propuestas adaptadas incluso para personas con diabetes, colesterol o alergias.</p>
                            </div>
                        </div>
                    </article>

                  
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>