<?php

// Definir el modo de desarrollo
define('MODO_DESARROLLO', false); // Cambiar a true para ver mensajes de depuración

// Definir $css_extra ANTES de incluir header.php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/lista-semana.css?v=' . filemtime('styles/lista-semana.css') . '">';
include 'header.php';
include 'controllers/conexion.php'; // Para la conexión a la BBDD

$ingredientes_compra = [];
$id_plan_semanal = null;
$dia_seleccionado = null;
$nombre_dia = '';
$fecha_dieta = '';

// --- LÓGICA PARA OBTENER INGREDIENTES DEL DÍA SELECCIONADO ---

if (isset($_GET['id_dieta']) && isset($_GET['dia'])) {
    $id_plan_semanal = intval($_GET['id_dieta']);
    $dia_seleccionado = strtolower($_GET['dia']);

    // Mapeo de días para mostrar con acento
    $dias_map = [
        'lunes' => 'Lunes',
        'martes' => 'Martes',
        'miercoles' => 'Miércoles',
        'jueves' => 'Jueves',
        'viernes' => 'Viernes',
        'sabado' => 'Sábado',
        'domingo' => 'Domingo'
    ];
    $nombre_dia = $dias_map[$dia_seleccionado] ?? ucfirst($dia_seleccionado);

    // Obtener la fecha de la dieta
    $sql = "SELECT fecha_creacion FROM dietas WHERE id_dieta = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_plan_semanal);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $fecha_dieta = date('d-m-Y', strtotime($row['fecha_creacion']));
    }
    $stmt->close();

    // Obtener las recetas del día seleccionado
    require_once 'models/dieta.php';
    $planDieta = Dieta::getPlanDieta($id_plan_semanal);
    $recetas_dia = [];
    if (isset($planDieta[$nombre_dia])) {
        foreach ($planDieta[$nombre_dia] as $tipo => $receta) {
            if (is_array($receta) && isset($receta['id'])) {
                $recetas_dia[] = intval($receta['id']);
            }
        }
    }

    if (!empty($recetas_dia)) {
        $placeholders = implode(',', array_fill(0, count($recetas_dia), '?'));
        $sql_ingredientes = "SELECT 
                                i.nombre as nombre_ingrediente,
                                SUM(
                                    CASE 
                                        WHEN ri.cantidad IS NOT NULL THEN 
                                            CASE 
                                                WHEN u.nombre IN ('ml.', 'l.', 'Centímetro cúbico', 'Decilitro', 'Centilitro', 'Taza', 'Media taza', 'Tres cuartos de taza', 'Cuarto de taza', 'Cucharada/s', 'Cucharadita/s', 'Media cucharada', 'Gota') 
                                                THEN ri.cantidad * COALESCE(u.conversion_base, 1)
                                                WHEN u.nombre IN ('grs.', 'kg.', 'Miligramo', 'Pizca') 
                                                THEN ri.cantidad * COALESCE(u.conversion_base, 1)
                                                WHEN u.nombre IN ('Unidad/es', 'Docena/s', 'Media docena', 'diente/s') 
                                                THEN ri.cantidad
                                                ELSE ri.cantidad
                                            END
                                        ELSE 0 
                                    END
                                ) as cantidad_total,
                                CASE 
                                    WHEN u.nombre IN ('ml.', 'l.', 'Centímetro cúbico', 'Decilitro', 'Centilitro', 'Taza', 'Media taza', 'Tres cuartos de taza', 'Cuarto de taza', 'Cucharada/s', 'Cucharadita/s', 'Media cucharada', 'Gota') 
                                    THEN 'ml'
                                    WHEN u.nombre IN ('grs.', 'kg.', 'Miligramo', 'Pizca') 
                                    THEN 'gr'
                                    WHEN u.nombre IN ('Unidad/es', 'Docena/s', 'Media docena', 'diente/s') 
                                    THEN u.nombre
                                    ELSE MIN(u.nombre)
                                END as unidad_final
                            FROM receta_ingrediente ri
                            JOIN ingredientes i ON ri.id_ingrediente = i.id
                            LEFT JOIN unidades u ON ri.id_unidad = u.id
                            WHERE ri.id_receta IN ($placeholders)
                            GROUP BY i.id, i.nombre
                            ORDER BY i.nombre";
        $stmt_ingredientes = $conexion->prepare($sql_ingredientes);
        if ($stmt_ingredientes) {
            $types = str_repeat('i', count($recetas_dia));
            $stmt_ingredientes->bind_param($types, ...$recetas_dia);
            if ($stmt_ingredientes->execute()) {
                $resultado_ingredientes = $stmt_ingredientes->get_result();
                while ($fila = $resultado_ingredientes->fetch_assoc()) {
                    $ingredientes_compra[] = [
                        'nombre_ingrediente' => $fila['nombre_ingrediente'],
                        'cantidad_total' => $fila['cantidad_total'],
                        'abreviatura_unidad' => $fila['unidad_final']
                    ];
                }
            }
            $stmt_ingredientes->close();
        }
    }
}

