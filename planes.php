<?php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/planes.css?v=' . filemtime('styles/planes.css') . '">';
?>

<?php include 'header.php'; ?>


<!-- migas -->

<div class="migas-container">
    <div class="container migas-flex">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Planes de suscripción</li>
           
        </ul>
        <div class="volver-atras-contenedor">
            <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Atrás. Pantalla anterior"></a>
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

        <div class="intro">
            <div class="planes-descripcion">
                <h2>¿Qué es SalCooking?</h2>
                <p>SalCooking es mucho más que una web de recetas. Es tu aliada diaria para planificar comidas saludables, adaptadas a tus gustos, necesidades y estilo de vida.</p>
                <p>Desde el primer día puedes buscar recetas, descubrir trucos útiles de cocina y consultar ingredientes con alérgenos.</p>
                <p>Y si decides registrarte o suscribirte, desbloquearás aún más opciones para organizar tu alimentación de forma inteligente y sin complicaciones.</p>
                <h2>¡Lleva tu cocina al siguiente nivel con SalCooking Premium!</h2>
                <p>¿Te imaginas tener a tu disposición menús totalmente personalizados, sin anuncios y con acceso a recetas adaptadas a tus necesidades de salud?</p>
                <p>Con SalCooking Prémium, no solo planificas tus comidas de forma inteligente, sino que transformas tu alimentación en un verdadero estilo de vida saludable.</p>
                <p>Solicita acceso Prémium y disfruta del arte de cocinar con conocimiento.</p>
                <p>🗓️ Planifica. 🥗 Cocina. ❤️ Cuida tu salud.</p>
            </div>


        </div>

        <div class="contenido-planes-landing">
            <div class="planes-tabla-container">
                <h2>Comparativa completa</h2>
                <div class="planes-tabla">
                    <table>
                        <thead>
                            <tr>
                                <th>Funcionalidad</th>
                                <th class="columna-visitante">Visitante<span class="subtitulo">(sin registro)</span></th>
                                <th class="columna-registrado">Usuario<span class="subtitulo">(registrado)</span></th>
                                <th class="columna-premium">Usuario<span class="subtitulo">(Prémium)</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1. Atención al cliente </td>
                                <td class="check">✓</td>
                                <td class="check">✓</td>
                                <td class="check">✓</td>
                            </tr>
                            <tr>
                                <td>2. Buscar recetas* </td>
                                <td class="check">✓</td>
                                <td class="check">✓</td>
                                <td class="check">✓</td>
                            </tr>
                            <tr>
                                <td>3. Ver recetas con alérgenos</td>
                                <td class="check">✓</td>
                                <td class="check">✓</td>
                                <td class="check">✓</td>
                            </tr>
                            <tr>
                                <td>4. Filtros básicos en el resultado del buscador**</td>
                                <td class="check">✓</td>
                                <td class="check">✓</td>
                                <td class="check">✓</td>
                            </tr>
                              <tr>
                                <td>5. Ver trucos de cocina (blog)</td>
                                <td class="cross">·</td>
                                <td class="check-note">✓<span class="nota"></span></td>
                                <td class="check-note">✓<span class="nota"></span></td>
                            </tr>
                            <tr>
                                <td>6. Descargar recetas</td>
                                <td class="cross">·</td>
                                <td class="check">✓</td>
                                <td class="check">✓</td>
                            </tr>
                            <tr>

                                <td>7. Ver resultado de recetas con enfermedades</td>
                                <td class="cross">·</td>
                                <td class="cross">·</td>
                                <td class="check">✓</td>
                            </tr>
                            <tr>
                                <td>8. Filtros avanzados en el resultado del buscador***</td>
                                <td class="cross">·</td>
                                <td class="cross">·</td>
                                <td class="check">✓</td>
                            </tr>
                          
                            <tr>
                                <td>9. Crear dietas</td>
                                <td class="cross">·</td>
                                <td class="cross">·</td>
                                <td class="check">✓</td>
                            </tr>
                            <tr>
                                <td>10. Generar lista de la compra</td>
                                <td class="cross">·</td>
                                <td class="cross">·</td>
                                <td class="check">✓</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="notas">
                    <p>* En la caja de búsqueda, se puede buscar con una o varias palabras, y el sistema buscará por defecto en el campo titulo, o el de ingredientes de la BBDD. Una vez arroje los resultados, aparecerán los filtros.</p>
                    <p>** Los filtros incluirán distintos ordenamientos y poder aplicar desplegables por categoría de platos y alérgenos.</p>
                    <p>*** Con los filtros avanzados podrás filtrar los resultados por enfermedades, filtrar por ingredientes o tiempo de preparación.</p>
                </div>
            </div>

            <div class="planes-descripcion">
                <h3>Formas de acceso a SalCooking</h3>
                <p>En SalCooking puedes elegir cómo quieres disfrutar la plataforma según lo que necesites. Tanto si solo quieres explorar sin registrarte como si buscas
                    personalización total, hay una opción pensada para ti. A continuación, te mostramos qué incluye cada nivel de acceso y qué funciones puedes aprovechar en cada caso.
                </p>


                <div class="plan-card visitante">
                    <h3>Visitante</h3>
                    <p>Acceso básico a nuestra plataforma <b>sin necesidad de registro</b>. Podrás buscar recetas y conocer nuestro contenido de forma limitada. Destacamos:</p>
                    <ul>
                        
                        <li>Atención al cliente completa</li>
                        <li>Búsqueda básica de recetas por título</li>
                        <li>Vista de fichas de recetas incluyendo alérgenos</li>
                        <li>Filtrado de resultados por alérgenos</li>
                        <li>Otros filtros básicos y de ordenamiento</li>
                    </ul>
                </div>

                <div class="plan-card registrado">
                    <h3 style="color: var(--primary-dark);">Usuario Registrado</h3>
                    <p>Regístrate <b>de forma gratuita</b> y disfruta de más funcionalidades para mejorar tu experiencia. Destacamos:</p>
                    <ul>
                        <li>Todo lo que incluye el plan Visitante</li>
                        <li>Acceso libre al blog de trucos de cocina</li>
                        <li>Descarga de las fichas de recetas</li>
                    </ul>
                </div>

                <div class="plan-card premium">
                    <h3 style="color: #a46302;">Usuario Prémium</h3>
                    <p>Suscríbete a nuestro plan de pago y <b>desbloquea todas</b> las características avanzadas para sacar el máximo partido a tu cocina, y a tu estado de salud:</p>
                    <ul>
                        <li>Todo lo del plan Registrado</li>
                        <li>Filtros avanzados de búsqueda</li>
                        <li>Recetas adaptadas a enfermedades</li>
                        <li>Creación de dietas personalizadas</li>
                        <li>Generación automática de listas de compra</li>
                    </ul>
                </div>


            </div>
        </div>

        <!-- ultimo div contenedor principal -->
    </div>
</section>

<?php include 'footer.php'; ?>