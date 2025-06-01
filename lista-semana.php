<?php

// Definir el modo de desarrollo
define('MODO_DESARROLLO', false); // Cambiar a true para ver mensajes de depuración

// Definir $css_extra ANTES de incluir header.php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/lista-semana.css?v=' . filemtime('styles/lista-semana.css') . '">';
include 'header.php';
include 'controllers/conexion.php'; // Para la conexión a la BBDD

$ingredientes_compra = [];
$id_plan_semanal = null; // Aquí deberías obtener el ID del plan semanal (ej. desde $_GET['plan_id'])

// --- LÓGICA PARA OBTENER INGREDIENTES DE LA SEMANA ---

if (isset($_GET['id_dieta'])) {
    $id_plan_semanal = intval($_GET['id_dieta']);

    // Código de depuración solo en modo desarrollo
    if (defined('MODO_DESARROLLO') && MODO_DESARROLLO === true) {
        echo "<div style='background: #f0f0f0; padding: 10px; margin: 10px;'>";
        echo "<h3>Información de Depuración:</h3>";
        
        // Verificar si existe la dieta
        $sql_check = "SELECT * FROM dietas WHERE id_dieta = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("i", $id_plan_semanal);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($dieta = $result_check->fetch_assoc()) {
            echo "<div style='margin-bottom: 15px;'>";
            echo "<strong>Información de la Dieta:</strong><br>";
            echo "ID: " . htmlspecialchars($dieta['id_dieta']) . "<br>";
            echo "Nombre: " . htmlspecialchars($dieta['nombre_dieta']) . "<br>";
            echo "Fecha de creación: " . htmlspecialchars($dieta['fecha_creacion']) . "<br>";
            echo "</div>";
        } else {
            echo "<div style='color: red;'>No se encontró la dieta con ID " . $id_plan_semanal . "</div>";
        }
        $stmt_check->close();

        // Verificar recetas asociadas con más detalles
        $sql_recetas = "SELECT COUNT(*) as total, 
                       GROUP_CONCAT(r.nombre SEPARATOR ', ') as nombres_recetas
                       FROM dieta_receta dr 
                       JOIN recetas r ON dr.id_receta = r.id 
                       WHERE dr.id_dieta = ?";
        $stmt_recetas = $conexion->prepare($sql_recetas);
        $stmt_recetas->bind_param("i", $id_plan_semanal);
        $stmt_recetas->execute();
        $result_recetas = $stmt_recetas->get_result();
        $count = $result_recetas->fetch_assoc();
        $stmt_recetas->close();

        echo "<div style='margin-bottom: 15px;'>";
        echo "<strong>Recetas en la Dieta:</strong><br>";
        echo "Total de recetas: " . $count['total'] . "<br>";
        if ($count['total'] > 0) {
            echo "Lista de recetas: " . htmlspecialchars($count['nombres_recetas']) . "<br>";
        }
        echo "</div>";

        // Mostrar información de ingredientes
        if (!empty($ingredientes_compra)) {
            echo "<div style='margin-bottom: 15px;'>";
            echo "<strong>Resumen de Ingredientes:</strong><br>";
            echo "Total de ingredientes únicos: " . count($ingredientes_compra) . "<br>";
            
            // Agrupar ingredientes por tipo de unidad
            $ingredientes_por_unidad = [];
            foreach ($ingredientes_compra as $ing) {
                $unidad = $ing['abreviatura_unidad'];
                if (!isset($ingredientes_por_unidad[$unidad])) {
                    $ingredientes_por_unidad[$unidad] = 0;
                }
                $ingredientes_por_unidad[$unidad]++;
            }
            
            echo "<br>Distribución por unidades:<br>";
            foreach ($ingredientes_por_unidad as $unidad => $cantidad) {
                echo "- " . htmlspecialchars($unidad) . ": " . $cantidad . " ingredientes<br>";
            }
            echo "</div>";
        }
    }

    // Verificar recetas asociadas
    $sql_recetas = "SELECT COUNT(*) as total FROM dieta_receta WHERE id_dieta = ?";
    $stmt_recetas = $conexion->prepare($sql_recetas);
    $stmt_recetas->bind_param("i", $id_plan_semanal);
    $stmt_recetas->execute();
    $result_recetas = $stmt_recetas->get_result();
    $count = $result_recetas->fetch_assoc();
    $stmt_recetas->close();

    if ($count['total'] === 0) {
        $error = "No se encontraron recetas asociadas a esta dieta.";
    } else {
        // Consulta para obtener todas las recetas de un plan semanal específico
        $sql_recetas_plan = "SELECT DISTINCT r.id 
                            FROM recetas r 
                            JOIN dieta_receta dr ON r.id = dr.id_receta 
                            WHERE dr.id_dieta = ?";

        $ids_recetas_plan = [];
        $stmt_recetas = $conexion->prepare($sql_recetas_plan);
        if ($stmt_recetas) {
            $stmt_recetas->bind_param("i", $id_plan_semanal);
            if ($stmt_recetas->execute()) {
                $resultado_recetas = $stmt_recetas->get_result();
                while ($fila_receta = $resultado_recetas->fetch_assoc()) {
                    $ids_recetas_plan[] = $fila_receta['id'];
                }
            } else {
                $error = "Error al obtener las recetas: " . $stmt_recetas->error;
            }
            $stmt_recetas->close();
        } else {
            $error = "Error al preparar la consulta de recetas: " . $conexion->error;
        }
    }

    if (!empty($ids_recetas_plan) && !isset($error)) {
        $placeholders = implode(',', array_fill(0, count($ids_recetas_plan), '?'));
        
        // Consulta SQL optimizada para obtener ingredientes
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
            $types = str_repeat('i', count($ids_recetas_plan));
            $stmt_ingredientes->bind_param($types, ...$ids_recetas_plan);
            if ($stmt_ingredientes->execute()) {
                $resultado_ingredientes = $stmt_ingredientes->get_result();
                while ($fila = $resultado_ingredientes->fetch_assoc()) {
                    $ingredientes_compra[] = [
                        'nombre_ingrediente' => $fila['nombre_ingrediente'],
                        'cantidad_total' => $fila['cantidad_total'],
                        'abreviatura_unidad' => $fila['unidad_final']
                    ];
                }
            } else {
                $error = "Error al obtener los ingredientes: " . $stmt_ingredientes->error;
            }
            $stmt_ingredientes->close();
        } else {
            $error = "Error al preparar la consulta de ingredientes: " . $conexion->error;
        }
    }

    if (defined('MODO_DESARROLLO') && MODO_DESARROLLO === true) {
        echo "</div>";
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
            <img src="sources/iconos/Shopping-Basket-3--Streamline-Ultimate.svg" width="48px" alt="Carrito de la compra"> 
            <h1>Lista de la compra de la Semana</h1>
        </div>

        <div class="subtitulo">
            <?php
            // Mostrar subtítulo con nick, id_dieta y fecha
            include_once 'controllers/session.php';
            $nick = htmlspecialchars(getUserNick());
            $id_dieta = isset($_GET['id_dieta']) ? intval($_GET['id_dieta']) : '';
            $fecha_dieta = '';
            $error_subtitulo = '';
            if ($id_dieta) {
                try {
                    $sql = "SELECT fecha_creacion FROM dietas WHERE id_dieta = ?";
                    $stmt = $conexion->prepare($sql);
                    if (!$stmt) throw new Exception($conexion->error);
                    $stmt->bind_param("i", $id_dieta);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_assoc()) {
                        $fecha_dieta = date('d-m-Y', strtotime($row['fecha_creacion']));
                    }
                    $stmt->close();
                } catch (Exception $e) {
                    $error_subtitulo = 'No se pudo obtener la información de la dieta.';
                    echo '<script>console.error(' . json_encode($e->getMessage()) . ');</script>';
                }
            }
            if ($nick && $id_dieta && $fecha_dieta) {
                echo '<h3 style="font-size:1.1em; font-weight:normal; margin-top:10px; color:#666;">Hola: ' . $nick . '😄. tu Dieta ID: ' . $id_dieta . '  con fecha: ' . $fecha_dieta . ', tiene todos estos ingredientes💖. Buena compra!👍</h3>';
            } elseif ($error_subtitulo) {
                echo '<div style="color: #b94a48; font-size:1em; margin-top:10px;">' . $error_subtitulo . '</div>';
            }
            ?>
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