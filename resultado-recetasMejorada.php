<?php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/resultado-recetas.css?v=' . filemtime('styles/resultado-recetas.css') . '">';
?>

<?php include('header.php'); ?>

<?php
// En tu PHP, antes de mostrar el carrusel calcula los índices
$totalRecetas = count($resultados);
$currentIndex = $_GET['index'] ?? 0; // Obtener índice actual de la URL

// Calcular posiciones relativas
$indices = [
    'left2' => ($currentIndex - 2 + $totalRecetas) % $totalRecetas,
    'left1' => ($currentIndex - 1 + $totalRecetas) % $totalRecetas,
    'center' => $currentIndex,
    'right1' => ($currentIndex + 1) % $totalRecetas,
    'right2' => ($currentIndex + 2) % $totalRecetas
];
?>

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
                <option value="">Seleccionar</option>
                <option value="nombre-asc">Nombre (A-Z)</option>
                <option value="nombre-desc">Nombre (Z-A)</option>
                <option value="ing-menos-6">Ingredientes (menos de 6)</option>
                <option value="ing-7-10">Ingredientes (7-10)</option>
                <option value="ing-mas-10">Ingredientes (más de 10)</option>
              </select>
            </div>

            <div class="filter-section">
              <label for="tipo-plato">Filtros:</label>
              <select name="tipo-plato" id="tipo-plato">
                <option value="">Tipo de plato</option>
                <option value="desayuno">Desayuno</option>
                <option value="entrante">Entrante</option>
                <option value="principal">Principal</option>
                <option value="postre">Postre</option>
              </select>
            </div>

            <div class="filter-section">
              <select name="alergenos" id="alergenos">
                <option value="">Alérgenos</option>
                <option value="gluten">Gluten</option>
                <option value="frutos-secos">Frutos secos</option>
                <option value="pescado">Pescado</option>
                <option value="marisco">Marisco</option>
              </select>
            </div>

            <div class="filter-section">
              <select name="porciones" id="porciones">
                <option value="">Porciones</option>
                <option value="2">2 porciones</option>
                <option value="4">4 porciones</option>
                <option value="mas-4">Más de 4 porciones</option>
              </select>
            </div>
            <!-- zona de filtros y opciones premium -->
            <div class="premium-filters">
              <div class="premium-header">
                <h4>Opciones Premium</h4>
                <img src="sources/iconos/Vip-Circle--Streamline-Ultimate.png" alt="info" class="info-icon" title="Funcionalidades exclusivas para usuarios Prémium" style="width:40px; height:40px;">
                <a href="contacto.php" title="Solo puedes ganar: Hazte Prémium" title="Solo puedes ganar: Hazte Prémium" class="btn-premium">Hazte Prémium</a>
              </div>
              <div class="premium-options">
                <div class="premium-option">
                  <select name="enfermedades" disabled>
                    <option value="">Enfermedades</option>
                    <option value="diabetes">Diabetes</option>
                    <option value="colesterol">Colesterol alto</option>
                    <option value="ambas">Ambas</option>
                  </select>
                </div>

                <div class="premium-option">
                  <label class="checkbox-container">
                    <input type="checkbox" name="perfil" value="1" disabled>
                    <span class="checkmark"></span>
                    Tener en cuenta mi perfil
                  </label>
                </div>

                <div class="premium-option">
                  <input type="text" name="ingrediente" placeholder="Ingrediente..." disabled>
                </div>

                <div class="premium-option">
                  <select name="tiempo" disabled>
                    <option value="">Tiempo de preparación</option>
                    <option value="menos-30">Menos de 30 min</option>
                    <option value="31-60">Entre 31 y 60 min</option>
                    <option value="mas-60">Más de 60 min</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Carrusel dinámico -->
          <div class="recipiente-carrusel-container">
            <button class="carrusel-nav prev-btn">&lt;</button>


            <div class="recipiente-carrusel">

              <!-- Tarjetas laterales y central -->
              <div class="recipiente-card side-card left-card">
                <?php if (isset($resultados[$leftIndex2])): ?>
                  <img src="sources/platos/id<?= $resultados[$leftIndex2]['id'] ?>.png" alt="<?= $resultados[$leftIndex2]['nombre'] ?>">
                  <div class="recipiente-info">
                    <h4><?= $resultados[$leftIndex2]['nombre'] ?></h4>
                    <p class="recipiente-tags">
                      <span class="tag-plato"><?= strtoupper($resultados[$leftIndex2]['tipo_plato']) ?></span>
                      <?php foreach ($resultados[$leftIndex2]['alergenos'] as $alergeno): ?>
                        <span class="tag <?= $alergeno ?>"><?= ucfirst($alergeno) ?></span>
                      <?php endforeach; ?>
                    </p>
                    <a href="detalle-receta.php?id=<?= $resultados[$leftIndex2]['id'] ?>" class="btn-view-recipiente">Ver receta</a>
                  </div>
                <?php endif; ?>
              </div>

              <div class="recipiente-card side-card featured-card">
                <?php if (isset($resultados[$leftIndex2])): ?>
                  <img src="sources/platos/id<?= $resultados[$leftIndex2]['id'] ?>.png" alt="<?= $resultados[$leftIndex2]['nombre'] ?>">
                  <div class="recipiente-info">
                    <h4><?= $resultados[$leftIndex2]['nombre'] ?></h4>
                    <p class="recipiente-tags">
                      <span class="tag-plato"><?= strtoupper($resultados[$leftIndex2]['tipo_plato']) ?></span>
                      <?php foreach ($resultados[$leftIndex2]['alergenos'] as $alergeno): ?>
                        <span class="tag <?= $alergeno ?>"><?= ucfirst($alergeno) ?></span>
                      <?php endforeach; ?>
                    </p>
                    <a href="detalle-receta.php?id=<?= $resultados[$leftIndex2]['id'] ?>" class="btn-view-recipiente">Ver receta</a>
                  </div>
                <?php endif; ?>
              </div>





            </div>






              <?php if (!empty($resultados)): ?>
                <?php foreach ($resultados as $receta): ?>
                  <div class="recipiente-card">
                    <a href="index.php?page=detalle-receta&id=<?= $receta['id'] ?>" class="btn-view-recipiente">Ver receta</a>
                    <img src="sources/platos/id<?= $receta['id'] ?>.png" alt="<?= htmlspecialchars($receta['nombre']) ?>">
                    <h4><?= htmlspecialchars($receta['nombre']) ?></h4>
                    <div class="recipiente-tags">
                      <?php if (!empty($receta['tipo_plato'])): ?>
                        <span class="tag tag-plato"><?= strtoupper($receta['tipo_plato']) ?></span>
                      <?php endif; ?>
                      <?php if (stripos($receta['nombre'], 'pescado') !== false): ?>

                      <?php endif; ?>
                    </div>

                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="no-resultados">No se han encontrado recetas para esta búsqueda.</p>
              <?php endif; ?>
            </div>
            <button class="carrusel-nav next-btn">&gt;</button>
          </div>

          <!-- Controles del carrusel
                    <div class="carrusel-controles">
                        <button class="prev-btn">◀</button>
                        <button class="next-btn">▶</button>
                    </div> -->

          <!-- Indicadores dinámicos -->
          <div class="carrusel-indicadores">
            <?php
            $numIndicadores = ceil(count($resultados) / 2);
            for ($i = 0; $i < $numIndicadores; $i++) {
              echo '<span class="indicator"></span>';
            }
            ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<?php include('footer.php'); ?>