<?php

// Definir $css_extra ANTES de incluir header.php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/lista-semana.css?v=' . filemtime('styles/lista-semana.css') . '">';
include 'header.php';
include 'controllers/conexion.php'; // Para la conexión a la BBDD

$ingredientes_compra = [];
$id_plan_semanal = null; // Aquí deberías obtener el ID del plan semanal (ej. desde $_GET['plan_id'])

// --- LÓGICA PARA OBTENER INGREDIENTES DE LA SEMANA ---
// Esto es un EJEMPLO de cómo podrías obtener los IDs de las recetas.
// Necesitarás adaptar esto a cómo pases la información del plan semanal.
// Por ejemplo, si pasas el ID del plan por GET:
if (isset($_GET['plan_id'])) {
    $id_plan_semanal = intval($_GET['plan_id']);

    // Consulta para obtener todas las recetas de un plan semanal específico
    // ASUNCIÓN: Tienes una tabla 'plan_recetas' o similar que relaciona planes y recetas.
    // Esta consulta es un placeholder, adáptala a tu esquema.
    $sql_recetas_plan = "SELECT DISTINCT r.id_receta FROM recetas r 
                         JOIN plan_semanal_recetas psr ON r.id_receta = psr.id_receta 
                         WHERE psr.id_plan_semanal = ?"; // Asume una tabla plan_semanal_recetas
    
    // Si no tienes una tabla intermedia y pasas los IDs de receta directamente (ej: ?recetas_ids=1,2,3)
    // $recetas_ids_str = isset($_GET['recetas_ids']) ? $_GET['recetas_ids'] : '';
    // $recetas_ids_array = !empty($recetas_ids_str) ? explode(',', $recetas_ids_str) : [];
    // $placeholders = implode(',', array_fill(0, count($recetas_ids_array), '?'));
    // $sql_recetas_plan = "SELECT id_receta FROM recetas WHERE id_receta IN ($placeholders)";
    // $stmt_recetas = $conexion->prepare($sql_recetas_plan);
    // if ($stmt_recetas && count($recetas_ids_array) > 0) {
    //    $types = str_repeat('i', count($recetas_ids_array));
    //    $stmt_recetas->bind_param($types, ...$recetas_ids_array);


    $stmt_recetas = $conexion->prepare($sql_recetas_plan);
    if ($stmt_recetas && $id_plan_semanal) {
        $stmt_recetas->bind_param("i", $id_plan_semanal);
        $stmt_recetas->execute();
        $resultado_recetas = $stmt_recetas->get_result();
        $ids_recetas_plan = [];
        while ($fila_receta = $resultado_recetas->fetch_assoc()) {
            $ids_recetas_plan[] = $fila_receta['id_receta'];
        }
        $stmt_recetas->close();

        if (!empty($ids_recetas_plan)) {
            $placeholders = implode(',', array_fill(0, count($ids_recetas_plan), '?'));
            $sql_ingredientes = "SELECT i.nombre_ingrediente, SUM(ri.cantidad) as cantidad_total, um.abreviatura_unidad
                                 FROM receta_ingredientes ri
                                 JOIN ingredientes i ON ri.id_ingrediente = i.id_ingrediente
                                 JOIN unidades_medida um ON ri.id_unidad_medida = um.id_unidad
                                 WHERE ri.id_receta IN ($placeholders)
                                 GROUP BY i.id_ingrediente, i.nombre_ingrediente, um.id_unidad, um.abreviatura_unidad
                                 ORDER BY i.nombre_ingrediente";
            
            $stmt_ingredientes = $conexion->prepare($sql_ingredientes);
            if ($stmt_ingredientes) {
                $types = str_repeat('i', count($ids_recetas_plan));
                $stmt_ingredientes->bind_param($types, ...$ids_recetas_plan);
                $stmt_ingredientes->execute();
                $resultado_ingredientes = $stmt_ingredientes->get_result();
                while ($fila = $resultado_ingredientes->fetch_assoc()) {
                    $ingredientes_compra[] = $fila;
                }
                $stmt_ingredientes->close();
            }
        }
    }
}
// --- FIN LÓGICA PARA OBTENER INGREDIENTES ---
$conexion->close();
?>

<!-- LISTA DE LA COMPRA SEMANAL -->

<!-- migas -->
<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="dieta.php">Dieta</a></li>
      <li><a href="dieta-semana-por-dias.php">Dieta Semana</a></li> <!-- Asumo que esta es la página anterior -->
      <li class="current">Lista de la Compra de la Semana</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
    </div>
  </div>
</div>

<!-- Contenido principal-->
<section class="lista-semana">
    <div class="contenedor-lista-semana">

        <div class="titulo">
            <img src="sources/iconos/Cart-Shopping--Streamline-Ultimate.png" width="48px" alt="Carrito de la compra"> <!-- Cambié el icono -->
            <h1>Lista de la compra de la Semana</h1>
        </div>
       
        <div class="contenido-lista-semana">
            <?php if (!empty($ingredientes_compra)): ?>
                <div class="lista-ingredientes-compra" id="lista-para-descargar">
                    <?php foreach ($ingredientes_compra as $ingrediente): ?>
                        <div class="ingrediente-item">
                            <span class="ingrediente-nombre"><?php echo htmlspecialchars($ingrediente['nombre_ingrediente']); ?></span>
                            <span class="ingrediente-cantidad">
                                <?php echo htmlspecialchars(rtrim(rtrim(sprintf('%.2f', $ingrediente['cantidad_total']), '0'), '.')); ?>
                                <?php echo htmlspecialchars($ingrediente['abreviatura_unidad']); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mensaje-lista-vacia">No hay ingredientes para mostrar. Por favor, selecciona un plan semanal o recetas.</p>
            <?php endif; ?>

            <div class="acciones-lista">
            <button class="descargar-lista-btn" onclick="descargarListaPDF('lista-compra-semana.pdf', 'Lista de la Compra de la Semana')">
                    <img src="sources/iconos/Business-Cart-Add--Streamline-Ultimate.svg" alt="Descargar"> <!-- Icono ejemplo, ajusta la ruta -->
                    Descargar lista ingredientes
                </button>
            </div>

            <p class="mensaje-apoyo-premium">
                ¡Gracias por seguir apoyándonos siendo un usuario <strong>Prémium</strong>!
            </p>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
function descargarListaTexto(nombreArchivo) {
    const listaElement = document.getElementById('lista-para-descargar');
    if (!listaElement) {
        alert('No hay lista para descargar.');
        return;
    }

    let textoLista = "Lista de la Compra:\n----------------------\n";
    const items = listaElement.querySelectorAll('.ingrediente-item');

    if (items.length === 0) {
        alert('La lista de ingredientes está vacía.');
        return;
    }

    items.forEach(item => {
        const nombre = item.querySelector('.ingrediente-nombre').textContent;
        const cantidad = item.querySelector('.ingrediente-cantidad').textContent;
        textoLista += `${nombre}: ${cantidad.trim()}\n`;
    });

    const blob = new Blob([textoLista], { type: 'text/plain;charset=utf-8' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = nombreArchivo;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(link.href);
}
</script>