// --- FIN LÓGICA PARA OBTENER INGREDIENTES ---

?>

<!-- LISTA DE LA COMPRA SEMANAL -->

<!-- migas -->
<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="dieta.php">Dieta</a></li>
      <li><a href="dieta-dia.php">Dieta del Día</a></li> 
      <li class="current">Lista de la Compra del día</li>
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
            <img src="sources/iconos/Shopping-Basket-3--Streamline-Ultimate.svg" width="48px" alt="Carrito de la compra"> 
            <h1>Lista de la compra del día</h1>
        </div>

        <div class="subtitulo">
            <?php
            include_once 'controllers/session.php';
            $nick = htmlspecialchars(getUserNick());
            if ($nick && $id_plan_semanal && $fecha_dieta && $nombre_dia) {
                echo '<h3 style="font-size:1.1em; font-weight:normal; margin-top:10px; color:#666;">Hola: ' . $nick . '😄. Has elegido de tu Dieta ID: ' . $id_plan_semanal . ' con fecha: ' . $fecha_dieta . ', que te muestre los ingredientes del <b>' . $nombre_dia . '</b>, aquí los tienes💖. Buena compra!👍</h3>';
            } elseif (!empty($error)) {
                echo '<div style="color: #b94a48; font-size:1em; margin-top:10px;">' . $error . '</div>';
            }
            ?>
        </div>
        <!-- Descargar lista de ingredientes -->
        <div class="acciones-lista">
                <button class="descargar-lista-btn" onclick="descargarListaPDF('lista-compra-semana.pdf', 'Lista de la Compra de la Semana')">
                    <img src="sources/iconos/Arrow-Double-Down-1--Streamline-Ultimate.svg" alt="Descargar">
                    Descargar lista ingredientes
                </button>
            </div>
       
        <div class="contenido-lista-semana">
            <?php if (!empty($ingredientes_compra)): ?>
                <div class="lista-ingredientes-compra" id="lista-para-descargar">
                   
                   <?php 

                    // Mostrar los ingredientes agrupados
                    foreach ($ingredientes_compra as $ingrediente) {
                        $nombre = $ingrediente['nombre_ingrediente'];
                        $cantidad = $ingrediente['cantidad_total'];
                        $unidad = $ingrediente['abreviatura_unidad'];
                        ?>
                        <div class="ingrediente-item">
                            <span class="ingrediente-nombre"><?php echo htmlspecialchars($nombre); ?></span>
                            <span class="ingrediente-cantidad">
                                <?php echo htmlspecialchars(rtrim(rtrim(sprintf('%.2f', $cantidad), '0'), '.')); ?>
                                <?php echo htmlspecialchars($unidad); ?>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            <?php else: ?>
                <p class="mensaje-lista-vacia">No hay ingredientes para mostrar. Por favor, selecciona un plan semanal o recetas.</p>
            <?php endif; ?>

            <!-- Descargar lista de ingredientes -->
            <div class="acciones-lista">
                <button class="descargar-lista-btn" onclick="descargarListaPDF('lista-compra-semana.pdf', 'Lista de la Compra de la Semana')">
                    <img src="sources/iconos/Arrow-Double-Down-1--Streamline-Ultimate.svg" alt="Descargar">
                    Descargar lista ingredientes
                </button>
            </div>

            <div class="premium-message">
                ¡Gracias por seguir apoyándonos siendo un usuario Prémium!
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
    // Descargar lista de ingredientes
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
</body>
</html>