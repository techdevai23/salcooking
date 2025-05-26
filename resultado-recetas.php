<?php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/resultado-recetas.css?v=' . filemtime('styles/resultado-recetas.css') . '">';
?>

<?php include('header.php'); ?>

<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="recetas-categoria.php">Receta</a></li>
            <li class="current">Resultados de Recetas</li>
        </ul>
    </div>
</div>

<!-- Contenido principal-->
<section class="resultados-recetas">
    <div class="container-resultados">
        <div class="titulo">
            <img src="sources/iconos/Search-Circle--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
            <h1>Resultados de Recetas</h1>
            <?php if (!empty($resultados)): ?>
                <p class="contador-resultados">Se encontraron <?= count($resultados) ?> receta<?= count($resultados) > 1 ? 's' : '' ?></p>
            <?php endif; ?>
        </div>
        <div class="page-background">
            <div class="content-wrapper">
                <div class="results-container">

                    <!-- Tu barra de filtros normal + prémium -->
                    <!-- Barra de filtros superior -->
                    <div class="top-filters-bar">
                        <div class="filter-section">
                            <label for="ordenar">Ordenar:</label>
                            <select name="ordenar" id="ordenar">
                                <option value="">Más recientes</option>
                                <option value="nombre-asc">Nombre (A-Z)</option>
                                <option value="nombre-desc">Nombre (Z-A)</option>
                                <option value="ing-menos-6">Ingredientes (menos de 6)</option>
                                <option value="ing-7-10">Ingredientes (7-10)</option>
                                <option value="ing-mas-10">Ingredientes (más de 10)</option>
                            </select>
                        </div>

                        <div class="filter-section checkbox-group">
                            <h6>Tipo de plato:</h6>
                            <div class="checkbox-options">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="tipo-plato[]" value="desayuno">
                                    <span class="checkmark"></span>
                                    Desayuno
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="tipo-plato[]" value="entrante">
                                    <span class="checkmark"></span>
                                    Entrante
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="tipo-plato[]" value="principal">
                                    <span class="checkmark"></span>
                                    Principal
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="tipo-plato[]" value="postre">
                                    <span class="checkmark"></span>
                                    Postre
                                </label>
                            </div>
                        </div>

                        <div class="filter-section checkbox-group">
                            <h6>Evitar alérgenos:</h6>
                            <div class="checkbox-options">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="alergenos[]" value="1">
                                    <span class="checkmark"></span>
                                    Frutos secos
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="alergenos[]" value="2">
                                    <span class="checkmark"></span>
                                    Gluten
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="alergenos[]" value="3">
                                    <span class="checkmark"></span>
                                    Pescado y Marisco
                                </label>
                            </div>
                        </div>

                        <div class="filter-section checkbox-group">
                            <h6>Porciones:</h6>
                            <div class="checkbox-options">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="porciones[]" value="2">
                                    <span class="checkmark"></span>
                                    2 porciones
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="porciones[]" value="4">
                                    <span class="checkmark"></span>
                                    4 porciones
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="porciones[]" value="mas-4">
                                    <span class="checkmark"></span>
                                    Más de 4
                                </label>
                            </div>
                        </div>
                        <!--********** zona de filtros y opciones premium *********** -->
                        <div class="premium-filters">
                            <!-- Debug temporal -->
                            <?php
                            // echo "<!-- Debug: id_usuario = " . (isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 'NO SET') . " -->";
                            // echo "<!-- Debug: disabled = " . (!isset($_SESSION['id_usuario']) ? 'disabled' : 'enabled') . " -->";
                            ?>
                            <div class="premium-header" title="Despliega para ver los filtros">
                                <h4>Filtros Premium </h4>
                                <img src="sources/iconos/Vip-Circle--Streamline-Ultimate.png" alt="info" class="info-icon" title="Funcionalidades exclusivas para usuarios Prémium" style="width:40px; height:40px;">
                                <?php if (!isset($_SESSION['id_usuario'])): ?>
                                    <a href="contacto.php" title="Solo puedes ganar: Hazte Prémium" class="btn-premium">Hazte Prémium</a>
                                <?php else: ?>
                                    <span class="usuario-premium">¡Funciones Premium Activas!</span>
                                <?php endif; ?>
                            </div>
                            <div class="premium-options">
                                <!-- Aqui van el filtro de ingredientes, enfermedades y tiempo de preparación -->
                                 <!-- ingredientes -->
                                <div class="premium-option">
                                    <input type="text" name="ingrediente" id="ingrediente" placeholder="Filtrar por ingrediente..." <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                </div>
                                    <!-- enfermedades -->
                                <div class="premium-option checkbox-group">
                                    <h6>Enfermedades a evitar:</h6>
                                    <div class="checkbox-options">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="enfermedades[]" value="1" <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                            <span class="checkmark"></span>
                                            Diabetes
                                        </label>
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="enfermedades[]" value="2" <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                            <span class="checkmark"></span>
                                            Colesterol alto
                                        </label>
                                    </div>
                                </div>

                                                                    <!-- Tiempo de preparación -->
                                <div class="premium-option checkbox-group">
                                    <h6>Tiempo de preparación:</h6>
                                    <div class="checkbox-options">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="tiempo[]" value="menos-30" <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                            <span class="checkmark"></span>
                                            30 min o menos
                                        </label>
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="tiempo[]" value="31-60" <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                            <span class="checkmark"></span>
                                            Entre 31-60 min
                                        </label>
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="tiempo[]" value="mas-60" <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                            <span class="checkmark"></span>
                                            Más de 60 min
                                        </label>
                                    </div>
                                </div>
                                <!-- Checkbox de perfil de salud -->
                                <!-- <div class="premium-option">
                                    <label class="checkbox-container">
                                        <input type="checkbox" name="perfil" id="perfil" value="1" <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                        <span class="checkmark"></span>
                                        Tener en cuenta mi perfil de salud
                                    </label>
                                </div> -->

                             

                            </div>
                        </div>
                    </div>

                    <!-- Carrusel dinámico -->
                    <div class="recipiente-carrusel-container">
                        <button class="carrusel-nav prev-btn">&lt;</button>
                        <div class="recipiente-carrusel">
                            <?php if (!empty($resultados)): ?>
                                <?php
                                $totalRecetas = count($resultados);
                                // Creamos exactamente 5 posiciones para las tarjetas
                                $posicionesCarrusel = ['left-2', 'left-1', 'center', 'right-1', 'right-2'];
                                ?>
                                <!-- Posición izquierda 2 (oculta inicialmente) -->
                                <div class="recipiente-card side-card hidden" data-position="left-2">
                                    <a href="#" class="btn-view-recipiente">Ver receta</a>
                                    <img src="" alt="">
                                    <div class="recipiente-info">
                                        <h4></h4>
                                        <div class="recipiente-tags"></div>
                                    </div>
                                </div>

                                <!-- Posición izquierda 1 (oculta inicialmente) -->
                                <div class="recipiente-card side-card hidden" data-position="left-1">
                                    <a href="#" class="btn-view-recipiente">Ver receta</a>
                                    <img src="" alt="">
                                    <div class="recipiente-info">
                                        <h4></h4>
                                        <div class="recipiente-tags"></div>
                                    </div>
                                </div>

                                <!-- Posición central (primera receta) -->
                                <?php if (isset($resultados[0])): ?>
                                    <div class="recipiente-card featured-card" data-position="center" data-recipe-index="0">
                                        <a href="index.php?page=detalle-receta&id=<?= $resultados[0]['id'] ?>" class="btn-view-recipiente">Ver receta</a>
                                        <?php
                                        $imagePath = "sources/platos/id{$resultados[0]['id']}.png";
                                        $imageUrl = file_exists($imagePath) ? $imagePath : "sources/platos/default.png";
                                        ?>
                                        <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($resultados[0]['nombre']) ?>">
                                        <div class="recipiente-info">
                                            <h4><?= htmlspecialchars($resultados[0]['nombre']) ?></h4>
                                            <div class="recipiente-tags">
                                                <?php if (!empty($resultados[0]['tipo_plato'])): ?>
                                                    <span class="tag tag-plato"><?= strtoupper($resultados[0]['tipo_plato']) ?></span>
                                                <?php endif; ?>
                                                <?php
                                                // Mostrar alérgenos
                                                if (!empty($resultados[0]['alergenos'])) {
                                                    foreach ($resultados[0]['alergenos'] as $alergeno) {
                                                        $clase = strtolower(str_replace(' ', '-', $alergeno['nombre']));
                                                        echo '<span class="tag ' . $clase . '">' . htmlspecialchars($alergeno['nombre']) . '</span>';
                                                    }
                                                }
                                                // Mostrar enfermedades (solo las NO aptas como advertencia)
                                                if (!empty($resultados[0]['enfermedades'])) {
                                                    foreach ($resultados[0]['enfermedades'] as $enfermedad) {
                                                        $clase = strtolower($enfermedad['nombre']);
                                                        echo '<span class="tag ' . $clase . '">No apto ' . htmlspecialchars($enfermedad['nombre']) . '</span>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Posición derecha 1 (segunda receta) -->
                                <?php if (isset($resultados[1])): ?>
                                    <div class="recipiente-card side-card" data-position="right-1" data-recipe-index="1">
                                        <a href="index.php?page=detalle-receta&id=<?= $resultados[1]['id'] ?>" class="btn-view-recipiente">Ver receta</a>
                                        <?php
                                        $imagePath = "sources/platos/id{$resultados[1]['id']}.png";
                                        $imageUrl = file_exists($imagePath) ? $imagePath : "sources/platos/default.png";
                                        ?>
                                        <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($resultados[1]['nombre']) ?>">
                                        <div class="recipiente-info">
                                            <h4><?= htmlspecialchars($resultados[1]['nombre']) ?></h4>
                                            <div class="recipiente-tags">
                                                <?php if (!empty($resultados[1]['tipo_plato'])): ?>
                                                    <span class="tag tag-plato"><?= strtoupper($resultados[1]['tipo_plato']) ?></span>
                                                <?php endif; ?>
                                                <?php
                                                // Mostrar alérgenos
                                                if (!empty($resultados[1]['alergenos'])) {
                                                    foreach ($resultados[1]['alergenos'] as $alergeno) {
                                                        $clase = strtolower(str_replace(' ', '-', $alergeno['nombre']));
                                                        echo '<span class="tag ' . $clase . '">' . htmlspecialchars($alergeno['nombre']) . '</span>';
                                                    }
                                                }
                                                // Mostrar enfermedades (solo las NO aptas como advertencia)
                                                if (!empty($resultados[1]['enfermedades'])) {
                                                    foreach ($resultados[1]['enfermedades'] as $enfermedad) {
                                                        $clase = strtolower($enfermedad['nombre']);
                                                        echo '<span class="tag ' . $clase . '">No apto ' . htmlspecialchars($enfermedad['nombre']) . '</span>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="recipiente-card side-card hidden" data-position="right-1">
                                        <a href="#" class="btn-view-recipiente">Ver receta</a>
                                        <img src="" alt="">
                                        <div class="recipiente-info">
                                            <h4></h4>
                                            <div class="recipiente-tags"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Posición derecha 2 (tercera receta) -->
                                <?php if (isset($resultados[2])): ?>
                                    <div class="recipiente-card side-card" data-position="right-2" data-recipe-index="2">
                                        <a href="index.php?page=detalle-receta&id=<?= $resultados[2]['id'] ?>" class="btn-view-recipiente">Ver receta</a>
                                        <?php
                                        $imagePath = "sources/platos/id{$resultados[2]['id']}.png";
                                        $imageUrl = file_exists($imagePath) ? $imagePath : "sources/platos/default.png";
                                        ?>
                                        <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($resultados[2]['nombre']) ?>">
                                        <div class="recipiente-info">
                                            <h4><?= htmlspecialchars($resultados[2]['nombre']) ?></h4>
                                            <div class="recipiente-tags">
                                                <?php if (!empty($resultados[2]['tipo_plato'])): ?>
                                                    <span class="tag tag-plato"><?= strtoupper($resultados[2]['tipo_plato']) ?></span>
                                                <?php endif; ?>
                                                <?php
                                                // Mostrar alérgenos
                                                if (!empty($resultados[2]['alergenos'])) {
                                                    foreach ($resultados[2]['alergenos'] as $alergeno) {
                                                        $clase = strtolower(str_replace(' ', '-', $alergeno['nombre']));
                                                        echo '<span class="tag ' . $clase . '">' . htmlspecialchars($alergeno['nombre']) . '</span>';
                                                    }
                                                }
                                                // Mostrar enfermedades (solo las NO aptas como advertencia)
                                                if (!empty($resultados[2]['enfermedades'])) {
                                                    foreach ($resultados[2]['enfermedades'] as $enfermedad) {
                                                        $clase = strtolower($enfermedad['nombre']);
                                                        echo '<span class="tag ' . $clase . '">No apto ' . htmlspecialchars($enfermedad['nombre']) . '</span>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="recipiente-card side-card hidden" data-position="right-2">
                                        <a href="#" class="btn-view-recipiente">Ver receta</a>
                                        <img src="" alt="">
                                        <div class="recipiente-info">
                                            <h4></h4>
                                            <div class="recipiente-tags"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Almacenar datos de todas las recetas para JavaScript -->
                                <script>
                                    window.recetasData = <?php echo json_encode($resultados); ?>;
                                </script>
                            <?php else: ?>
                                <p class="no-resultados">No se han encontrado recetas para esta búsqueda.</p>
                            <?php endif; ?>
                        </div>
                        <button class="carrusel-nav next-btn">&gt;</button>
                    </div>

                    <!-- Indicadores dinámicos -->
                    <div class="carrusel-indicadores">
                        <?php
                        if (isset($totalRecetas)) {
                            $numIndicadores = ceil($totalRecetas / 2);
                            for ($i = 0; $i < $numIndicadores; $i++) {
                                echo '<span class="indicator"></span>';
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


<!-- Script del carrusel dinámico -->
<script src="scripts/carrusel-scriptServidor.js"></script>

<!-- Script para gestionar filtros básicso y para mostrar y ocultar los filtros premium -->
<script src="scripts/filtros-script.js"></script>

<?php include('footer.php'); ?>