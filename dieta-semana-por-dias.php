
<?php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/dieta-semana-dias.css?v=' . filemtime('styles/dieta-semana-dias.css') . '">';
?>
<?php include 'header.php'; ?>

<!-- dieta semana organizada por dias -->

<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Dieta de la Semana</li>
        </ul>
    </div>
</div>

<!-- Contenido principal-->
 <section class="dieta-semana-por-dias"> 
<div class="dieta-semana">
    <div class="main-content">
        <div class="titulo">
            <img src="sources/iconos/semana.svg" alt="calendario semana">
            <h1>Dieta de la Semana </h1>
        </div>
        <!-- barra de navegación de opciones -->
        <div class="top-filters-bar">
            <div class="filter-section">
                <label for="ordenar">Vista por:</label>
                <select name="ordenar" id="ordenar">
                    <option value="des">Desayuno</option>
                    <option value="comida">Comida</option>
                    <option value="cena">Cena</option>
                    <option value="todo">Dieta completa</option>
                </select>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn-naranja">Generar nueva dieta</a>
            </div>
            <div class="filter-section">
                <a href="lista-semana.php" class="action-btn-rosa">Lista compra semanal</a>
            </div>
            <div class="filter-section">
                <a href="perfil-logueado.php" class="action-btn-verde">Editar perfil-salud</a>
            </div>
        </div>



        <div class="meal-schedule">
            <div class="instrucciones banner-redondeado">
                <h2>Indicaciones</h2>
                <p>Esta es una dieta semanal personalizada <b>exclusivamente para ti.</b></p>
                <p>Puedes ver los platos de cada día de la semana por franja del día. Puedes cambiar con el selector entre: <i>desayuno, comida, cena o la dieta completa.</i>
                    Si <b>haces clic</b> en una <b>la imagen de una receta</b> podrás ver la <b>ficha completa.</b></p>
                <p>Puedes <b>seleccionar en el día</b> de la semana para ver la <b> dieta completa</b> de ese día.</p>
                <p>¡Buen provecho!</p>
            </div>

            <!-- Barra de navegación de días (para móvil) -->
            <div class="mobile-day-nav">
                <button class="day-tab active" data-daynav="lunes">L</button>
                <button class="day-tab" data-daynav="martes">M</button>
                <button class="day-tab" data-daynav="miercoles">X</button>
                <button class="day-tab" data-daynav="jueves">J</button>
                <button class="day-tab" data-daynav="viernes">V</button>
                <button class="day-tab" data-daynav="sabado">S</button>
                <button class="day-tab" data-daynav="domingo">D</button>
            </div>

            <!-- Desayunos -->
            <div class="meal-time-row" data-tipo="desayuno">
                <div class="time-label">
                    <span>DESAYUNOS</span>
                </div>
                <div class="meal-container">

                    <div class="meal-item" data-day="lunes">
                        <a href="dieta-dia.php" title="Ves a la receta del lunes">
                            <h3>Lunes</h3>
                        </a>
                        <br>
                        <a href="detalle-receta" title="ver receta de Tortilla de Verduras con Avena sin Gluten"> <img src="sources/platos/id16.png" alt="Desayuno Lunes"></a>
                        <p>Tortilla de Verduras con Avena sin Gluten</p>
                    </div>
                    <div class="meal-item" data-day="martes">
                        <a href="dieta-dia.php" title="Ves a la receta del martes">
                            <h3>Martes</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id17.png" alt="Desayuno Martes">
                        <p>Avena cocida con plátano y canela</p>
                    </div>
                    <div class="meal-item" data-day="miercoles">
                        <a href="dieta-dia.php" title="Ves a la receta del miércoles">
                            <h3>Miércoles</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id23.png" alt="Desayuno Miércoles">
                        <p>Tortilla Vegana de Patatas con Crudités</p>
                    </div>
                    <div class="meal-item" data-day="jueves">
                        <a href="dieta-dia.php" title="Ves a la receta del jueves">
                            <h3>Jueves</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id27.png" alt="Desayuno Jueves">
                        <p>Batido Verde de Pera, Perejil y Proteína de Guisante</p>
                    </div>
                    <div class="meal-item" data-day="viernes">
                        <a href="dieta-dia.php" title="Ves a la receta del viernes">
                            <h3>Viernes</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id24.png" alt="Desayuno Viernes">
                        <p>Ensalada Dulce de Frutos Rojos, Kiwi y Almendras</p>
                    </div>
                    <div class="meal-item" data-day="sabado">
                        <a href="dieta-dia.php" title="Ves a la receta del sábado">
                            <h3>Sábado</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id22.png" alt="Desayuno Sábado">
                        <p>Tortitas de Plátano y Harina de Arroz</p>
                    </div>
                    <div class="meal-item" data-day="domingo">
                        <a href="dieta-dia.php" title="Ves a la receta del domingo">
                            <h3>Domingo</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id33.png" alt="Desayuno Domingo">
                        <p>Porridge de avena sin gluten con frutos rojos, chía y cúrcuma</p>
                    </div>
                </div>
            </div>

            <!-- Comidas - Entrantes -->
            <div class="meal-time-row" data-tipo="entrante">
                <div class="time-label">
                    <span>ENTRANTES</span>
                </div>
                <div class="meal-container">
                    <div class="meal-item" data-day="lunes">
                        <a href="dieta-dia.php" title="Ves a la receta del lunes">
                            <h3>Lunes</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id43.png" alt="Entrante Lunes">
                        <p>Crema fría de guisantes y menta</p>
                    </div>
                    <div class="meal-item" data-day="martes">
                        <a href="dieta-dia.php" title="Ves a la receta del martes">
                            <h3>Martes</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id44.png" alt="Entrante Martes">
                        <p>Gazpacho de Melón y Pepino con Hierbabuena</p>
                    </div>
                    <div class="meal-item" data-day="miercoles">
                        <a href="dieta-dia.php" title="Ves a la receta del miércoles">
                            <h3>Miércoles</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id45.png" alt="Entrante Miércoles">
                        <p>Crema fría de calabacín y manzana sin gluten</p>
                    </div>
                    <div class="meal-item" data-day="jueves">
                        <a href="dieta-dia.php" title="Ves a la receta del jueves">
                            <h3>Jueves</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id46.png" alt="Entrante Jueves">
                        <p>Sopa Juliana de Verduras Saludable</p>
                    </div>
                    <div class="meal-item" data-day="viernes">
                        <a href="dieta-dia.php" title="Ves a la receta del viernes">
                            <h3>Viernes</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id47.png" alt="Entrante Viernes">
                        <p>Ensalada de Remolacha, Naranja y Rúcula</p>
                    </div>
                    <div class="meal-item" data-day="sabado">
                        <a href="dieta-dia.php" title="Ves a la receta del sábado">
                            <h3>Sábado</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id48.png" alt="Entrante Sábado">
                        <p>Gazpacho de Remolacha y Yogur Natural</p>
                    </div>
                    <div class="meal-item" data-day="domingo">
                        <a href="dieta-dia.php" title="Ves a la receta del domingo">
                            <h3>Domingo</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id39.png" alt="Entrante Domingo">
                        <p>Chips de Alga Nori con Sésamo y Paté de Berenjena</p>
                    </div>
                </div>
            </div>

            <!-- Comidas - Platos Principales -->
            <div class="meal-time-row" data-tipo="principal">
                <div class="time-label">
                    <span>PRINCIPALES</span>
                </div>
                <div class="meal-container">
                    <div class="meal-item" data-day="lunes">

                        <img src="sources/platos/id26.png" alt="Principal Lunes">
                        <p>Bowl Macrobiótico de Mijo con Verduras y Tahini</p>
                    </div>
                    <div class="meal-item" data-day="martes">

                        <img src="sources/platos/id21.png" alt="Principal Martes">
                        <p>Rollitos de Pavo con Espinacas y Queso</p>
                    </div>
                    <div class="meal-item" data-day="miercoles">

                        <img src="sources/platos/id49.png" alt="Principal Miércoles">
                        <p>Rollitos de col rellenos de verduras con mayonesa de cilantro</p>
                    </div>
                    <div class="meal-item" data-day="jueves">

                        <img src="sources/platos/id50.png" alt="Principal Jueves">
                        <p>Tartaletas de Coliflor con Wok de Verduras y Salsa Cítrica</p>
                    </div>
                    <div class="meal-item" data-day="viernes">

                        <img src="sources/platos/id51.png" alt="Principal Viernes">
                        <p>Escalivada de Berenjena, Calabacín y Pimientos con Salsa de Granada</p>
                    </div>
                    <div class="meal-item" data-day="sabado">

                        <img src="sources/platos/id38.png" alt="Principal Sábado">
                        <p>Tostadas de Garbanzo Batido con Tomate y Orégano</p>
                    </div>
                    <div class="meal-item" data-day="domingo">

                        <img src="sources/platos/id34.png" alt="Principal Domingo">
                        <p>Tostadas de Boniato con Hummus y Tomates Cherry</p>
                    </div>
                </div>
            </div>

            <!-- Comidas - Postres -->
            <div class="meal-time-row" data-tipo="postre">
                <div class="time-label">
                    <span>POSTRES</span>
                </div>
                <div class="meal-container">
                    <div class="meal-item" data-day="lunes">
                        <img src="sources/platos/id20.png" alt="Postre Lunes">
                        <p>Pudding de Chía con Leche de Coco y Fruta</p>
                    </div>
                    <div class="meal-item" data-day="martes">
                        <img src="sources/platos/id19.png" alt="Postre Martes">
                        <p>Parfait de Yogur Griego con Frutas y Semillas</p>
                    </div>
                    <div class="meal-item" data-day="miercoles">
                        <img src="sources/platos/id40.png" alt="Postre Miércoles">
                        <p>Cereal crujiente horneado con yogur y uvas moscatel</p>
                    </div>
                    <div class="meal-item" data-day="jueves">
                        <img src="sources/platos/id41.png" alt="Postre Jueves">
                        <p>Gofre de Avena con Mermelada Casera de Cítricos y Chocolate 70%</p>
                    </div>
                    <div class="meal-item" data-day="viernes">
                        <img src="sources/platos/id35.png" alt="Postre Viernes">
                        <p>Crepes de Harina de Sorgo con Ricotta Vegana y Frutas del Bosque</p>
                    </div>
                    <div class="meal-item" data-day="sabado">
                        <img src="sources/platos/id37.png" alt="Postre Sábado">
                        <p>Pa de Pessic con Harina de Arroz y Kiwi Oro</p>
                    </div>
                    <div class="meal-item" data-day="domingo">
                        <img src="sources/platos/id30.png" alt="Postre Domingo">
                        <p>Smoothie Antiinflamatorio de Frutos Rojos, Aguacate y Colágeno</p>
                    </div>
                </div>
            </div>

            <!-- Cenas -->
            <div class="meal-time-row" data-tipo="cena">
                <div class="time-label">
                    <span>CENAS</span>
                </div>
                <div class="meal-container">
                    <div class="meal-item" data-day="lunes">
                        <a href="dieta-dia.php" title="Ves a la receta del lunes">
                            <h3>Lunes</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id29.png" alt="Cena Lunes">
                        <p>Tortilla de Espinacas con Aguacate y Cúrcuma</p>
                    </div>
                    <div class="meal-item" data-day="martes">
                        <a href="dieta-dia.php" title="Ves a la receta del martes">
                            <h3>Martes</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id18.png" alt="Cena Martes">
                        <p>Smoothie Verde de Espinacas, Plátano y Almendras</p>
                    </div>
                    <div class="meal-item" data-day="miercoles">
                        <a href="dieta-dia.php" title="Ves a la receta del miércoles">
                            <h3>Miércoles</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id25.png" alt="Cena Miércoles">
                        <p>Porridge de Mijo con Manzana y Canela</p>
                    </div>
                    <div class="meal-item" data-day="jueves">
                        <a href="dieta-dia.php" title="Ves a la receta del jueves">
                            <h3>Jueves</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id36.png" alt="Cena Jueves">
                        <p>Porridge de Copos de Arroz con Frutas y Semillas</p>
                    </div>
                    <div class="meal-item" data-day="viernes">
                        <a href="dieta-dia.php" title="Ves a la receta del viernes">
                            <h3>Viernes</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id42.png" alt="Cena Viernes">
                        <p>Muffins Salados con Té de Canela, Jengibre y Salvia</p>
                    </div>
                    <div class="meal-item" data-day="sabado">
                        <a href="dieta-dia.php" title="Ves a la receta del sábado">
                            <h3>Sábado</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id19.png" alt="Cena Sábado">
                        <p>Parfait de Yogur Griego con Frutas y Semillas</p>
                    </div>
                    <div class="meal-item" data-day="domingo">
                        <a href="dieta-dia.php" title="Ves a la receta del domingo">
                            <h3>Domingo</h3>
                        </a>
                        <br>
                        <img src="sources/platos/id20.png" alt="Cena Domingo">
                        <p>Pudding de Chía con Leche de Coco y Fruta</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="lista-semana.php" class="btn-opciones">Ver lista de la compra de la semana</a>
        <div class="premium-message">
            ¡Gracias por seguir apoyándonos siendo un usuario Prémium!
        </div>
        <br>
    </div>
</div>
</section>
<script src="scripts/dieta-semana.js"></script>
<?php include 'footer.php'; ?>