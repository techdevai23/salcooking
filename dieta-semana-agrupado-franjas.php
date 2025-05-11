<?php
$css_extra = '<link rel="stylesheet" href="styles/dieta-semana.css">';
?>

<?php include 'header.php'; ?>
<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Dieta Semana (vista por franjas)</li>
        </ul>
    </div>
</div>


<!-- Contenido principal-->
<section class="dieta-semana">
    <div class="main-content">
        <div class="titulo">
            <img src="sources/iconos/semana.svg" alt="calendario semana">
            <h1>Dieta Semana</h1>
            <p>(vista por franjas)</p>
        </div>

        <!-- barra de navegación de opciones -->
        <div class="top-filters-bar">
            <div class="filter-section">
                <label for="ordenar">Agrupar por:</label>
                <select name="ordenar" id="ordenar" onchange="selectorDesplegable(this.value)">
                    <option value="">Seleccionar</option>
                    <option value="dias">Días</option>
                    <option value="franja">Franjas</option>
                    
                </select>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn">Generar nueva dieta</a>
            </div>
            <div class="filter-section">
                <a href="perfil.php" class="action-btn">Editar perfil</a>
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
                <h2>Mañana</h2>
                <div class="meal-container">
                    <div class="meal-item"><img src="sources/platos/id16.png" alt="Desayuno Lunes">
                        <h3>Lunes</h3>
                        <p>Tostadas Francesas con Fruta y Miel</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id17.png" alt="Desayuno Martes">
                        <h3>Martes</h3>
                        <p>Yogur Natural con Copos de Avena y Plátano</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id23.png" alt="Desayuno Miércoles">
                        <h3>Miércoles</h3>
                        <p>Pan de Avena con Semillas</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id27.png" alt="Desayuno Jueves">
                        <h3>Jueves</h3>
                        <p>Bizcocho de Avena y Manzana</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id24.png" alt="Desayuno Viernes">
                        <h3>Viernes</h3>
                        <p>Ensalada Dulce de Frutos Rojos, Kiwi y Almendras</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id22.png" alt="Desayuno Sábado">
                        <h3>Sábado</h3>
                        <p>Cheesecake de Frutos Rojos</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id32.png" alt="Desayuno Domingo">
                        <h3>Domingo</h3>
                        <p>Flan de Huevo Casero</p>
                    </div>
                </div>
            </div>

            <div class="meal-section">
                <h2>Tarde</h2>
                <div class="meal-container">
                    <div class="meal-item"><img src="sources/platos/id15.png" alt="Almuerzo Lunes">
                        <h3>Lunes</h3>
                        <p>Arroz Integral con Verduras y Tofu</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id33.png" alt="Almuerzo Martes">
                        <h3>Martes</h3>
                        <p>Lentejas Estofadas con Verduras</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id16.png" alt="Almuerzo Miércoles">
                        <h3>Miércoles</h3>
                        <p>Bonito a la plancha con Pimientos al Ajillo</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id21.png" alt="Almuerzo Jueves">
                        <h3>Jueves</h3>
                        <p>Pechuga de Pavo a la Plancha con Arroz</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id25.png" alt="Almuerzo Viernes">
                        <h3>Viernes</h3>
                        <p>Lubina al Horno con Escalibada</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id30.png" alt="Almuerzo Sábado">
                        <h3>Sábado</h3>
                        <p>Hamburguesa Vegetal con Patatas al Horno</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id20.png" alt="Almuerzo Domingo">
                        <h3>Domingo</h3>
                        <p>Paella de Verduras y Marisco</p>
                    </div>
                </div>
            </div>

            <div class="meal-section" id="der">
                <h2>Noche</h2>
                <div class="meal-container">
                    <div class="meal-item"><img src="sources/platos/id29.png" alt="Cena Lunes">
                        <h3>Lunes</h3>
                        <p>Crema de Champiñones Ligera</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id4.png" alt="Cena Martes">
                        <h3>Martes</h3>
                        <p>Merluza al Horno con Limón y Patatas</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id44.png" alt="Cena Miércoles">
                        <h3>Miércoles</h3>
                        <p>Crema de Calabacín con Pipas Tostadas</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id18.png" alt="Cena Jueves">
                        <h3>Jueves</h3>
                        <p>Ensalada César con Pollo a la Plancha</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id26.png" alt="Cena Viernes">
                        <h3>Viernes</h3>
                        <p>Salmón al Horno con Eneldo y Limón</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id19.png" alt="Cena Sábado">
                        <h3>Sábado</h3>
                        <p>Sopa de Pollo con Fideos Integrales</p>
                    </div>
                    <div class="meal-item"><img src="sources/platos/id16.png" alt="Cena Domingo">
                        <h3>Domingo</h3>
                        <p>Pizza Casera de Masa Integral</p>
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