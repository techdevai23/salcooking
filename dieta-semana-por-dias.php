
<?php
session_start();
require_once __DIR__ . '/models/usuario.php';
require_once __DIR__ . '/models/dieta.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['redirect_after_login'] = 'dieta-semana-por-dias.php';
    header('Location: login.php');
    exit;
}

$usuarioModel = new Usuario();
$usuario = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);

// Verificar si se pudo obtener el usuario
if (!$usuario) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Verificar si el usuario es premium
if (!isset($usuario['es_premium']) || $usuario['es_premium'] != 1) {
    header('Location: no-premium.php');
    exit;
}

// Obtener la última dieta del usuario
$dieta = Dieta::getUltimaDietaUsuario($_SESSION['usuario_id']);

// Si no tiene dieta, redirigir a la página para generar una
if (!$dieta) {
    header('Location: primera-vez.php');
    exit;
}

// Cargar los estilos CSS
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/dieta-semana-dias.css?v=' . filemtime('styles/dieta-semana-dias.css') . '">';
?>
<?php include 'header.php'; ?>

<!-- dieta semana organizada por dias -->

<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Dieta de la Semana</li>
        </ul>
    </div>
</div>

<!-- Contenido principal-->
 <section class="dieta-semana-por-dias"> 
<div class="dieta-semana">
    <div class="main-content">
        <div class="titulo">
            <img src="sources/iconos/semana.svg" alt="calendario semana">
            <h1>Dieta de la Semana </h1>
        </div>
        <!-- barra de navegación de opciones -->
        <div class="top-filters-bar">
            <div class="filter-section">
                <label for="ordenar">Vista por:</label>
                <select name="ordenar" id="ordenar">
                    <option value="des">Desayuno</option>
                    <option value="comida">Comida</option>
                    <option value="cena">Cena</option>
                    <option value="todo">Dieta completa</option>
                </select>
            </div>
            <div class="filter-section">
                <a href="#" class="action-btn-naranja">Generar nueva dieta</a>
            </div>
            <div class="filter-section">
                <a href="lista-semana.php" class="action-btn-rosa">Lista compra semanal</a>
            </div>
            <div class="filter-section">
                <a href="perfil-logueado.php" class="action-btn-verde">Editar perfil-salud</a>
            </div>
        </div>



        <div class="meal-schedule">
            <div class="instrucciones banner-redondeado">
                <h2>Indicaciones</h2>
                <p>Esta es una dieta semanal personalizada <b>exclusivamente para ti.</b></p>
                <p>Puedes ver los platos de cada día de la semana por franja del día. Puedes cambiar con el selector entre: <i>desayuno, comida, cena o la dieta completa.</i>
                    Si <b>haces clic</b> en una <b>la imagen de una receta</b> podrás ver la <b>ficha completa.</b></p>
                <p>Puedes <b>seleccionar en el día</b> de la semana para ver la <b> dieta completa</b> de ese día.</p>
                <p>¡Buen provecho!</p>
            </div>

            <!-- Barra de navegación de días (para móvil) -->
            <div class="mobile-day-nav">
                <button class="day-tab active" data-daynav="lunes">L</button>
                <button class="day-tab" data-daynav="martes">M</button>
                <button class="day-tab" data-daynav="miercoles">X</button>
                <button class="day-tab" data-daynav="jueves">J</button>
                <button class="day-tab" data-daynav="viernes">V</button>
                <button class="day-tab" data-daynav="sabado">S</button>
                <button class="day-tab" data-daynav="domingo">D</button>
            </div>

            <!-- Bucle dinámico para cada tipo de comida -->
            <?php
            $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
            // Asegurarse de que $planDieta está definido
            if (!isset($planDieta) || !is_array($planDieta)) {
                echo "<p>No se pudo generar el plan de dieta. Por favor, inténtalo de nuevo.</p>";
                return;
            }

            $tipos = [
                'Desayuno' => 'DESAYUNOS',
                'Entrante' => 'ENTRANTES',
                'Principal' => 'PRINCIPALES',
                'Postre' => 'POSTRES',
                'Cena' => 'CENAS'
            ];
            ?>
            <?php foreach ($tipos as $tipo => $tipoLabel): ?>
            <div class="meal-time-row" data-tipo="<?= strtolower($tipo) ?>">
                <div class="time-label">
                    <span><?= $tipoLabel ?></span>
                </div>
                <div class="meal-container">
                    <?php foreach ($dias as $dia): 
                        $receta = $planDieta[$dia][$tipo] ?? null;
                    ?>
                        <div class="meal-item" data-day="<?= strtolower($dia) ?>">
                            <a href="dieta-dia.php?dia=<?= strtolower($dia) ?>&tipo=<?= strtolower($tipo) ?>" title="Ver receta de <?= $dia ?>">
                                <h3><?= $dia ?></h3>
                            </a>
                            <br>
                            <?php if ($receta && is_array($receta)): ?>
                                <a href="detalle-receta.php?id=<?= htmlspecialchars($receta['id'] ?? '') ?>" title="Ver receta de <?= htmlspecialchars($receta['nombre']) ?>">
                                    <img src="sources/platos/id<?= htmlspecialchars($receta['id'] ?? '') ?>.png" alt="<?= htmlspecialchars($receta['nombre']) ?>">
                                </a>
                                <p><?= htmlspecialchars($receta['nombre']) ?></p>
                            <?php else: ?>
                                <p>No asignada</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>


        </div>

        <a href="lista-semana.php" class="btn-opciones">Ver lista de la compra de la semana</a>
        <a href="index.php" class="btn-opciones">Volver al Inicio</a>
    </div>
</div>
</section>
<script src="scripts/dieta-semana.js"></script>
<?php include 'footer.php'; ?>