<?php
include 'conexion.php';
$css_extra = '<link rel="stylesheet" href="detalle-receta.css">';
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

<section class="receta mt-4">
    <div class="container fondo-tarjeta p-4">
        <h2><?php echo htmlspecialchars($receta['nombre']); ?></h2>
        <p><strong>Tiempo de preparación:</strong> <?php echo $receta['tiempo_preparacion']; ?> min</p>
        <p><strong>Porciones:</strong> <?php echo $receta['porciones']; ?></p>
        <h4>Ingredientes:</h4>
        <ul>
            <?php while($ing = $ingredientes->fetch_assoc()): ?>
                <li>
                    <?php echo "{$ing['cantidad']} {$ing['fraccion']} {$ing['unidad']} de {$ing['nombre']}"; ?>
                </li>
            <?php endwhile; ?>
        </ul>

        <h4>Instrucciones:</h4>
        <p><?php echo nl2br(htmlspecialchars($receta['instrucciones'])); ?></p>

        <?php if (!empty($receta['sustitutos'])): ?>
            <h5>Sustitutos:</h5>
            <p><?php echo nl2br(htmlspecialchars($receta['sustitutos'])); ?></p>
        <?php endif; ?>

        <h4>Alergias asociadas:</h4>
        <ul>
            <?php while($al = $alergias->fetch_assoc()): ?>
                <li><?php echo "{$al['nombre']} ({$al['observaciones']})"; ?></li>
            <?php endwhile; ?>
        </ul>

        <h4>Indicaciones para enfermedades:</h4>
        <ul>
            <?php while($enf = $enfermedades->fetch_assoc()): ?>
                <li><?php echo "{$enf['nombre']} ({$enf['indicaciones']})"; ?></li>
            <?php endwhile; ?>
        </ul>

        <a href="premium.php" class="btn btn-danger mt-3">Hazte Prémium</a>
    </div>
</section>

<?php include 'footer.php'; ?>
