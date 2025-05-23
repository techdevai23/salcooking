<?php include('header.php'); include 'detalle-receta.css'; ?>

<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="recetas.php">Receta</a></li>
            <li class="current">Resultados</li>
        </ul>
    </div>
</div>

<!-- Main Content -->
<section class="search-results">
    <div class="container">
        <h1>Resultados</h1>
        
        <div class="results-container">
            <!-- Sidebar con filtros -->
            <aside class="filters-sidebar">
                <h3>Filtros</h3>
                <form class="filters-form">
                    <div class="filter-group">
                        <label class="checkbox-container">
                            <input type="checkbox" name="perfil" value="1">
                            <span class="checkmark"></span>
                            Tener en cuenta mi perfil
                        </label>
                    </div>
                    
                    <div class="filter-group premium-filter">
                        <h4>Búsqueda Premium</h4>
                        <div class="premium-filter-notice">
                            <p>* Necesitas ser usuario Prémium para usar estas características</p>
                        </div>
                        
                        <div class="filter-item">
                            <h5>Enfermedades:</h5>
                            <div class="filter-options">
                                <select name="enfermedades" disabled>
                                    <option value="">Selecciona</option>
                                    <option value="diabetes">Diabetes</option>
                                    <option value="hipertension">Hipertensión</option>
                                    <option value="colesterol">Colesterol alto</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="filter-item">
                            <h5>Intolerancias:</h5>
                            <div class="filter-options">
                                <select name="intolerancias" disabled>
                                    <option value="">Selecciona</option>
                                    <option value="gluten">Gluten</option>
                                    <option value="lactosa">Lactosa</option>
                                    <option value="fructosa">Fructosa</option>
                                </select>
                            </div>
                        </div>
                        
                        <a href="contacto.php" title="Solo puedes ganar: Hazte Prémium" class="btn-premium">Hazte Prémium</a>
                    </div>
                </form>
            </aside>
            
            <!-- Grid de resultados -->
            <div class="results-grid">
                <div class="recipe-card">
                    <img src="sources/recipes/sopa-fideos.jpg" alt="Sopa de fideos con pollo">
                    <div class="recipe-info">
                        <h4>Sopa de fideos con pollo y zanahoria</h4>
                        <p class="recipe-tags">
                            <span class="tag soup">Sopa</span>
                            <span class="tag chicken">Pollo</span>
                            <span class="tag easy">Fácil</span>
                        </p>
                        <a href="receta-ejemplo.php" class="btn-view-recipe">Ver receta</a>
                    </div>
                </div>
                
                <div class="recipe-card">
                    <img src="sources/recipes/ensalada-cesar.jpg" alt="Ensalada César">
                    <div class="recipe-info">
                        <h4>Ensalada César Clásica</h4>
                        <p class="recipe-tags">
                            <span class="tag vegetarian">Vegetariano</span>
                            <span class="tag gluten">Contiene Gluten</span>
                        </p>
                        <a href="receta-detalle.php" class="btn-view-recipe">Ver receta</a>
                    </div>
                </div>
                
                <div class="recipe-card">
                    <img src="sources/recipes/pollo-asado.jpg" alt="Pollo asado con patatas">
                    <div class="recipe-info">
                        <h4>Pollo asado con patatas y romero</h4>
                        <p class="recipe-tags">
                            <span class="tag chicken">Pollo</span>
                            <span class="tag baked">Horno</span>
                        </p>
                        <a href="receta-detalle.php" class="btn-view-recipe">Ver receta</a>
                    </div>
                </div>
                
                <div class="recipe-card">
                    <img src="sources/recipes/albondigas.jpg" alt="Albóndigas en salsa">
                    <div class="recipe-info">
                        <h4>Albóndigas en salsa de tomate</h4>
                        <p class="recipe-tags">
                            <span class="tag meat">Carne</span>
                            <span class="tag sauce">Salsa</span>
                        </p>
                        <a href="receta-detalle.php" class="btn-view-recipe">Ver receta</a>
                    </div>
                </div>
                
                <div class="recipe-card">
                    <img src="sources/recipes/pasta-pesto.jpg" alt="Pasta al pesto">
                    <div class="recipe-info">
                        <h4>Pasta al pesto con piñones</h4>
                        <p class="recipe-tags">
                            <span class="tag vegetarian">Vegetariano</span>
                            <span class="tag pasta">Pasta</span>
                            <span class="tag nuts">Frutos secos</span>
                        </p>
                        <a href="receta-detalle.php" class="btn-view-recipe">Ver receta</a>
                    </div>
                </div>
                
                <div class="recipe-card">
                    <img src="sources/recipes/gazpacho.jpg" alt="Gazpacho andaluz">
                    <div class="recipe-info">
                        <h4>Gazpacho andaluz tradicional</h4>
                        <p class="recipe-tags">
                            <span class="tag vegetarian">Vegetariano</span>
                            <span class="tag vegan">Vegano</span>
                            <span class="tag cold">Frío</span>
                        </p>
                        <a href="receta-detalle.php" class="btn-view-recipe">Ver receta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>