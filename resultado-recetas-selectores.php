<?php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/resultado-recetas.css?v=' . filemtime('styles/resultado-recetas.css') . '">';
?>

<?php include('header.php'); ?>

<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="recetas-categoria.php">Receta</a></li>
            <li class="current">Resultados de Recetas</li>
        </ul>
    </div>
</div>

<!-- Contenido principal-->
<section class="resultados-recetas">
    <div class="container-resultados">
        <div class="titulo">
            <img src="sources/iconos/Search-Circle--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
            <h1>Resultados de Recetas</h1>
            <?php if (!empty($resultados)): ?>
                <p class="contador-resultados">Se encontraron <?= count($resultados) ?> receta<?= count($resultados) > 1 ? 's' : '' ?></p>
            <?php endif; ?>
        </div>
        <div class="page-background">
            <div class="content-wrapper">
                <div class="results-container">

                    <!-- Tu barra de filtros normal + prémium -->
                     <!-- Barra de filtros superior -->
                    <div class="top-filters-bar">
                        <div class="filter-section">
                            <label for="ordenar">Ordenar:</label>
                            <select name="ordenar" id="ordenar">
                                <option value="">Más recientes</option>
                                <option value="nombre-asc">Nombre (A-Z)</option>
                                <option value="nombre-desc">Nombre (Z-A)</option>
                                <option value="ing-menos-6">Ingredientes (menos de 6)</option>
                                <option value="ing-7-10">Ingredientes (7-10)</option>
                                <option value="ing-mas-10">Ingredientes (más de 10)</option>
                            </select>
                        </div>
                        
                        <div class="filter-section">
                            <label for="tipo-plato">Tipo de plato:</label>
                            <select name="tipo-plato" id="tipo-plato">
                                <option value="">Todos los tipos</option>
                                <option value="desayuno">Desayuno</option>
                                <option value="entrante">Entrante</option>
                                <option value="principal">Principal</option>
                                <option value="postre">Postre</option>
                            </select>
                        </div>
                        
                        <div class="filter-section">
                        <label for="alergenos">Evitar:</label>
                            <select name="alergenos" id="alergenos">
                                <option value="">Permitidos</option>
                                <option value="1">Frutos secos</option>
                                <option value="2">Gluten</option>
                                <option value="3">Pescado y Marisco</option>
                            </select>
                        </div>
                        
                        <div class="filter-section">
                        <label for="porciones">Porciones:</label>
                            <select name="porciones" id="porciones">
                            <option value="">Cualquiera</option>
                                <option value="2">2 porciones</option>
                                <option value="4">4 porciones</option>
                                <option value="mas-4">Más de 4 porciones</option>
                            </select>
                        </div>
                        <!-- zona de filtros y opciones premium -->
                        <div class="premium-filters">
                            <!-- Debug temporal -->
                            <?php 
                            // echo "<!-- Debug: id_usuario = " . (isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 'NO SET') . " -->";
                            // echo "<!-- Debug: disabled = " . (!isset($_SESSION['id_usuario']) ? 'disabled' : 'enabled') . " -->";
                            ?>
                            <div class="premium-header">
                                <h4>Opciones Premium</h4>
                                <img src="sources/iconos/Vip-Circle--Streamline-Ultimate.png" alt="info" class="info-icon" title="Funcionalidades exclusivas para usuarios Prémium" style="width:40px; height:40px;">
                                <?php if (!isset($_SESSION['id_usuario'])): ?>
                                    <a href="contacto.php" title="Solo puedes ganar: Hazte Prémium" class="btn-premium">Hazte Prémium</a>
                                <?php else: ?>
                                    <span class="usuario-premium">¡Funciones Premium Activas!</span>
                                <?php endif; ?>
                            </div>
                            <div class="premium-options">
                                <div class="premium-option">
                                    <select name="enfermedades" id="enfermedades" <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                        <option value="">Enfermedades</option>
                                        <option value="1">Diabetes</option>
                                        <option value="2">Colesterol alto</option>
                                    </select>
                                </div>
                                
                                <div class="premium-option">
                                    <label class="checkbox-container">
                                        <input type="checkbox" name="perfil" id="perfil" value="1" <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                        <span class="checkmark"></span>
                                        Tener en cuenta mi perfil de salud
                                    </label>
                                </div>
                                
                                <div class="premium-option">
                                    <input type="text" name="ingrediente" id="ingrediente" placeholder="Ingrediente..." <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                </div>
                                
                                <div class="premium-option">
                                    <select name="tiempo" id="tiempo" <?= !isset($_SESSION['id_usuario']) ? 'disabled' : '' ?>>
                                        <option value="">Tiempo de preparación</option>
                                        <option value="menos-30">Menos de 30 min</option>
                                        <option value="31-60">Entre 31 y 60 min</option>
                                        <option value="mas-60">Más de 60 min</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carrusel dinámico -->
                    <div class="recipiente-carrusel-container">
                        <button class="carrusel-nav prev-btn">&lt;</button>
                        <div class="recipiente-carrusel">
                            <?php if (!empty($resultados)): ?>
                                <?php 
                                $totalRecetas = count($resultados);
                                // Creamos exactamente 5 posiciones para las tarjetas
                                $posicionesCarrusel = ['left-2', 'left-1', 'center', 'right-1', 'right-2'];
                                ?>
                                <!-- Posición izquierda 2 (oculta inicialmente) -->
                                <div class="recipiente-card side-card hidden" data-position="left-2">
                                    <a href="#" class="btn-view-recipiente">Ver receta</a>
                                    <img src="" alt="">
                                    <div class="recipiente-info">
                                        <h4></h4>
                                        <div class="recipiente-tags"></div>
                                    </div>
                                </div>
                                
                                <!-- Posición izquierda 1 (oculta inicialmente) -->
                                <div class="recipiente-card side-card hidden" data-position="left-1">
                                    <a href="#" class="btn-view-recipiente">Ver receta</a>
                                    <img src="" alt="">
                                    <div class="recipiente-info">
                                        <h4></h4>
                                        <div class="recipiente-tags"></div>
                                    </div>
                                </div>
                                
                                <!-- Posición central (primera receta) -->
                                <?php if (isset($resultados[0])): ?>
                                <div class="recipiente-card featured-card" data-position="center" data-recipe-index="0">
                                    <a href="index.php?page=detalle-receta&id=<?= $resultados[0]['id'] ?>" class="btn-view-recipiente">Ver receta</a>
                                    <?php 
                                    $imagePath = "sources/platos/id{$resultados[0]['id']}.png";
                                    $imageUrl = file_exists($imagePath) ? $imagePath : "sources/platos/default.png";
                                    ?>
                                    <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($resultados[0]['nombre']) ?>">
                                    <div class="recipiente-info">
                                        <h4><?= htmlspecialchars($resultados[0]['nombre']) ?></h4>
                                        <div class="recipiente-tags">
                                            <?php if (!empty($resultados[0]['tipo_plato'])): ?>
                                                <span class="tag tag-plato"><?= strtoupper($resultados[0]['tipo_plato']) ?></span>
                                            <?php endif; ?>
                                            <?php 
                                            // Mostrar alérgenos
                                            if (!empty($resultados[0]['alergenos'])) {
                                                foreach ($resultados[0]['alergenos'] as $alergeno) {
                                                    $clase = strtolower(str_replace(' ', '-', $alergeno['nombre']));
                                                    echo '<span class="tag ' . $clase . '">' . htmlspecialchars($alergeno['nombre']) . '</span>';
                                                }
                                            }
                                            // Mostrar enfermedades (solo las NO aptas como advertencia)
                                            if (!empty($resultados[0]['enfermedades'])) {
                                                foreach ($resultados[0]['enfermedades'] as $enfermedad) {
                                                    $clase = strtolower($enfermedad['nombre']);
                                                    echo '<span class="tag ' . $clase . '">No apto ' . htmlspecialchars($enfermedad['nombre']) . '</span>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Posición derecha 1 (segunda receta) -->
                                <?php if (isset($resultados[1])): ?>
                                <div class="recipiente-card side-card" data-position="right-1" data-recipe-index="1">
                                    <a href="index.php?page=detalle-receta&id=<?= $resultados[1]['id'] ?>" class="btn-view-recipiente">Ver receta</a>
                                    <?php 
                                    $imagePath = "sources/platos/id{$resultados[1]['id']}.png";
                                    $imageUrl = file_exists($imagePath) ? $imagePath : "sources/platos/default.png";
                                    ?>
                                    <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($resultados[1]['nombre']) ?>">
                                    <div class="recipiente-info">
                                        <h4><?= htmlspecialchars($resultados[1]['nombre']) ?></h4>
                                        <div class="recipiente-tags">
                                            <?php if (!empty($resultados[1]['tipo_plato'])): ?>
                                                <span class="tag tag-plato"><?= strtoupper($resultados[1]['tipo_plato']) ?></span>
                                            <?php endif; ?>
                                            <?php 
                                            // Mostrar alérgenos
                                            if (!empty($resultados[1]['alergenos'])) {
                                                foreach ($resultados[1]['alergenos'] as $alergeno) {
                                                    $clase = strtolower(str_replace(' ', '-', $alergeno['nombre']));
                                                    echo '<span class="tag ' . $clase . '">' . htmlspecialchars($alergeno['nombre']) . '</span>';
                                                }
                                            }
                                            // Mostrar enfermedades (solo las NO aptas como advertencia)
                                            if (!empty($resultados[1]['enfermedades'])) {
                                                foreach ($resultados[1]['enfermedades'] as $enfermedad) {
                                                    $clase = strtolower($enfermedad['nombre']);
                                                    echo '<span class="tag ' . $clase . '">No apto ' . htmlspecialchars($enfermedad['nombre']) . '</span>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="recipiente-card side-card hidden" data-position="right-1">
                                    <a href="#" class="btn-view-recipiente">Ver receta</a>
                                    <img src="" alt="">
                                    <div class="recipiente-info">
                                        <h4></h4>
                                        <div class="recipiente-tags"></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Posición derecha 2 (tercera receta) -->
                                <?php if (isset($resultados[2])): ?>
                                <div class="recipiente-card side-card" data-position="right-2" data-recipe-index="2">
                                    <a href="index.php?page=detalle-receta&id=<?= $resultados[2]['id'] ?>" class="btn-view-recipiente">Ver receta</a>
                                    <?php 
                                    $imagePath = "sources/platos/id{$resultados[2]['id']}.png";
                                    $imageUrl = file_exists($imagePath) ? $imagePath : "sources/platos/default.png";
                                    ?>
                                    <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($resultados[2]['nombre']) ?>">
                                    <div class="recipiente-info">
                                        <h4><?= htmlspecialchars($resultados[2]['nombre']) ?></h4>
                                        <div class="recipiente-tags">
                                            <?php if (!empty($resultados[2]['tipo_plato'])): ?>
                                                <span class="tag tag-plato"><?= strtoupper($resultados[2]['tipo_plato']) ?></span>
                                            <?php endif; ?>
                                            <?php 
                                            // Mostrar alérgenos
                                            if (!empty($resultados[2]['alergenos'])) {
                                                foreach ($resultados[2]['alergenos'] as $alergeno) {
                                                    $clase = strtolower(str_replace(' ', '-', $alergeno['nombre']));
                                                    echo '<span class="tag ' . $clase . '">' . htmlspecialchars($alergeno['nombre']) . '</span>';
                                                }
                                            }
                                            // Mostrar enfermedades (solo las NO aptas como advertencia)
                                            if (!empty($resultados[2]['enfermedades'])) {
                                                foreach ($resultados[2]['enfermedades'] as $enfermedad) {
                                                    $clase = strtolower($enfermedad['nombre']);
                                                    echo '<span class="tag ' . $clase . '">No apto ' . htmlspecialchars($enfermedad['nombre']) . '</span>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="recipiente-card side-card hidden" data-position="right-2">
                                    <a href="#" class="btn-view-recipiente">Ver receta</a>
                                    <img src="" alt="">
                                    <div class="recipiente-info">
                                        <h4></h4>
                                        <div class="recipiente-tags"></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Almacenar datos de todas las recetas para JavaScript -->
                                <script>
                                    window.recetasData = <?php echo json_encode($resultados); ?>;
                                </script>
                            <?php else: ?>
                                <p class="no-resultados">No se han encontrado recetas para esta búsqueda.</p>
                            <?php endif; ?>
                        </div>
                        <button class="carrusel-nav next-btn">&gt;</button>
                    </div>

                    <!-- Indicadores dinámicos -->
                    <div class="carrusel-indicadores">
                        <?php
                        if (isset($totalRecetas)) {
                            $numIndicadores = ceil($totalRecetas / 2);
                            for ($i = 0; $i < $numIndicadores; $i++) {
                                echo '<span class="indicator"></span>';
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Script para manejar los filtros automáticamente
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando sistema de filtros...');
    
    // Obtener todos los selectores de filtros con validación
    const filtros = {
        ordenar: document.getElementById('ordenar'),
        tipoPlato: document.getElementById('tipo-plato'),
        alergenos: document.getElementById('alergenos'),
        porciones: document.getElementById('porciones'),
        enfermedades: document.getElementById('enfermedades'),
        tiempo: document.getElementById('tiempo'),
        ingrediente: document.getElementById('ingrediente'),
        perfil: document.getElementById('perfil')
    };

    // Verificar que los elementos existen
    Object.keys(filtros).forEach(key => {
        if (!filtros[key]) {
            console.warn(`Elemento ${key} no encontrado`);
        }
    });

    // Función para aplicar filtros
    function aplicarFiltros() {
        console.log('Aplicando filtros...');
        
        const params = new URLSearchParams(window.location.search);
        
        // Mantener el término de búsqueda si existe
        const termino = params.get('q') || '';
        
        // Construir nueva URL con filtros
        const nuevosParams = new URLSearchParams();
        if (termino) nuevosParams.set('q', termino);
        nuevosParams.set('page', 'buscar');
        
        // Debug: mostrar qué filtros se están aplicando
        const filtrosActivos = {
            tipoPlato: filtros.tipoPlato?.value || '',
            alergenos: filtros.alergenos?.value || '',
            porciones: filtros.porciones?.value || '',
            orden: filtros.ordenar?.value || '',
            enfermedad: filtros.enfermedades?.value || '',
            tiempo: filtros.tiempo?.value || '',
            ingrediente: filtros.ingrediente?.value || '',
            perfil: filtros.perfil?.checked || false
        };
        
        console.log('Filtros activos:', filtrosActivos);
        
        // Agregar filtros activos (solo si tienen valor)
        if (filtros.tipoPlato && filtros.tipoPlato.value && filtros.tipoPlato.value !== '') {
            nuevosParams.set('tipo_plato', filtros.tipoPlato.value);
            console.log('Agregando tipo_plato:', filtros.tipoPlato.value);
        }
        
        if (filtros.alergenos && filtros.alergenos.value && filtros.alergenos.value !== '') {
            nuevosParams.set('alergeno', filtros.alergenos.value);
            console.log('Agregando alergeno:', filtros.alergenos.value);
        }
        
        if (filtros.porciones && filtros.porciones.value && filtros.porciones.value !== '') {
            nuevosParams.set('porciones', filtros.porciones.value);
            console.log('Agregando porciones:', filtros.porciones.value);
        }
        
        if (filtros.ordenar && filtros.ordenar.value && filtros.ordenar.value !== '') {
            nuevosParams.set('orden', filtros.ordenar.value);
            console.log('Agregando orden:', filtros.ordenar.value);
        }
        
        // Filtros premium (solo si están habilitados y tienen valor)
        if (filtros.enfermedades && filtros.enfermedades.value && filtros.enfermedades.value !== '' && !filtros.enfermedades.disabled) {
            nuevosParams.set('enfermedad', filtros.enfermedades.value);
            console.log('Agregando enfermedad:', filtros.enfermedades.value);
        }
        
        if (filtros.tiempo && filtros.tiempo.value && filtros.tiempo.value !== '' && !filtros.tiempo.disabled) {
            nuevosParams.set('tiempo', filtros.tiempo.value);
            console.log('Agregando tiempo:', filtros.tiempo.value);
        }
        
        if (filtros.ingrediente && filtros.ingrediente.value && filtros.ingrediente.value.trim() !== '' && !filtros.ingrediente.disabled) {
            nuevosParams.set('ingrediente', filtros.ingrediente.value.trim());
            console.log('Agregando ingrediente:', filtros.ingrediente.value.trim());
        }
        
        if (filtros.perfil && filtros.perfil.checked && !filtros.perfil.disabled) {
            nuevosParams.set('perfil', '1');
            console.log('Agregando perfil: 1');
        }
        
        const urlFinal = 'index.php?' + nuevosParams.toString();
        console.log('URL final:', urlFinal);
        
        // Redirigir con los nuevos parámetros
        window.location.href = urlFinal;
    }

    // Agregar eventos a todos los selectores
    Object.entries(filtros).forEach(([nombre, filtro]) => {
        if (filtro) {
            if (filtro.tagName === 'SELECT') {
                filtro.addEventListener('change', function() {
                    console.log(`Cambio en ${nombre}:`, this.value);
                    aplicarFiltros();
                });
            } else if (filtro.type === 'checkbox') {
                filtro.addEventListener('change', function() {
                    console.log(`Cambio en ${nombre}:`, this.checked);
                    aplicarFiltros();
                });
            } else if (filtro.type === 'text') {
                // Para el campo de texto, aplicar filtro al presionar Enter
                filtro.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        console.log(`Enter en ${nombre}:`, this.value);
                        aplicarFiltros();
                    }
                });
                
                // También agregar evento blur para cuando pierde el foco
                filtro.addEventListener('blur', function() {
                    if (this.value.trim() !== '') {
                        console.log(`Blur en ${nombre}:`, this.value);
                        aplicarFiltros();
                    }
                });
            }
        }
    });

    // Restaurar valores de filtros desde la URL
    console.log('Restaurando valores desde URL...');
    const params = new URLSearchParams(window.location.search);
    
    // Mostrar todos los parámetros de la URL
    console.log('Parámetros URL:', Object.fromEntries(params));
    
    if (params.get('tipo_plato') && filtros.tipoPlato) {
        filtros.tipoPlato.value = params.get('tipo_plato');
        console.log('Restaurado tipo_plato:', params.get('tipo_plato'));
    }
    
    if (params.get('alergeno') && filtros.alergenos) {
        filtros.alergenos.value = params.get('alergeno');
        console.log('Restaurado alergeno:', params.get('alergeno'));
    }
    
    if (params.get('porciones') && filtros.porciones) {
        filtros.porciones.value = params.get('porciones');
        console.log('Restaurado porciones:', params.get('porciones'));
    }
    
    if (params.get('orden') && filtros.ordenar) {
        filtros.ordenar.value = params.get('orden');
        console.log('Restaurado orden:', params.get('orden'));
    }
    
    // Restaurar filtros premium si están disponibles
    if (params.get('enfermedad') && filtros.enfermedades && !filtros.enfermedades.disabled) {
        filtros.enfermedades.value = params.get('enfermedad');
        console.log('Restaurado enfermedad:', params.get('enfermedad'));
    }
    
    if (params.get('tiempo') && filtros.tiempo && !filtros.tiempo.disabled) {
        filtros.tiempo.value = params.get('tiempo');
        console.log('Restaurado tiempo:', params.get('tiempo'));
    }
    
    if (params.get('ingrediente') && filtros.ingrediente && !filtros.ingrediente.disabled) {
        filtros.ingrediente.value = params.get('ingrediente');
        console.log('Restaurado ingrediente:', params.get('ingrediente'));
    }
    
    if (params.get('perfil') && filtros.perfil && !filtros.perfil.disabled) {
        filtros.perfil.checked = params.get('perfil') === '1';
        console.log('Restaurado perfil:', params.get('perfil') === '1');
    }
    
    console.log('Sistema de filtros inicializado correctamente');
});
</script>

<!-- Script del carrusel dinámico -->
<script src="scripts/carrusel-scriptServidor.js"></script>

<?php include('footer.php'); ?>
