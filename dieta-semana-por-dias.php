<?php
session_start();
require_once __DIR__ . '/models/usuario.php';
require_once __DIR__ . '/models/dieta.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['redirect_after_login'] = 'dieta-semana-por-dias.php';
    header('Location: login.php');
    exit;
}

$usuarioModel = new Usuario();
$usuario = $usuarioModel->obtenerPorId($_SESSION['id_usuario']);

// Verificar si se pudo obtener el usuario
if (!$usuario) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$es_premium = isset($usuario['es_premium']) && $usuario['es_premium'] == 1;
$error_generacion = '';

// Obtener la última dieta del usuario solo si es premium
if ($es_premium) {
    $dieta = Dieta::getUltimaDietaUsuario($_SESSION['id_usuario']);
    if (!$dieta) {
        // Generar dieta automáticamente en el backend
        try {
            $alergias = Dieta::getAlergiasUsuario($_SESSION['id_usuario']);
            $enfermedades = Dieta::getEnfermedadesUsuario($_SESSION['id_usuario']);
            $recetasAptas = Dieta::getRecetasAptas($alergias, $enfermedades);

            // // debug**************
            // echo '<pre>';
            // var_dump($alergias, $enfermedades, $recetasAptas);
            // echo '</pre>';

            if (empty($recetasAptas)) {
                throw new Exception('No hay suficientes recetas disponibles para generar una dieta con tus preferencias actuales.');
            }
            $planSemanal = Dieta::generarPlanSemanal($recetasAptas);
            if (empty($planSemanal)) {
                throw new Exception('No se pudo generar el plan semanal. Por favor, inténtalo de nuevo.');
            }
            $idDieta = Dieta::crearYGuardarDieta($_SESSION['id_usuario'], $planSemanal);
            if (!$idDieta) {
                throw new Exception('Error al guardar la dieta. Por favor, inténtalo de nuevo.');
            }
            $dieta = ['id_dieta' => $idDieta];
        } catch (Exception $e) {
            $error_generacion = $e->getMessage();
        }
    }
    if (isset($dieta['id_dieta'])) {
        $planDieta = Dieta::getPlanDieta($dieta['id_dieta']);
        // // debug**************
        // echo '<pre>';
        // var_dump($dieta, $planDieta);
        // echo '</pre>';
    }
}

// Cargar los estilos CSS
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/dieta-semana-dias.css?v=' . filemtime('styles/dieta-semana-dias.css') . '">';
?>
<?php include 'header.php'; ?>

<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Dieta de la Semana</li>
        </ul>
    </div>
</div>

<!-- Contenido para usuarios premium -->
<div id="premium-content" style="display: <?= $es_premium ? 'block' : 'none' ?>;">
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
                    <a href="#" id="generarNuevaDietaBtn" class="action-btn-naranja">Generar nueva dieta</a>
                </div>
                <div class="filter-section">
                    <a href="lista-semana.php" class="action-btn-rosa">Lista compra semanal</a>
                </div>
                <div class="filter-section">
                    <a href="perfil-logueado.php" class="action-btn-verde">Editar perfil-salud</a>
                </div>
            </div>

            <?php if ($error_generacion): ?>
                <div class="alert alert-danger" style="margin: 30px 0;">
                    <strong>Error:</strong> <?= htmlspecialchars($error_generacion) ?>
                </div>
            <?php endif; ?>

            <div class="meal-schedule">
                <div class="instrucciones banner-redondeado">
                    <h2>Indicaciones</h2>
                    <p>Esta es una dieta semanal personalizada <b>exclusivamente para ti <?php 
                    $userNick = htmlspecialchars(getUserNick());
                    echo $userNick . '</b>.';
                    
                    if (isset($_SESSION['id_usuario'])): 
                        // Función auxiliar para formatear listas
                        function formatearLista($items) {
                            if (count($items) === 1) {
                                return $items[0];
                            }
                            $ultimo = array_pop($items);
                            return implode(', ', $items) . ' y ' . $ultimo;
                        }

                        $usuarioAlergias = Dieta::getAlergiasUsuario($_SESSION['id_usuario']);
                        $usuarioEnfermedades = Dieta::getEnfermedadesUsuario($_SESSION['id_usuario']);
                        $mensaje = [];
                        
                        if (!empty($usuarioAlergias)) {
                            $nombresAlergias = array_map(function($a) { 
                                return htmlspecialchars($a['nombre']); 
                            }, $usuarioAlergias);
                            $mensaje[] = 'tenemos en cuenta tu/s alergia/s a <u>' . formatearLista($nombresAlergias) . '</u>';
                        }

                        if (!empty($usuarioEnfermedades)) {
                            $nombresEnfermedades = array_map(function($e) { 
                                return htmlspecialchars($e['nombre']); 
                            }, $usuarioEnfermedades);
                            $mensaje[] = 'consideramos tus enfermedades <u>' . formatearLista($nombresEnfermedades) . '</u>';
                        }
                        
                        if (!empty($mensaje)) {
                            echo ' ' . ucfirst(implode(' y ', $mensaje)) . '.';
                        }
                    endif; 
                    ?></p>
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
                if (!isset($planDieta) || !is_array($planDieta)) {
                    echo "<p>No se pudo generar el plan de dieta. Por favor, inténtalo de nuevo.</p>";
                } else {
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
                <?php } ?>
            </div>

            <a href="lista-semana.php" class="btn-opciones">Ver lista de la compra de la semana</a>
            <a href="index.php" class="btn-opciones">Volver al Inicio</a>
        </div>
    </div>
    </section>
