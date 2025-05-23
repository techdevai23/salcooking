
<?php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/dieta-semana.css?v=' . filemtime('styles/dieta-semana.css') . '">';
?>
<?php include 'header.php'; ?>

<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Dieta del Día</li>
        </ul>
    </div>
</div>


<!-- Contenido principal-->
<section class="dieta-semana">
    <div class="main-content">
        <div class="titulo">
            <img src="sources/iconos/semana.svg" alt="calendario semana">
            <h1>Dieta del Día</h1>

        </div>

        <!-- barra de navegación de opciones -->
        <div class="top-filters-bar">
            <div class="filter-section">
                <a href="dieta-semana-por-dias.php" class="action-btn-naranja">Dieta de la semana</a>
            </div>
            <div class="filter-section">
                <a href="lista-semana.php" class="action-btn-rosa">Lista compra semanal</a>
            </div>

            <div class="filter-section">
                <a href="perfil-logueado.php" class="action-btn-verde">Editar perfil-salud</a>
            </div>
        </div>

        <!-- 2ª barra de navegación  -->
        <div class="top-filters-bar">


            <div class="filter-section">
                <a href="#" class="action-btn">Lunes</a>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn">Martes</a>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn">Miércoles</a>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn">Jueves</a>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn">Viernes</a>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn">Sábado</a>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn">Domingo</a>
            </div>

        </div>


        <!-- script que maneja la seleccion del desplegable -->
        <script>
            function selectorDesplegable(value) {
                if (value === "franjas") {
                    window.location.href = "dieta-semana3.php";
                } else if (value === "dias") {
                    window.location.href = "dieta-semana-por-dias.php";
                } else {
                    // No action needed for the default option
                }
            }
        </script>



        <!-- recetas -->

        <div class="meal-schedule">
            <div class="meal-section" id="izq">
                <h2>Desayuno</h2>
                <div class="meal-container">
                    <div class="meal-item"><img src="sources/platos/id17.png" alt="Desayuno Martes">
                        <h3>Lunes</h3>
                        <p>Yogur Natural con Copos de Avena y Plátano</p>
                    </div>

                </div>
            </div>

            <div class="meal-section">
                <h2>Comida</h2>
                <div class="meal-container">

                    <div class="meal-item"><img src="sources/platos/id33.png" alt="Almuerzo Martes">
                        <h3>Martes</h3>
                        <p>Lentejas Estofadas con Verduras</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id16.png" alt="Almuerzo Miércoles">
                        <h3>Miércoles</h3>
                        <p>Bonito a la plancha con Pimientos al Ajillo</p>
                    </div>

                    <div class="meal-item"><img src="sources/platos/id30.png" alt="Almuerzo Sábado">
                        <h3>Sábado</h3>
                        <p></p>
                    </div>

                </div>
            </div>

            <div class="meal-section" id="der">
                <h2>Cena</h2>
                <div class="meal-container">

                    <div class="meal-item"><img src="sources/platos/id26.png" alt="Cena lunes">
                        <h3>Lunes</h3>
                        <p>Bowl Macrobiótico de Mijo con Verduras y Tahini</p>
                    </div>

                </div>
            </div>
        </div>

        <a href="#" class="btn-opciones">Ver lista de ingredientes</a>
        <div class="premium-message">
            ¡Gracias por seguir apoyándonos siendo un usuario Prémium!
        </div>
        <br>
    </div>
</section>

<?php include 'footer.php'; ?>