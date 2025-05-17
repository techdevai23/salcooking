<?php
$css_extra .= '<link rel="stylesheet" href="styles/sitemap.css?v=' . filemtime('styles/sitemap.css') . '">';
?>

<?php include 'header.php'; ?>
<!-- migas -->
<div class="migas-container">
    <div class="container">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Mapa del sitio (Sitemap)</li>
        </ul>
    </div>
</div>
<!-- Contenido principal-->
<section class="sitemap-landing">
    <div class="contenedor-sitemap-landing">

      <div class="titulo">
        <img src="sources/iconos/Book-Star--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
        <h1>Mapa del Sitio (Sitemap)</h1>
      </div>
       
      <div class="contenido-sitemap-landing">
        <div class="sitemap-descripcion">
          <p>Explora todas las secciones de nuestra web para aprovechar al máximo nuestros servicios culinarios. Navega por nuestro mapa interactivo para descubrir cada función disponible.</p>
        </div>

        <div class="sitemap-visual">
          <div class="sitemap-container">
            <!-- Inicio -->
            <div class="sitemap-node sitemap-home" id="inicio">
              <div class="node-content">
                <h3>Inicio</h3>
                <a href="index.php" class="sitemap-link">Página principal</a>
              </div>
              <div class="node-connections">
                <div class="connection" data-target="recetas"></div>
                <div class="connection" data-target="premium"></div>
                <div class="connection" data-target="info"></div>
                <div class="connection" data-target="cuenta"></div>
              </div>
            </div>

            <!-- Recetas -->
            <div class="sitemap-node sitemap-section" id="recetas">
              <div class="node-content">
                <h3>Recetas</h3>
                <ul class="sitemap-links">
                  <li><a href="recetas-categoria.php">Categorías</a></li>
                  <li><a href="resultado-recetas.php">Búsqueda de recetas</a></li>
                  <li><a href="detalle-receta.php?id=23">La receta del día</a></li>
                  <li><a href="detalle-receta.php?id=23">Trucos de cocina</a></li>
                </ul>
              </div>
              <div class="node-connections">
                <div class="connection" data-target="perfiles"></div>
              </div>
            </div>

            <!-- Premium -->
            <div class="sitemap-node sitemap-section premium-section" id="premium">
              <div class="node-content">
                <h3>Zona Prémium</h3>
                <div class="premium-badge">
                  <span class="premium-icon">★</span>
                  <span>Contenido exclusivo</span>
                </div>
              </div>
              <div class="node-connections">
                <div class="connection" data-target="perfiles"></div>
                <div class="connection" data-target="dietas"></div>
              </div>
            </div>

            <!-- Perfiles -->
            <div class="sitemap-node sitemap-subsection" id="perfiles">
              <div class="node-content">
                <h3>Perfiles</h3>
                <div class="perfiles-selector">
                  <label class="perfil-option">
                    <input type="radio" name="perfil-sitemap" value="principal" checked>
                    <span class="checkmark"></span>
                    Perfil principal
                  </label>
                  <label class="perfil-option">
                    <input type="radio" name="perfil-sitemap" value="secundario">
                    <span class="checkmark"></span>
                    Perfil secundario
                  </label>
                </div>
              </div>
            </div>

            <!-- Dietas -->
            <div class="sitemap-node sitemap-subsection" id="dietas">
              <div class="node-content">
                <h3>Dietas</h3>
                <ul class="sitemap-links">
                  <li><a href="dieta-semana-por-dias.php">Dieta semanal</a></li>
                  <li><a href="dieta-dia.php">Dieta del día</a></li>
                  <li><a href="lista-semana.php">Lista de la compra semanal</a></li>
                  <li><a href="lista-dia.php">Lista de la compra del día</a></li>
                </ul>
              </div>
            </div>

            <!-- Información -->
            <div class="sitemap-node sitemap-section" id="info">
              <div class="node-content">
                <h3>Información</h3>
                <ul class="sitemap-links">
                  <li><a href="filosofia.php">Nuestra filosofía</a></li>
                  <li><a href="contacto.php">Contáctanos</a></li>
                  <li><a href="ayuda.php">Ayuda</a></li>
                  <li><a href="planes.php">Planes</a></li>
                </ul>
              </div>
            </div>

            <!-- Cuenta -->
            <div class="sitemap-node sitemap-section" id="cuenta">
              <div class="node-content">
                <h3>Gestión de Cuenta</h3>
                <ul class="sitemap-links">
                  <li><a href="login.php">Login</a></li>
                  <li><a href="perfil.php">Perfil-Ajustes</a></li>
                  <li><a href="cambio-pass.php">Cambio de contraseña</a></li>
                  <li><a href="accion-completada.php">Cerrar sesión</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="sitemap-leyenda">
          <h3>Leyenda</h3>
          <ul>
            <li><span class="leyenda-icon leyenda-home">★</span> Página principal</li>
            <li><span class="leyenda-icon leyenda-section">●</span> Secciones principales</li>
            <li><span class="leyenda-icon leyenda-subsection">◆</span> Subsecciones</li>
            <li><span class="leyenda-icon leyenda-premium">★</span> Contenido Premium</li>
          </ul>
        </div>

        <!-- Mapa alternativo lineal para móviles -->
        <!-- <div class="sitemap-mobile">
          <h3>Mapa del sitio lineal</h3>
          
          <div class="mobile-section">
            <h4>Página Principal</h4>
            <ul>
              <li><a href="index.php">Inicio</a></li>
            </ul>
          </div>

          <div class="mobile-section">
            <h4>Recetas</h4>
            <ul>
              <li><a href="recetas-categoria.php">Categorías</a></li>
              <li><a href="resultado-recetas.php">Búsqueda de recetas</a></li>
              <li><a href="detalle-receta.php?id=23">La receta del día</a></li>
              <li><a href="detalle-receta.php?id=23">Trucos de cocina</a></li>
            </ul>
          </div>

          <div class="mobile-section premium-mobile">
            <h4>Zona Prémium <span class="premium-badge-small">★</span></h4>
            <p>Contenido exclusivo para usuarios premium</p>
          </div> -->

          div class="sitemap-mobile">
    <h3>Mapa del sitio lineal</h3>
    
    <div class="mobile-section home-mobile">
        <h4>Página Principal</h4>
        <ul>
            <li><a href="index.php">Inicio</a></li>
        </ul>
    </div>

    <div class="mobile-section section-mobile">
        <h4>Recetas</h4>
        <ul>
            <li><a href="recetas-categoria.php">Categorías</a></li>
            <li><a href="resultado-recetas.php">Búsqueda de recetas</a></li>
            <li><a href="detalle-receta.php?id=23">La receta del día</a></li>
            <li><a href="detalle-receta.php?id=23">Trucos de cocina</a></li>
        </ul>
    </div>

    <div class="mobile-section premium-mobile">
        <h4>Zona Prémium <span class="premium-badge-small">★</span></h4>
        <p>Contenido exclusivo para usuarios premium</p>
    </div>

          <div class="mobile-section subsection-mobile">
            <h4>Perfiles</h4>
            <ul>
              <li>Perfil principal</li>
              <li>Perfil secundario</li>
            </ul>
          </div>

          <div class="mobile-section subsection-mobile">
            <h4>Dietas</h4>
            <ul>
              <li><a href="dieta-semana-por-dias.php">Dieta semanal</a></li>
              <li><a href="dieta-dia.php">Dieta del día</a></li>
              <li><a href="lista-semana.php">Lista de la compra semanal</a></li>
              <li><a href="lista-dia.php">Lista de la compra del día</a></li>
            </ul>
          </div>

          <div class="mobile-section">
            <h4>Información</h4>
            <ul>
              <li><a href="filosofia.php">Nuestra filosofía</a></li>
              <li><a href="contacto.php">Contáctanos</a></li>
              <li><a href="ayuda.php">Ayuda</a></li>
              <li><a href="planes.php">Planes</a></li>
            </ul>
          </div>

          <div class="mobile-section">
            <h4>Gestión de Cuenta</h4>
            <ul>
              <li><a href="login.php">Login</a></li>
              <li><a href="perfil.php">Perfil-Ajustes</a></li>
              <li><a href="cambio-pass.php">Cambio de contraseña</a></li>
              <li><a href="accion-completada.php">Cerrar sesión</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Dibuja las conexiones entre nodos
  const connections = document.querySelectorAll('.connection');
  
  connections.forEach(connection => {
    const target = connection.getAttribute('data-target');
    const targetNode = document.getElementById(target);
    
    if (targetNode) {
      // Aquí se podría añadir código para dibujar líneas entre nodos
      // Pero como es más complejo, usamos CSS para simular las conexiones
      connection.classList.add('connected-to-' + target);
    }
  });
  
  // Añade interactividad a los nodos
  const nodes = document.querySelectorAll('.sitemap-node');
  
  nodes.forEach(node => {
    node.addEventListener('mouseenter', function() {
      this.classList.add('highlighted');
    });
    
    node.addEventListener('mouseleave', function() {
      this.classList.remove('highlighted');
    });
    
    node.addEventListener('click', function() {
      // Toggle expanded class
      this.classList.toggle('expanded');
    });
  });
});
</script>