</div>

<!-- Contenido para usuarios NO premium -->
<div id="no-premium-content" style="display: <?= $es_premium ? 'none' : 'block' ?>;">
    <section class="dieta-semana-por-dias">
        <div class="dieta-semana">
            <div class="main-content">
                <div class="mensaje-no-premium banner-redondeado" style="text-align:center; margin: 60px auto; max-width: 600px;">
                    <h2>¡Hazte Premium para ver tu dieta semanal!</h2>
                    <p>Esta sección es exclusiva para usuarios premium. Si quieres acceder a tu dieta personalizada, hazte premium.</p>
                    <a href="premium.php" class="btn btn-primary" style="margin: 10px;">Hazte Premium</a>
                    <a href="index.php" class="btn btn-secondary" style="margin: 10px;">Volver al inicio</a>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="scripts/dieta-semana.js"></script>
<!-- Overlay de carga -->
<div id="loadingOverlay" style="display: none;">
  <div class="custom-overlay-content">
    <div class="custom-spinner"></div>
    <h4>Generando tu nueva dieta semanal</h4>
    <p>Esto puede tomar unos segundos...</p>
  </div>
</div>
<script>
document.getElementById('generarNuevaDietaBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const overlay = document.getElementById('loadingOverlay');
    overlay.style.display = 'flex';
    fetch('generar-dieta.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success || data.redirect) {
            window.location.reload();
        } else {
            overlay.style.display = 'none';
            alert(data.error || 'No se pudo generar la dieta.');
        }
    })
    .catch(error => {
        overlay.style.display = 'none';
        alert('Ocurrió un error al generar la dieta. Por favor, inténtalo de nuevo.');
    });

    // Verificar el parámetro aplicar_perfil_salud en la URL
    const urlParams = new URLSearchParams(window.location.search);
    const aplicarPerfilSalud = urlParams.get('aplicar_perfil_salud');
    
    // Si el parámetro está presente y es '1', mostrar el tooltip
    if (aplicarPerfilSalud === '1') {
        const tooltipContainer = document.getElementById('perfil-salud-tooltip');
        if (tooltipContainer) {
            // Mostrar el contenedor del tooltip
            tooltipContainer.style.display = 'inline-flex';
            tooltipContainer.style.alignItems = 'center';
            tooltipContainer.style.marginLeft = '5px';
            
            // Asegurarse de que el tooltip tenga el estilo correcto
            const tooltip = tooltipContainer.querySelector('.tooltip');
            if (tooltip) {
                tooltip.style.display = 'none'; // Inicialmente oculto
                tooltip.style.position = 'absolute';
                tooltip.style.zIndex = '1000';
                tooltip.style.background = '#fff';
                tooltip.style.padding = '10px';
                tooltip.style.borderRadius = '5px';
                tooltip.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                tooltip.style.minWidth = '200px';
                tooltip.style.maxWidth = '300px';
                
                // Mostrar/ocultar tooltip al pasar el ratón
                tooltipContainer.addEventListener('mouseenter', function(e) {
                    tooltip.style.display = 'block';
                    // Posicionar el tooltip debajo del ícono
                    const rect = tooltipContainer.getBoundingClientRect();
                    tooltip.style.top = (rect.bottom + window.scrollY) + 'px';
                    tooltip.style.left = (rect.left + window.scrollX) + 'px';
                });
                
                tooltipContainer.addEventListener('mouseleave', function() {
                    tooltip.style.display = 'none';
                });
            }
        }
    }
});
</script>
<?php include 'footer.php'; ?>