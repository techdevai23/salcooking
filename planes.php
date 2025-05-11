<?php
$css_extra = '<link rel="stylesheet" href="styles/planes.css">';
?>


<?php include 'header.php'; ?>

<!-- migas -->

<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li class="current">Planes de uso</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>



<!-- Contenido principal-->
<section class="planes-landing">
    <div class="contenedor-planes-landing">

    <div class="titulo">
      <img src="sources/iconos/Book-Star--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
      <h1>Planes de suscripción</h1>
    </div>
       
    <div class="contenido-planes-landing">
        <div class="planes-tabla-container">
            <h2>Comparativa de funcionalidades</h2>
            <div class="planes-tabla">
                <table>
                    <thead>
                        <tr>
                            <th>Funcionalidad</th>
                            <th class="columna-visitante">Visitante<span class="subtitulo">(sin registro)</span></th>
                            <th class="columna-registrado">Usuario<span class="subtitulo">(gratuito)</span></th>
                            <th class="columna-premium">Usuario<span class="subtitulo">(de pago)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1. Buscar recetas*</td>
                            <td class="check">✓</td>
                            <td class="check">✓</td>
                            <td class="check">✓</td>
                        </tr>
                        <tr>
                            <td>2. Ver trucos de cocina (blog)</td>
                            <td class="check">✓</td>
                            <td class="check">✓</td>
                            <td class="check">✓</td>
                        </tr>
                        <tr>
                            <td>3. Ver resultado de recetas con alérgenos</td>
                            <td class="check">✓</td>
                            <td class="check">✓</td>
                            <td class="check">✓</td>
                        </tr>
                        <tr>
                            <td>4. Ver resultado de recetas con enfermedades</td>
                            <td class="cross">✗</td>
                            <td class="cross">✗</td>
                            <td class="check">✓</td>
                        </tr>
                        <tr>
                            <td>5. Filtros básicos en el resultado del buscador**</td>
                            <td class="check">✓</td>
                            <td class="check">✓</td>
                            <td class="check">✓</td>
                        </tr>
                        <tr>
                            <td>6. Filtros avanzados en el resultado del buscador***</td>
                            <td class="cross">✗</td>
                            <td class="cross">✗</td>
                            <td class="check">✓</td>
                        </tr>
                        <tr>
                            <td>7. Crear perfiles</td>
                            <td class="cross">✗</td>
                            <td class="check-note">✓<span class="nota">(hasta 2)</span></td>
                            <td class="check-note">✓<span class="nota">(hasta 2)</span></td>
                        </tr>
                        <tr>
                            <td>8. Descargar recetas</td>
                            <td class="cross">✗</td>
                            <td class="check">✓</td>
                            <td class="check">✓</td>
                        </tr>
                        <tr>
                            <td>9. Crear dietas</td>
                            <td class="cross">✗</td>
                            <td class="cross">✗</td>
                            <td class="check">✓</td>
                        </tr>
                        <tr>
                            <td>10. Generar lista de la compra</td>
                            <td class="cross">✗</td>
                            <td class="cross">✗</td>
                            <td class="check">✓</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="planes-descripcion">
            <h2>Descubre nuestros planes</h2>
            <p>En nuestra plataforma ofrecemos diferentes opciones para que disfrutes de la experiencia culinaria que mejor se adapte a tus necesidades.</p>
            
            <div class="plan-card visitante">
                <h3>Visitante</h3>
                <p>Acceso básico a nuestra plataforma sin necesidad de registro. Podrás buscar recetas y conocer nuestro contenido de forma limitada.</p>
                <ul>
                    <li>Búsqueda básica de recetas</li>
                    <li>Consulta de trucos de cocina</li>
                    <li>Filtrado por alérgenos</li>
                </ul>
            </div>
            
            <div class="plan-card registrado">
                <h3>Usuario Registrado</h3>
                <p>Regístrate gratuitamente y disfruta de más funcionalidades para mejorar tu experiencia.</p>
                <ul>
                    <li>Todo lo del plan Visitante</li>
                    <li>Creación de hasta 2 perfiles</li>
                    <li>Descarga de recetas</li>
                </ul>
            </div>
            
            <div class="plan-card premium">
                <h3>Usuario Premium</h3>
                <p>Suscríbete a nuestro plan de pago y desbloquea todas las características avanzadas para sacar el máximo partido a tu cocina.</p>
                <ul>
                    <li>Todo lo del plan Registrado</li>
                    <li>Filtros avanzados de búsqueda</li>
                    <li>Recetas adaptadas a enfermedades</li>
                    <li>Creación de dietas personalizadas</li>
                    <li>Generación automática de listas de compra</li>
                </ul>
            </div>
            
            <div class="notas">
                <p>* Búsqueda básica limitada a 5 recetas diarias para visitantes.</p>
                <p>** Filtros básicos incluyen: tiempo de preparación, dificultad y tipo de plato.</p>
                <p>*** Filtros avanzados incluyen: calorías, macronutrientes y técnicas culinarias específicas.</p>
            </div>
        </div>
    </div>

    <!-- ultimo div contenedor principal -->
    </div>
</section>

<?php include 'footer.php'; ?>