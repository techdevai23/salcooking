<?php
require_once __DIR__ . '/models/usuario.php';
require_once __DIR__ . '/models/dieta.php';
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['redirect_after_login'] = 'dieta-dia.php';
    header('Location: login.php');
    exit;
}

$usuarioModel = new Usuario();
$usuario = $usuarioModel->obtenerPorId($_SESSION['id_usuario']);
if (!$usuario) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$es_premium = isset($usuario['es_premium']) && $usuario['es_premium'] == 1;

// Obtener todas las dietas del usuario (ordenadas por fecha DESC)
$lista_dietas = [];
if ($es_premium) {
    $sql = "SELECT id_dieta, fecha_creacion FROM dietas WHERE id_usuario = ? ORDER BY fecha_creacion DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $_SESSION['id_usuario']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $lista_dietas[] = $row;
    }
    $stmt->close();
}

// Mapeo de días sin acentos a días con acentos
$dias_map = [
    'lunes' => 'Lunes',
    'martes' => 'Martes',
    'miercoles' => 'Miércoles',
    'jueves' => 'Jueves',
    'viernes' => 'Viernes',
    'sabado' => 'Sábado',
    'domingo' => 'Domingo'
];
$dias = array_keys($dias_map);
$dia = isset($_GET['dia']) && in_array(strtolower($_GET['dia']), $dias) ? strtolower($_GET['dia']) : 'lunes';
$dia_clave = $dias_map[$dia];
$id_dieta = isset($_GET['id_dieta']) ? intval($_GET['id_dieta']) : ($lista_dietas[0]['id_dieta'] ?? null);

// Obtener la dieta semanal
$planDieta = $id_dieta ? Dieta::getPlanDieta($id_dieta) : null;

// Cargar los estilos CSS
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/dieta-semana.css?v=' . filemtime('styles/dieta-semana.css') . '">';
?>
<?php include 'header.php'; ?>

<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Dieta del Día</li>
        </ul>
    </div>
</div>

