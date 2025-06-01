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
        
        <button class="descargar-lista-btn" id="btn-descargar-receta">
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
          <?php if ($ingredientes && $ingredientes->num_rows > 0): ?>
            <?php while ($fila = $ingredientes->fetch_assoc()): ?>
              <li><?= "{$fila['cantidad']} {$fila['fraccion']} {$fila['unidad']} de {$fila['nombre']}" ?></li>
            <?php endwhile; ?>
          <?php else: ?>
            <li>No se pudieron cargar los ingredientes</li>
          <?php endif; ?>
        </ul>

        <h3>Instrucciones</h3>
        <p><?= nl2br(htmlspecialchars($receta['instrucciones'])) ?></p>

        <?php if ($alergias && $alergias->num_rows > 0): ?>
          <h3>Alergias</h3>
          <ul>
            <?php while ($fila = $alergias->fetch_assoc()): ?>
              <li><?= "{$fila['nombre']}" ?><?= $fila['observaciones'] ? " ({$fila['observaciones']})" : "" ?></li>
            <?php endwhile; ?>
          </ul>
        <?php endif; ?>

        <?php if ($enfermedades && $enfermedades->num_rows > 0): ?>
          <h3>Información sobre enfermedades:</h3>
          <ul>
            <?php while ($fila = $enfermedades->fetch_assoc()): ?>
              <li>
                <?php if ($fila['apta'] == 1): ?>
                  <strong>✓ Apta para <?= $fila['nombre'] ?></strong>
                <?php else: ?>
                  <strong>✗ No apta para <?= $fila['nombre'] ?></strong>
                <?php endif; ?>
                <?= $fila['indicaciones'] ? " - {$fila['indicaciones']}" : "" ?>
              </li>
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

<script src="scripts/descargarFichaReceta.js"></script>
<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Función para comprobar si el usuario está logueado (PHP -> JS)
const usuarioLogueado = <?php echo isset($_SESSION['id_usuario']) ? 'true' : 'false'; ?>;

// Obtener el nombre de la receta para el PDF
const nombreReceta = <?php echo json_encode($receta['nombre']); ?>;

document.getElementById('btn-descargar-receta').addEventListener('click', function(e) {
    e.preventDefault();
    if (!usuarioLogueado) {
        Swal.fire({
            title: 'Descarga solo para usuarios registrados',
            text: 'Debes registrarte gratis para poder descargar la ficha de la receta.',
            icon: 'info',
            showCancelButton: true,
            showCloseButton: true,
            confirmButtonText: 'Registrarme ahora',
            cancelButtonText: 'Iniciar sesión',
            customClass: {
                container: 'my-swal-container',
                popup: 'my-swal-popup',
                header: 'my-swal-header',
                title: 'my-swal-title',
                content: 'my-swal-content',
                confirmButton: 'my-swal-confirm-button',
                cancelButton: 'my-swal-cancel-button',
                closeButton: 'my-swal-close-button'
            },
            footer: '<a href="planes.php" style="color: var(--color-principal); text-decoration: underline;">Ver Planes de suscripción</a>',
            html: `
                <div style="position: absolute; top: 10px; right: 50px; font-size: 0.8em; color: #666;">
                    Registrarme más tarde
                </div>
            `
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'perfil.php';
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = 'login.php';
            }
        });
    } else {
        // Si está logueado, permitir la descarga
        descargarFichaRecetaPDF('ficha-receta.pdf', nombreReceta);
    }
});
</script>
