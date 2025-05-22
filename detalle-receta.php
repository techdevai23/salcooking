<?php
$css_extra = '';
include 'controllers/conexion.php';
// página detalle-receta, ficha final de la receta
$css_extra .= '<link rel="stylesheet" href="styles/filosofia.css?v=' . filemtime('styles/filosofia.css') . '">'; 
include 'header.php';

// En esta versión definitiva, los datos ya han sido obtenidos por el controlador
if (!isset($receta)) {
  echo "<div class='container mt-5'><h2>Receta no encontrada.</h2></div>";
  include 'footer.php';
  exit;
}
?>

<!-- Migas de pan -->
<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="recetas-categoria.php">Recetas</a></li>
      <li class="current"><?php echo htmlspecialchars($receta['nombre']); ?></li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
    </div>
  </div>
</div>

<!-- Contenido principal -->
<section class="filosofia">
  <div class="contenedor-filosofia">
    <div class="contenido-filosofia">

      <!-- Columna de imagen -->
      <div class="foto">
        <?php
        $imagePath = "sources/platos/id{$receta['id']}.png";
        if (file_exists($imagePath)) {
          echo "<img src='{$imagePath}' alt='Imagen representativa receta' width='300px'>";
        } else {
          echo "<img src='sources/platos/default.png' alt='Imagen no disponible' width='300px'>";
        }
        ?>
        <button class="descargar-lista-btn" onclick="descargarListaPDF('lista-para-descargar.pdf', 'Receta <?php echo htmlspecialchars($receta['nombre']); ?>')">
          <img src="sources/iconos/Arrow-Double-Down-1--Streamline-Ultimate.svg" alt="Descargar" width="30px">
          Descargar receta
        </button>
        <p>
          Tiempo: <?= $receta['tiempo_preparacion'] ?> minutos<br>
          Porciones: <?= $receta['porciones'] ?>
        </p>
      </div>

      <!-- Columna de contenido -->
      <div class="texto">
        <h1><?= htmlspecialchars($receta['nombre']) ?></h1>

        <h3>Ingredientes</h3>
        <ul>
          <?php while ($fila = $ingredientes->fetch_assoc()): ?>
            <li><?= "{$fila['cantidad']} {$fila['fraccion']} {$fila['unidad']} de {$fila['nombre']}" ?></li>
          <?php endwhile; ?>
        </ul>

        <h3>Instrucciones</h3>
        <p><?= nl2br(htmlspecialchars($receta['instrucciones'])) ?></p>

        <?php if ($alergias->num_rows): ?>
          <h3>Alergias</h3>
          <ul>
            <?php while ($fila = $alergias->fetch_assoc()): ?>
              <li><?= "{$fila['nombre']}" ?><?= $fila['observaciones'] ? " ({$fila['observaciones']})" : "" ?></li>
            <?php endwhile; ?>
          </ul>
        <?php endif; ?>

        <?php if ($enfermedades->num_rows): ?>
          <h3>Apto para:</h3>
          <ul>
            <?php while ($fila = $enfermedades->fetch_assoc()): ?>
              <li><?= "{$fila['nombre']}" ?><?= $fila['indicaciones'] ? " ({$fila['indicaciones']})" : "" ?></li>
            <?php endwhile; ?>
          </ul>
        <?php endif; ?>

        <?php if ($receta['sustitutos']): ?>
          <h3>Sustitutos usados</h3>
          <p><?= nl2br(htmlspecialchars($receta['sustitutos'])) ?></p>
        <?php endif; ?>
        
        <p class="ver-fuente">
          <a href="<?= htmlspecialchars($receta['enlace_receta']) ?>" target="_blank">Ver fuente original</a>
        </p>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
