<?php
$css_extra = '';
// se comparte esta hoja por estructura con recetas categoría
$css_extra .= '<link rel="stylesheet" href="styles/trucos.css?v=' . filemtime('styles/trucos.css') . '">';
?>
<?php include('header.php'); 
// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['redirect_after_login'] = 'dieta-semana-por-dias.php';
    header('Location: loginPaginaReservada.php');
    exit;
}




?>



<!-- migas -->
<div class="migas-container">
    <div class="container migas-flex">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Trucos de cocina</li>
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
                    <h1>Trucos de cocina</h1>
                </div>

                <div class="contenido-trucos">
                    <article class="tarjeta-truco">
                        <img class="foto-truco" src="sources/recursos/CEBOLLA.jpg" alt="cebolla" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Adiós, lágrimas de cebolla</h2>
                            <div class="tip-content">
                                <p>Refrigera la cebolla durante 15 minutos antes de cortarla. El frío adormece las enzimas que liberan el gas irritante, ¡evitando el lagrimeo y haciendo el proceso mucho más agradable! Además, puedes cortar la cebolla bajo un chorro de agua fría para un efecto similar.</p>
                            </div>
                        </div>
                    </article>

                    <article class="tarjeta-truco">
                        <img class="foto-truco" src="sources/recursos/aguacate.jpg" alt="aguacate" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Aguacate, siempre perfecto</h2>
                            <div class="tip-content">
                                <p>Rocía la superficie del aguacate con zumo de limón o lima. El ácido cítrico actúa como antioxidante, previniendo la oxidación y manteniendo su color verde vibrante y frescura por más tiempo. Este truco es ideal para guacamole o aguacates en ensaladas.</p>
                            </div>
                        </div>
                    </article>

                    <article class="tarjeta-truco">
                        <img class="foto-truco" src="sources/recursos/ajo.jpg" alt="ajo" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Ajo, pelado veloz</h2>
                            <div class="tip-content">
                                <p>Aplasta el diente de ajo con el lado plano de un cuchillo ancho. La presión afloja la piel, permitiendo que se desprenda fácilmente. Este método es rápido, eficiente y evita que tus manos se impregnen del fuerte olor a ajo. También puedes remojar los dientes de ajo en agua tibia durante unos minutos para ablandar la piel.</p>
                            </div>
                        </div>
                    </article>

                    <article class="tarjeta-truco">
                        <img class="foto-truco" src="sources/recursos/olla QUE SE ECHA SAL.webp" alt="ajo" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Pasta perfecta</h2>
                            <div class="tip-content">
                                <p>Añade sal al agua solo cuando esté hirviendo, justo antes de echar la pasta. Esto eleva el punto de ebullición del agua y condimenta la pasta desde dentro. Además, reserva un poco del agua de cocción para añadir a la salsa: el almidón ayudará a que la salsa se adhiera mejor a la pasta.</p>
                            </div>
                        </div>
                    </article>

                    <article class="tarjeta-truco">
                        <img class="foto-truco" src="sources/recursos/carne reposo.webp" alt="ajo" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Carnes jugosas a la parrilla</h2>
                            <div class="tip-content">
                                <p>Deja reposar la carne a temperatura ambiente durante 20-30 minutos antes de cocinarla. Esto permite una cocción más uniforme. Después de cocinarla, déjala reposar otros 5-10 minutos antes de cortarla para que los jugos se redistribuyan, obteniendo una carne más jugosa y sabrosa.</p>
                            </div>
                        </div>
                    </article>

                    <article class="tarjeta-truco">
                        <img class="foto-truco" src="sources/recursos/huevo agua.webp" alt="ajo" style="width: 150px;">
                        <div class="texto-truco">
                            <h2>Huevos frescos vs. antiguos</h2>
                            <div class="tip-content">
                                <p>Para comprobar la frescura de un huevo, sumérgelo en un vaso de agua. Si se hunde y queda en horizontal, está muy fresco. Si se hunde pero queda en vertical, sigue siendo bueno pero no tan fresco. Si flota, mejor descártalo. Esta diferencia se produce porque la cámara de aire del huevo aumenta con el tiempo.</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>