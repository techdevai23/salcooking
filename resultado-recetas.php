<?php
$css_extra = '<link rel="stylesheet" href="styles/resultado-recetas.css">';
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
        </div>
        <div class="page-background">
            <div class="content-wrapper">
                <div class="results-container">

                    <!-- Barra de filtros superior -->
                    <div class="top-filters-bar">
                        <div class="filter-section">
                            <label for="ordenar">Ordenar:</label>
                            <select name="ordenar" id="ordenar">
                                <option value="">Seleccionar</option>
                                <option value="nombre-asc">Nombre (A-Z)</option>
                                <option value="nombre-desc">Nombre (Z-A)</option>
                                <option value="ing-menos-6">Ingredientes (menos de 6)</option>
                                <option value="ing-7-10">Ingredientes (7-10)</option>
                                <option value="ing-mas-10">Ingredientes (más de 10)</option>
                            </select>
                        </div>
                        
                        <div class="filter-section">
                            <label for="tipo-plato">Filtros:</label>
                            <select name="tipo-plato" id="tipo-plato">
                                <option value="">Tipo de plato</option>
                                <option value="entrante">Entrante</option>
                                <option value="principal">Principal</option>
                                <option value="postre">Postre</option>
                            </select>
                        </div>
                        
                        <div class="filter-section">
                            <select name="alergenos" id="alergenos">
                                <option value="">Alérgenos</option>
                                <option value="gluten">Gluten</option>
                                <option value="frutos-secos">Frutos secos</option>
                                <option value="pescado">Pescado</option>
                                <option value="marisco">Marisco</option>
                            </select>
                        </div>
                        
                        <div class="filter-section">
                            <select name="porciones" id="porciones">
                                <option value="">Porciones</option>
                                <option value="2">2 porciones</option>
                                <option value="4">4 porciones</option>
                                <option value="mas-4">Más de 4 porciones</option>
                            </select>
                        </div>
                        <!-- zona de filtros y opciones premium -->
                        <div class="premium-filters">
                            <div class="premium-header">
                                <h4>Opciones Premium</h4>
                                <a href="premium.php" class="btn-premium">Hazte Premium</a>
                            </div>
                            <div class="premium-options">
                                <div class="premium-option">
                                    <select name="enfermedades" disabled>
                                        <option value="">Enfermedades</option>
                                        <option value="diabetes">Diabetes</option>
                                        <option value="colesterol">Colesterol alto</option>
                                        <option value="ambas">Ambas</option>
                                    </select>
                                </div>
                                
                                <div class="premium-option">
                                    <label class="checkbox-container">
                                        <input type="checkbox" name="perfil" value="1" disabled>
                                        <span class="checkmark"></span>
                                        Tener en cuenta mi perfil
                                    </label>
                                </div>
                                
                                <div class="premium-option">
                                    <input type="text" name="ingrediente" placeholder="Ingrediente..." disabled>
                                </div>
                                
                                <div class="premium-option">
                                    <select name="tiempo" disabled>
                                        <option value="">Tiempo de preparación</option>
                                        <option value="menos-30">Menos de 30 min</option>
                                        <option value="31-60">Entre 31 y 60 min</option>
                                        <option value="mas-60">Más de 60 min</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carrusel de recetas -->
                    <div class="recipiente-carrusel-container">
                        <button class="carrusel-nav prev-btn">&lt;</button>
                        
                        <div class="recipiente-carrusel">
                            <!-- Las recetas que aparecen a la izquierda de la principal -->
                            <div class="recipiente-card side-card left-card">
                                <img src="sources/platos/entrante1.png" alt="Ensalada César">
                                <div class="recipiente-info">
                                    <h4>Ensalada César Clásica</h4>
                                    <p class="recipiente-tags">
                                        <span class="tag-plato">ENTRANTE</span>
                                        <span class="tag gluten">Contiene Gluten</span>
                                    </p>
                                    <a href="" class="btn-view-recipiente">Ver receta</a>
                                </div>
                            </div>
                            
                            <div class="recipiente-card side-card left-card">
                                <img src="sources/platos/entrante1.png" alt="Pollo asado con patatas">
                                <div class="recipiente-info">
                                    <h4>Pescado con verduras</h4>
                                    <p class="recipiente-tags">
                                    <span class="tag-plato">PRINCIPAL</span>
                                        <span class="tag pescado">Contiene Pescado</span>
                                    </p>
                                    <a href="" class="btn-view-recipiente">Ver receta</a>                                </div>
                            </div>
                            
                            <!-- Receta central destacada -->
                            <div class="recipiente-card featured-card">
                                <img src="sources/platos/postre1.png" alt="Tarta con frutos rojos">
                                <div class="recipiente-info">
                                    <h4>Tarta con frutos rojos y nueces (con edulcorante)</h4>
                                    <p class="recipiente-tags">
                                    <span class="tag-plato">POSTRE</span>
                                        <span class="tag secos">Frutos secos</span>
                                    </p>
                                    <a href="" class="btn-view-recipiente">Ver receta</a>
                                </div>
                            </div>
                            
                            <!-- Las recetas que aparecen a la derecha de la principal -->
                            <div class="recipiente-card side-card right-card">
                                <img src="sources/platos/principal1.png" alt="Albóndigas en salsa">
                                <div class="recipiente-info">
                                    <h4>Albóndigas en salsa de tomate</h4>
                                    <p class="recipiente-tags">
                                    <span class="tag-plato">PRINCIPAL</span>
                                    </p>
                                    <a href="" class="btn-view-recipiente">Ver receta</a>
                                </div>
                            </div>
                            
                            <div class="recipiente-card side-card right-card">
                                <img src="sources/platos/entrante2.png" alt="Pasta al pesto">
                                <div class="recipiente-info">
                                    <h4>Pasta con gambas y piñones</h4>
                                    <p class="recipiente-tags">
                                    <span class="tag-plato">ENTRANTE</span>
                                        <span class="tag secos">Frutos secos</span>
                                        <span class="tag marisco">Contiene Marisco</span>
                                    </p>
                                    <a href="" class="btn-view-recipiente">Ver receta</a>
                                </div>
                            </div>
                        </div>
                        
                        <button class="carrusel-nav next-btn">&gt;</button>
                    </div>
                    
                    <!-- Indicadores del carrusel -->
                    <div class="carrusel-indicators">
                        <span class="indicator active"></span>
                        <span class="indicator"></span>
                        <span class="indicator"></span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<script src="scripts/carrusel-script.js"></script>
<?php include('footer.php'); ?>