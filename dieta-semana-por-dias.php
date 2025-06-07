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
// Determinar la dieta seleccionada
$id_dieta_seleccionada = isset($_GET['id_dieta']) ? intval($_GET['id_dieta']) : ($lista_dietas[0]['id_dieta'] ?? null);
if ($id_dieta_seleccionada) {
    $planDieta = Dieta::getPlanDieta($id_dieta_seleccionada);
}

// Cargar los estilos CSS
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/dieta-semana-dias.css?v=' . filemtime('styles/dieta-semana-dias.css') . '">';

// Definir $dia para el selector móvil
$dia = isset($_GET['dia']) ? strtolower($_GET['dia']) : 'lunes';
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
                <div class="top-filters-row-selectores">
                    <div class="filter-section">
                        <label for="ordenar">Vista por:</label>
                        <select name="ordenar" id="ordenar">
                            <option value="des">Desayuno</option>
                            <option value="comida">Comida</option>
                            <option value="cena">Cena</option>
                            <option value="todo">Dieta completa</option>
                        </select>
                    </div>
                    <!-- Selector de dieta -->
                    <div class="filter-section">
                        <label for="selector-dieta">Nº dieta:</label>
                        <select id="selector-dieta" name="selector-dieta">
                            <?php foreach ($lista_dietas as $dieta_item): ?>
                                <?php 
                                $fecha = date('d-m-Y', strtotime($dieta_item['fecha_creacion']));
                                $selected = ($dieta_item['id_dieta'] == $id_dieta_seleccionada) ? 'selected' : '';
                                ?>
                                <option value="<?= $dieta_item['id_dieta'] ?>" <?= $selected ?>>Dieta <?= $dieta_item['id_dieta'] ?> (creada el <?= $fecha ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="top-filters-row-botones">
                    <div class="filter-section">
                        <a href="#" id="generarNuevaDietaBtn" class="action-btn-naranja">Generar nueva dieta</a>
                    </div>
                    <div class="filter-section">
                        <a href="lista-semana.php?id_dieta=<?= $id_dieta_seleccionada ?>" class="action-btn-rosa">Lista compra semanal</a>
                    </div>
                    <div class="filter-section">
                        <a href="perfil-logueado.php" class="action-btn-verde">Editar perfil-salud</a>
                    </div>
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
                    $userNick = htmlspecialchars((string)(getUserNick() ?? ''));
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
                                return htmlspecialchars((string)($a['nombre'] ?? '')); 
                            }, $usuarioAlergias);
                            $mensaje[] = 'tenemos en cuenta tu/s alergia/s a <strong><u>' . formatearLista($nombresAlergias) . '</u></strong>';
                        }

                        if (!empty($usuarioEnfermedades)) {
                            $nombresEnfermedades = array_map(function($e) { 
                                return htmlspecialchars((string)($e['nombre'] ?? '')); 
                            }, $usuarioEnfermedades);
                            $mensaje[] = 'consideramos tus enfermedades <strong><u>' . formatearLista($nombresEnfermedades) . '</u></strong>';
                        }
                        
                        if (!empty($mensaje)) {
                            echo ' ' . ucfirst(implode(' y ', $mensaje)) . '.';
                        }
                    endif; 
                    ?></p>
                    
                        <ul style="list-style-type:disc; margin-left: 2em;">
                        <p>Puedes ver los platos de cada día de la semana por franja del día.</p>
                            <li>Puedes cambiar con el selector entre: <i>desayuno, comida, cena o la dieta completa.</i></li>
                            <li>Si <b>haces clic</b> en <b>la imagen de una receta</b> podrás ver la <b>ficha completa.</b></li>
                            <li>Puedes <b>seleccionar en el día</b> de la semana para ver la <b>dieta completa</b> de ese día.</li>
                            <li>Y por supuesto, puedes <b>generar una nueva dieta</b> en cualquier momento y seleccionar la que quieras ver.</li>
                        </ul>
                        <p>Si tienes alguna duda, puedes contactar con nosotros en el <a href="contacto.php"><u><i>formulario de contacto</i></a></u>.</p>
                    <p>¡Buen provecho!</p>
                </div>

                <!-- Barra de navegación de días (para móvil) -->
                <!-- <div class="mobile-day-nav">
                    <?php
                    $dias = [
                        ['key' => 'lunes', 'label' => 'Lunes'],
                        ['key' => 'martes', 'label' => 'Martes'],
                        ['key' => 'miercoles', 'label' => 'Miércoles'],
                        ['key' => 'jueves', 'label' => 'Jueves'],
                        ['key' => 'viernes', 'label' => 'Viernes'],
                        ['key' => 'sabado', 'label' => 'Sábado'],
                        ['key' => 'domingo', 'label' => 'Domingo']
                    ];
                    ?>
                    <?php foreach ($dias as $diaData): $diaKey = $diaData['key']; $diaLabel = $diaData['label']; ?>
                        <div class="filter-section">
                            <a href="dieta-dia.php?dia=<?= $diaKey ?>&id_dieta=<?= $id_dieta_seleccionada ?>" class="action-btn<?= (strtolower($dia) == $diaKey ? ' active-day' : '') ?>"><?= $diaLabel ?></a>
                        </div>
                    <?php endforeach; ?>
                </div> -->

                <!-- Añadir después de la barra de navegación de días (mobile-day-nav) -->
                ?>
                <div class="mobile-day-select" style="display:none; margin-bottom: 20px;">
                    <label for="selector-dia" style="font-weight:bold;">Selecciona un día:</label>
                    <select id="selector-dia" name="selector-dia" style="width:100%; padding:10px; border-radius:6px;">
                        <?php foreach ([
                            'lunes' => 'Lunes',
                            'martes' => 'Martes',
                            'miercoles' => 'Miércoles',
                            'jueves' => 'Jueves',
                            'viernes' => 'Viernes',
                            'sabado' => 'Sábado',
                            'domingo' => 'Domingo'
                        ] as $diaKey => $diaLabel): ?>
                            <option value="<?= $diaKey ?>" <?= ($dia == $diaKey ? 'selected' : '') ?>><?= $diaLabel ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <script>
                // Mostrar el select solo en móvil
                function mostrarSelectDiaMobile() {
                    if(window.innerWidth <= 768) {
                        document.querySelector('.mobile-day-select').style.display = 'block';
                    } else {
                        document.querySelector('.mobile-day-select').style.display = 'none';
                    }
                }
                window.addEventListener('DOMContentLoaded', mostrarSelectDiaMobile);
                window.addEventListener('resize', mostrarSelectDiaMobile);
                // Redirigir al cambiar el select
                const selectorDia = document.getElementById('selector-dia');
                if(selectorDia) {
                    selectorDia.addEventListener('change', function() {
                        const dia = this.value;
                        const idDieta = <?= json_encode($id_dieta_seleccionada) ?>;
                        window.location.href = 'dieta-semana-por-dias.php?dia=' + dia + '&id_dieta=' + idDieta;
                    });
                }
                </script>

                <!-- Bucle dinámico para cada tipo de comida -->
                <?php
                $tipos = [
                    'Desayuno' => 'DESAYUNOS',
                    'Entrante' => 'ENTRANTES',
                    'Principal' => 'PRINCIPALES',
                    'Postre' => 'POSTRES',
                    'Cena' => 'CENAS'
                ];
                ?>
                <!-- Bucle dinámico para cada tipo de comida -->
                <?php foreach ($tipos as $tipo => $tipoLabel): ?>
                <div class="meal-time-row" data-tipo="<?= strtolower($tipo) ?>">
                    <div class="time-label">
                        <span><?= $tipoLabel ?></span>
                    </div>
                    <div class="meal-container">
                        <?php foreach ($dias as $diaData): $diaKey = $diaData['key']; $diaLabel = $diaData['label']; ?>
                            <div class="filter-section day-col day-col-<?= $diaKey ?><?= ($dia == $diaKey ? ' active-mobile-day' : '') ?>">
                                <div class="celda-receta">
                                    <a href="dieta-dia.php?dia=<?= $diaKey ?>&id_dieta=<?= $id_dieta_seleccionada ?>" class="enlace-dia-semana">
                                        <div class="dia-semana-label action-btn"><?= $diaLabel ?></div>
                                        <div class="ver-dieta-dia">Dieta del día</div>
                                    </a>
                                    <?php if ($planDieta[$diaLabel][$tipo] ?? null && is_array($planDieta[$diaLabel][$tipo])): ?>
                                        <a href="index.php?page=detalle-receta&id=<?= htmlspecialchars($planDieta[$diaLabel][$tipo]['id'] ?? '') ?>" title="Ver receta de <?= htmlspecialchars($planDieta[$diaLabel][$tipo]['nombre'] ?? '') ?>">
                                            <img src="sources/platos/id<?= htmlspecialchars($planDieta[$diaLabel][$tipo]['id'] ?? '') ?>.png" alt="<?= htmlspecialchars($planDieta[$diaLabel][$tipo]['nombre'] ?? '') ?>" class="img-receta-dia" />
                                        </a>
                                        <div class="nombre-receta-dia"><?= htmlspecialchars($planDieta[$diaLabel][$tipo]['nombre'] ?? '') ?></div>
                                    <?php else: ?>
                                        <div class="nombre-receta-dia">No asignada</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
            </div>

            <a href="lista-semana.php?id_dieta=<?= $id_dieta_seleccionada ?>" style="background-color: var(--terciary-color);" class="btn-opciones">Ver lista de la compra de la semana</a>
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
                    <a href="contacto.php" class="btn btn-primary" style="margin: 10px;">Hazte Premium</a>
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
document.getElementById('selector-dieta').addEventListener('change', function() {
    const idDieta = this.value;
    window.location.href = 'dieta-semana-por-dias.php?id_dieta=' + idDieta;
});

document.getElementById('generarNuevaDietaBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const numDietas = <?= count($lista_dietas) ?>;
    if (numDietas >= 4) {
        Swal.fire({
            title: 'Límite alcanzado',
            text: 'No puedes generar más de 4 dietas. Elimina alguna para crear una nueva.',
            icon: 'warning',
            confirmButtonText: 'Entendido',
            customClass: {
                container: 'my-swal-container',
                popup: 'my-swal-popup',
                title: 'my-swal-title',
                confirmButton: 'my-swal-confirm-button'
            }
        });
        return;
    }
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
<style>
.enlace-dia-semana:hover .dia-semana-label,
.enlace-dia-semana:hover .ver-dieta-dia {
    background: #388e3c;
    color: #fff;
    transition: background 0.2s, color 0.2s;
}
</style>
<?php include 'footer.php'; ?>