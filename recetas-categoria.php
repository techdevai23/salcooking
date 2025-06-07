<?php
$css_extra = '';
// se comparte esta hoja por estructura con recetas categoría
$css_extra .= '<link rel="stylesheet" href="styles/trucos.css?v=' . filemtime('styles/trucos.css') . '">';
?>
<?php include('header.php'); ?>



<!-- migas -->
<div class="migas-container">
    <div class="container migas-flex">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Categoría de recetas</li>

        </ul>
        <div class="volver-atras-contenedor">
            <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
        </div>
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
                        <h4>Todas nuestras recetas son <u>exclusivas</u>, no las encontrarás en ningún otro sitio.</h4>
                        <p>Desde un desayuno energético para empezar el día, hasta el postre más dulce para acabarlo con una sonrisa.</p>
                        <p>En esta sección encontrarás <strong>recetas saludables</strong> clasificadas por tipo de plato: ideas rápidas y nutritivas para el desayuno,
                            entrantes ligeros que despiertan el apetito, platos principales completos y equilibrados, y postres que combinan sabor y bienestar.</p>
                        <p>Cada categoríate llevará a un mundo de opciones adaptadas a tus gustos, necesidades y estilo de vida.</p>

                        <h4>¡Elige por dónde empezar tu próxima comida saludable!</h4>
                    </div>

                    <article class="tarjeta-truco receta">

                        <img class="foto-truco" src="sources/platos/id41.png" alt="foto Desayuno" style="width: 150px;">

                        <div class="texto-truco">

                            <h2>Desayuno</h2>
                            <div class="tip-content">
                                <a href="index.php?page=buscar&tipo_plato=desayuno" class="tarjeta-receta">
                                    <p>Empieza el día con energía y equilibrio. En nuestra categoría de desayunos encontrarás opciones saludables
                                        y deliciosas como porridge de avena sin gluten, tortitas de plátano y tostadas integrales con aguacate.
                                        Platos diseñados para nutrir cuerpo y mente desde la primera comida del día, aptos para todos los gustos y necesidades alimentarias.</p>
                                    <img src="sources/iconos/Add-Circle-Bold--Streamline-Ultimate.svg" alt="Más información" title="Descubre todos nuestros desayunos">
                                </a>
                            </div>

                        </div>


                    </article>


                    <article class="tarjeta-truco receta">

                        <img class="foto-truco" src="sources/platos/entrante1.png" alt="fot entrante" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Entrante</h2>
                            <div class="tip-content">
                                <a href="index.php?page=buscar&tipo_plato=entrante" class="tarjeta-receta">
                                    <p>Abre el apetito con ideas ligeras y llenas de sabor. Desde ensaladas frescas hasta cremas suaves o rollitos vegetales, los entrantes de SalCooking están pensados para sorprender sin saturar. Son el complemento perfecto para comenzar una comida completa y saludable, adaptada a tus restricciones o intolerancias.</p>
                                    <img src="sources/iconos/Add-Circle-Bold--Streamline-Ultimate.svg" alt="Más información" title="Descubre todos nuestros entrantes">

                                </a>
                            </div>
                        </div>

                    </article>

                    <article class="tarjeta-truco receta">

                        <img class="foto-truco" src="sources/platos/principal1.png"" alt=" fotro principal" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Plato principal</h2>
                            <div class="tip-content">
                                <a href="index.php?page=buscar&tipo_plato=principal" class="tarjeta-receta">
                                    <p>Descubre recetas completas, equilibradas y adaptadas a distintos estilos de vida. Platos como lasañas de verduras, guisos veganos, carnes al horno o pescados con acompañamientos naturales, forman parte de esta selección pensada para cuidar tu salud sin renunciar al sabor. Perfectos para almuerzos o cenas nutritivas.</p>
                                    <img src="sources/iconos/Add-Circle-Bold--Streamline-Ultimate.svg" alt="Más información" title="Descubre todos nuestros platos principales">
                                </a>
                            </div>
                        </div>

                    </article>

                    <article class="tarjeta-truco receta">

                        <img class="foto-truco" src="sources/platos/postre3.png" alt="foto postre" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Postre</h2>
                            <div class="tip-content">
                                <a href="index.php?page=buscar&tipo_plato=postre" class="tarjeta-receta">
                                    <p>El toque final ideal para cualquier menú. Aquí te esperan postres dulces y saludables como puddings de chía, parfaits con fruta fresca o bizcochos sin gluten ni azúcares añadidos. Disfruta del placer sin culpa con nuestras propuestas adaptadas incluso para personas con diabetes, colesterol o alergias.</p>
                                    <img src="sources/iconos/Add-Circle-Bold--Streamline-Ultimate.svg" alt="Más información" title="Descubre todos nuestros postres">
                                </a>
                            </div>
                        </div>

                    </article>


                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>