<!-- Contenido principal-->
<section class="dieta-semana">
    <div class="main-content">
        <div class="titulo">
            <img src="sources/iconos/semana.svg" alt="calendario semana">
            <h1>Dieta del Día</h1>
        </div>

        <!-- barra de navegación de opciones -->
        <div class="top-filters-bar">
            <div class="filter-section">
                <a href="dieta-semana-por-dias.php?id_dieta=<?= $id_dieta ?>" class="action-btn-naranja">Dieta de la semana</a>
            </div>
            <div class="filter-section">
                <a href="lista-dia.php?id_dieta=<?= $id_dieta ?>&dia=<?= $dia ?>" class="action-btn-rosa">Lista compra de éste día</a>
            </div>
            <div class="filter-section">
                <a href="perfil-logueado.php" class="action-btn-verde">Editar perfil-salud</a>
            </div>
            <div class="filter-section">
                <label for="selector-dieta">Nº dieta:</label>
                <select id="selector-dieta" name="selector-dieta">
                    <?php foreach ($lista_dietas as $dieta_item): ?>
                        <?php 
                        $fecha = date('d-m-Y', strtotime($dieta_item['fecha_creacion']));
                        $selected = ($dieta_item['id_dieta'] == $id_dieta) ? 'selected' : '';
                        ?>
                        <option value="<?= $dieta_item['id_dieta'] ?>" <?= $selected ?>>Dieta <?= $dieta_item['id_dieta'] ?> (<?= $fecha ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Barra de navegación de días -->
        <div class="top-filters-bar">
            <?php foreach ($dias_map as $diaKey => $diaLabel): ?>
                <div class="filter-section">
                    <a href="dieta-dia.php?dia=<?= $diaKey ?>&id_dieta=<?= $id_dieta ?>" class="action-btn<?= ($dia == $diaKey ? ' active-day' : '') ?>"><?= $diaLabel ?></a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- recetas -->
        <div class="meal-schedule">
            <?php
            $tipos = [
                'Desayuno' => 'Desayuno',
                'Comida' => 'Comida',
                'Cena' => 'Cena'
            ];
            // Desayuno
            $recetaDesayuno = $planDieta[$dia_clave]['Desayuno'] ?? null;
            ?>
            <div class="meal-section" id="desayuno">
                <h2>Desayuno</h2>
                <div class="meal-container">
                    <?php if ($recetaDesayuno && is_array($recetaDesayuno)): ?>
                        <div class="meal-item">
                        <a href="index.php?page=detalle-receta&id=<?= htmlspecialchars($recetaDesayuno['id'] ?? '') ?>" title="Ver receta de <?= htmlspecialchars($recetaDesayuno['nombre'] ?? '') ?>">
                            <img src="sources/platos/id<?= htmlspecialchars($recetaDesayuno['id'] ?? '') ?>.png" alt="<?= htmlspecialchars($recetaDesayuno['nombre']) ?>">
                            <h3><?= htmlspecialchars($recetaDesayuno['nombre']) ?></h3>
                        </a>
                        </div>
                    <?php else: ?>
                        <div class="meal-item">
                            <p>No asignada</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Comida: mostrar Entrante, Principal y Postre -->
            <div class="meal-section" id="comida">
                <h2>Comida</h2>
                <div class="meal-container">
                    <?php
                    $comidaTipos = ['Entrante' => 'Entrante', 'Principal' => 'Principal', 'Postre' => 'Postre'];
                    foreach ($comidaTipos as $tipoComida => $labelComida):
                        $recetaComida = $planDieta[$dia_clave][$tipoComida] ?? null;
                    ?>
                        <div class="meal-item">
                            <?php if ($recetaComida && is_array($recetaComida)): ?>
                                <a href="index.php?page=detalle-receta&id=<?= htmlspecialchars($recetaComida['id'] ?? '') ?>" title="Ver receta de <?= htmlspecialchars($recetaComida['nombre'] ?? '') ?>">
                                    <img src="sources/platos/id<?= htmlspecialchars($recetaComida['id'] ?? '') ?>.png" alt="<?= htmlspecialchars($recetaComida['nombre']) ?>">
                                    <h3><?= htmlspecialchars($recetaComida['nombre']) ?></h3>
                                </a>
                                <p style="font-size: 0.9em; color: #888; margin:0;">(<?= $labelComida ?>)</p>
                            <?php else: ?>
                                <p>No asignada<br><span style="font-size: 0.9em; color: #888;">(<?= $labelComida ?>)</span></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Cena -->
            <?php $recetaCena = $planDieta[$dia_clave]['Cena'] ?? null; ?>
            <div class="meal-section" id="cena">
                <h2>Cena</h2>
                <div class="meal-container">
                    <?php if ($recetaCena && is_array($recetaCena)): ?>
                        <div class="meal-item">
                            <a href="index.php?page=detalle-receta&id=<?= htmlspecialchars($recetaCena['id'] ?? '') ?>" title="Ver receta de <?= htmlspecialchars($recetaCena['nombre'] ?? '') ?>">
                                <img src="sources/platos/id<?= htmlspecialchars($recetaCena['id'] ?? '') ?>.png" alt="<?= htmlspecialchars($recetaCena['nombre']) ?>">
                                <h3><?= htmlspecialchars($recetaCena['nombre']) ?></h3>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="meal-item">
                            <p>No asignada</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <a href="lista-dia.php?id_dieta=<?= $id_dieta ?>&dia=<?= $dia ?>" style="background-color: var(--terciary-color);" class="btn-opciones">Ver lista de la compra del día</a>
        <a href="index.php" class="btn-opciones">Volver al Inicio</a>
    </div>
</section>

<script>
document.getElementById('selector-dieta').addEventListener('change', function() {
    const idDieta = this.value;
    const urlParams = new URLSearchParams(window.location.search);
    const dia = urlParams.get('dia') || 'lunes';
    window.location.href = 'dieta-dia.php?dia=' + dia + '&id_dieta=' + idDieta;
});
</script>
<?php include 'footer.php'; ?>