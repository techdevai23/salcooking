<?php
include 'controllers/conexion.php';
$css_extra = '<link rel="stylesheet" href="styles/filosofia.css?v=3">'; // Usamos el mismo estilo que filosofía
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
      <li><a href="recetas-categoria.php">Recetas</a></li>
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
        <?php
        // Comprobamos si la imagen existe y la mostramos
        $imagePath = "sources/platos/id{$id}.png";
        if (file_exists($imagePath)) {
          echo "<img src='{$imagePath}' alt='Imagen representativa receta' width='300px'>";
        } else {
          echo "<img src='sources/platos/default.png' alt='Imagen no disponible' width='300px'>";
        }
        ?>
         <!-- boton descargar -->
        <button class="descargar-lista-btn" onclick="descargarListaPDF('lista-para-descargar.pdf', 'Receta <?php echo htmlspecialchars($receta['nombre']); ?>')">
          <img src="sources/iconos/Arrow-Double-Down-1--Streamline-Ultimate.svg" alt="Descargar" width="30px"> <!-- Icono ejemplo, ajusta la ruta -->
          Descargar receta
        </button>
        <!-- información datos básicos -->
        <p><strong>⏱️ Tiempo de preparación:</strong> <?php echo $receta['tiempo_preparacion']; ?> min</p>
        <p><strong>🍽️ Porciones:</strong> <?php echo $receta['porciones']; ?></p>

      </div>

      <!-- Columna de texto -->
      <div class="texto-filosofia">
        <h1><?php echo htmlspecialchars($receta['nombre']); ?></h1>


        <!-- Datos principales -->
        <h4>🛒 Ingredientes:</h4>
        <ul>
          <?php while ($ing = $ingredientes->fetch_assoc()): ?>
            <li>
              <?php echo "{$ing['cantidad']} {$ing['fraccion']} {$ing['unidad']} de {$ing['nombre']}"; ?>
            </li>
          <?php endwhile; ?>
        </ul>

        <h4>👨‍🍳 Instrucciones:</h4>
        <p><?php echo nl2br(htmlspecialchars($receta['instrucciones'])); ?></p>

        <?php if (!empty($receta['sustitutos'])): ?>
          <h4>♻️ Sustitutos:</h4>
          <p><?php echo nl2br(htmlspecialchars($receta['sustitutos'])); ?></p>
        <?php endif; ?>

        <h4>⚠️ Alergias asociadas:</h4>
        <ul>
          <?php while ($al = $alergias->fetch_assoc()): ?>
            <li><?php echo "{$al['nombre']} ({$al['observaciones']})"; ?></li>
          <?php endwhile; ?>
        </ul>

        <h4>💊 Indicaciones para enfermedades:</h4>
        <ul>
          <?php while ($enf = $enfermedades->fetch_assoc()): ?>
            <li><?php echo "{$enf['nombre']} ({$enf['indicaciones']})"; ?></li>
          <?php endwhile; ?>
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