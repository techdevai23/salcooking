<?php
$css_extra = '<link rel="stylesheet" href="styles/lista-dia.css">';
include 'header.php';
include 'conexion.php';

$ingredientes_compra = [];
// --- LÓGICA PARA OBTENER INGREDIENTES DEL DÍA ---
// Esto es un EJEMPLO. Necesitarás adaptar esto a cómo pases la información de las recetas del día.
// Por ejemplo, si pasas una lista de IDs de recetas por GET (ej: ?recetas_ids=1,5,7)
$recetas_ids_str = isset($_GET['recetas_ids']) ? $_GET['recetas_ids'] : ''; // ej: "1,5,7"
$ids_recetas_dia = [];
if (!empty($recetas_ids_str)) {
    $ids_recetas_dia = array_map('intval', explode(',', $recetas_ids_str));
}

if (!empty($ids_recetas_dia)) {
    $placeholders = implode(',', array_fill(0, count($ids_recetas_dia), '?'));
    $sql_ingredientes = "SELECT i.nombre_ingrediente, SUM(ri.cantidad) as cantidad_total, um.abreviatura_unidad
                         FROM receta_ingredientes ri
                         JOIN ingredientes i ON ri.id_ingrediente = i.id_ingrediente
                         JOIN unidades_medida um ON ri.id_unidad_medida = um.id_unidad
                         WHERE ri.id_receta IN ($placeholders)
                         GROUP BY i.id_ingrediente, i.nombre_ingrediente, um.id_unidad, um.abreviatura_unidad
                         ORDER BY i.nombre_ingrediente";
    
    $stmt_ingredientes = $conexion->prepare($sql_ingredientes);
    if ($stmt_ingredientes) {
        $types = str_repeat('i', count($ids_recetas_dia)); // 'i' for integer
        $stmt_ingredientes->bind_param($types, ...$ids_recetas_dia);
        $stmt_ingredientes->execute();
        $resultado_ingredientes = $stmt_ingredientes->get_result();
        while ($fila = $resultado_ingredientes->fetch_assoc()) {
            $ingredientes_compra[] = $fila;
        }
        $stmt_ingredientes->close();
    }
}
// --- FIN LÓGICA PARA OBTENER INGREDIENTES ---
$conexion->close();
?>

<!-- LISTA DE LA COMPRA DIA -->

<!-- migas -->
<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="dieta.php">Dieta</a></li>
      <!-- Actualiza esta ruta si vienes de una página de dieta diaria específica -->
      <li><a href="dieta-dia.php">Dieta del Día</a></li> 
      <li class="current">Lista de la Compra del Día</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="images/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>

<!-- Contenido principal-->
<section class="lista-dia">
    <div class="contenedor-lista-dia">

        <div class="titulo">
            <img src="images/iconos/Cart-Shopping--Streamline-Ultimate.png" width="48px" alt="Carrito de la compra">
            <h1>Lista de la compra del Día</h1>
        </div>
       
        <div class="contenido-lista-dia">
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
                <p class="mensaje-lista-vacia">No hay ingredientes para mostrar. Por favor, selecciona las recetas del día.</p>
            <?php endif; ?>

            <div class="acciones-lista">
            <button class="descargar-lista-btn" onclick="descargarListaPDF('lista-compra-dia.pdf', 'Lista de la Compra del Día')">
                    <img src="images/iconos/Business-Cart-Add--Streamline-Ultimate.svg" alt="Descargar">
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
// La función descargarListaTexto es la misma que en lista-semana.php
// Si vas a tener muchas páginas con esta función, considera moverla a un archivo JS global.
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