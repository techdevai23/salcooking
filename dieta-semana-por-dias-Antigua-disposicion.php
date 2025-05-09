<?php
$css_extra = '<link rel="stylesheet" href="styles/dieta-semana-combinada.css">';
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
<div class="dieta-semana">
    <div class="main-content">
        <div class="titulo">
            <img src="images/iconos/semana.svg" alt="calendario semana">
            <h1>Dieta de la Semana</h1>

        </div>
        <!-- barra de navegación de opciones -->
        <div class="top-filters-bar">
            <div class="filter-section">
                <label for="ordenar">Vista por:</label>
                <select name="ordenar" id="ordenar" onchange="selectorDesplegable(this.value)">
                    <option value="des">Desayuno</option>
                    <option value="comida">Comida</option>
                    <option value="cena">Cena</option>
                </select>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn-naranja">Generar nueva dieta</a>
            </div>
            <div class="filter-section">
                <a href="lista-semana.php" class="action-btn-rosa">Lista compra semanal</a>
            </div>
            <div class="filter-section">
                <a href="perfil.php" class="action-btn-verde">Editar perfil-salud</a>
            </div>
        </div>
        <!-- script que maneja la seleccion del desplegable -->
        <script>
            function selectorDesplegable(value) {
                if (value === "franja") {
                    window.location.href = "dieta-semana3.php";
                } else if (value === "dias") {
                    window.location.href = "dieta-semana-por-dias.php";
                } else {
                    // No action needed for the default option
                }
            }
        </script>

        <div class="meal-schedule">
           
            <!-- Cabecera con días de la semana -->
            <div class="week-header">
                <div class="time-label" style="background-color: rgba(242, 234, 223, 0) !important;"></div>
                <h2>Lunes</h2>
                <h2>Martes</h2>
                <h2>Miércoles</h2>
                <h2>Jueves</h2>
                <h2>Viernes</h2>
                <h2>Sábado</h2>
                <h2>Domingo</h2>
            </div>

            <!-- Desayunos (Mañana) -->
            <div class="meal-time-row">
                <div class="time-label">
                    <span>DESAYUNOS</span>
                </div>
                <div class="meal-container">
                    <div class="meal-item">
                        <img src="images/platos/id16.png" alt="Desayuno Lunes">
                        <p>Tostadas Francesas con Fruta y Miel</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id17.png" alt="Desayuno Martes">
                        <p>Yogur Natural con Copos de Avena y Plátano</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id23.png" alt="Desayuno Miércoles">
                        <p>Pan de Avena con Semillas</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id27.png" alt="Desayuno Jueves">
                        <p>Bizcocho de Avena y Manzana</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id24.png" alt="Desayuno Viernes">
                        <p>Ensalada Dulce de Frutos Rojos, Kiwi y Almendras</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id22.png" alt="Desayuno Sábado">
                        <p>Cheesecake de Frutos Rojos</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id32.png" alt="Desayuno Domingo">
                        <p>Flan de Huevo Casero</p>
                    </div>
                </div>
            </div>

            <!-- Almuerzos (Tarde) -->
            <div class="meal-time-row">
                <div class="time-label">
                    <span>COMIDAS</span>
                </div>
                <div class="meal-container">
                    <div class="meal-item">
                        <img src="images/platos/id15.png" alt="Almuerzo Lunes">
                        <p>Arroz Integral con Verduras y Tofu</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id33.png" alt="Almuerzo Martes">
                        <p>Lentejas Estofadas con Verduras</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id16.png" alt="Almuerzo Miércoles">
                        <p>Bonito a la plancha con Pimientos al Ajillo</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id21.png" alt="Almuerzo Jueves">
                        <p>Pechuga de Pavo a la Plancha con Arroz</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id25.png" alt="Almuerzo Viernes">
                        <p>Lubina al Horno con Escalibada</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id30.png" alt="Almuerzo Sábado">
                        <p>Hamburguesa Vegetal con Patatas al Horno</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id20.png" alt="Almuerzo Domingo">
                        <p>Paella de Verduras y Marisco</p>
                    </div>
                </div>
            </div>

            <!-- Cenas (Noche) -->
            <div class="meal-time-row">
                <div class="time-label">
                    <span>CENAS</span>
                </div>
                <div class="meal-container">
                    <div class="meal-item">
                        <img src="images/platos/id29.png" alt="Cena Lunes">
                        <p>Crema de Champiñones Ligera</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id4.png" alt="Cena Martes">
                        <p>Merluza al Horno con Limón y Patatas</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id44.png" alt="Cena Miércoles">
                        <p>Crema de Calabacín con Pipas Tostadas</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id18.png" alt="Cena Jueves">
                        <p>Ensalada César con Pollo a la Plancha</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id26.png" alt="Cena Viernes">
                        <p>Salmón al Horno con Eneldo y Limón</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id19.png" alt="Cena Sábado">
                        <p>Sopa de Pollo con Fideos Integrales</p>
                    </div>
                    <div class="meal-item">
                        <img src="images/platos/id16.png" alt="Cena Domingo">
                        <p>Pizza Casera de Masa Integral</p>
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

<?php include 'footer.php'; ?>