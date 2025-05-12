<?php
include 'controllers/conexion.php';
$css_extra = '<link rel="stylesheet" href="styles/filosofia.css">'; // Usamos el mismo estilo que filosofía
include 'header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consulta principal de la receta
$sql = "SELECT * FROM recetas WHERE id = $id";
$resultado = $conexion->query($sql);

if (!$resultado || $resultado->num_rows === 0) {
  echo "<div class='container mt-5'><h2>Receta no encontrada.</h2></div>";
  include 'footer.php';
  exit;
}
// Obtener la receta

$receta = $resultado->fetch_assoc();

// Ingredientes
$sql_ing = "SELECT i.nombre, ri.cantidad, ri.fraccion, u.nombre AS unidad
            FROM receta_ingrediente ri
            JOIN ingredientes i ON ri.id_ingrediente = i.id
            JOIN unidades u ON ri.id_unidad = u.id
            WHERE ri.id_receta = $id";
$ingredientes = $conexion->query($sql_ing);

// Alergias
$sql_ale = "SELECT a.nombre, ra.observaciones
            FROM receta_alergia ra
            JOIN alergias a ON ra.id_alergia = a.id
            WHERE ra.id_receta = $id";
$alergias = $conexion->query($sql_ale);

// Enfermedades
$sql_enf = "SELECT e.nombre, re.indicaciones
            FROM receta_enfermedad re
            JOIN enfermedades e ON re.id_enfermedad = e.id
            WHERE re.id_receta = $id";
$enfermedades = $conexion->query($sql_enf);
?>

<!-- Migas de pan -->
<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="recetas.php">Recetas</a></li>
      <li class="current"><?php echo htmlspecialchars($receta['nombre']); ?></li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>

<!-- Contenido principal -->
<section class="filosofia">
  <div class="contenedor-filosofia">
    <div class="contenido-filosofia">

      <!-- Columna de imagen -->
      <div class="foto">
        <img src="sources/platos/postre1.png" alt="Imagen representativa receta" width="300px">
      </div>

      <!-- Columna de texto -->
      <div class="texto-filosofia">
        <h1><?php echo htmlspecialchars($receta['nombre']); ?></h1>
        <button class="descargar-lista-btn" onclick="descargarFichaRecetaPDF('receta_<?php echo str_replace(' ', '_', htmlspecialchars($receta['nombre'])); ?>.pdf', 'Receta: <?php echo htmlspecialchars($receta['nombre']); ?>')">
          <img src="sources/iconos/Download-Bottom--Streamline-Ultimate.svg" alt="Descargar" width="30px">
          Descargar receta completa
        </button>
        <p id="receta-tiempo"><strong>⏱️ Tiempo de preparación:</strong> <?php echo $receta['tiempo_preparacion']; ?> min</p>
        <p id="receta-porciones"><strong>🍽️ Porciones:</strong> <?php echo $receta['porciones']; ?></p>

        <h4>🛒 Ingredientes:</h4>
        <ul id="lista-ingredientes-receta">
          <?php while ($ing = $ingredientes->fetch_assoc()): ?>
            <li>
              <?php echo "{$ing['cantidad']} {$ing['fraccion']} {$ing['unidad']} de {$ing['nombre']}"; ?>
            </li>
          <?php endwhile; ?>
        </ul>

        <h4>👨‍🍳 Instrucciones:</h4>
        <div>
          <p id="receta-instrucciones"><?php echo nl2br(htmlspecialchars($receta['instrucciones'])); ?></p>
        </div>


        <?php if (!empty($receta['sustitutos'])): ?>
          <h5 id="titulo-sustitutos">♻️ Sustitutos:</h5>
          <p id="lista-sustitutos"><?php echo nl2br(htmlspecialchars($receta['sustitutos'])); ?></p>
        <?php endif; ?>

        <h4>⚠️ Alergias asociadas:</h4>
        <ul id="lista-alergias">
          <?php if ($alergias->num_rows > 0): ?>
            <?php while ($al = $alergias->fetch_assoc()): ?>
              <li><?php echo "{$al['nombre']} ({$al['observaciones']})"; ?></li>
            <?php endwhile; ?>
          <?php else: ?>
            <li>Ninguna alergia asociada especificada.</li>
          <?php endif; ?>

        </ul>

        <h4>💊 Indicaciones para enfermedades:</h4>
        <ul id="lista-enfermedades">
          <?php if ($enfermedades->num_rows > 0): ?>
            <?php while ($enf = $enfermedades->fetch_assoc()): ?>
              <li><?php echo "{$enf['nombre']} ({$enf['indicaciones']})"; ?></li>
            <?php endwhile; ?>
          <?php else: ?>
            <li>Ninguna enfermedad especificada.</li>
          <?php endif; ?>
        </ul>

        <!-- Faldón final -->
        <section class="faldon">
          <h2>¿Quieres más recetas exclusivas?</h2>
          <br>
          <a href="perfil.php" class="btn-premium">Hazte Prémium</a>
        </section>

      </div>

    </div>
  </div>
</section>

<?php include 'footer.php'; ?>