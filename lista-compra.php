<?php
// Usamos el CSS de lista-semana como ejemplo, ya que el estilo de la lista es el mismo
$css_extra = '<link rel="stylesheet" href="styles/lista-semana.css">';
include 'header.php';

// Datos inventados
$ingredientes_compra_falsos = [
    ['nombre_ingrediente' => 'Tomates Frescos', 'cantidad_total' => 5, 'abreviatura_unidad' => 'unid.'],
    ['nombre_ingrediente' => 'Cebolla Morada', 'cantidad_total' => 2, 'abreviatura_unidad' => 'unid.'],
    ['nombre_ingrediente' => 'Pechuga de Pollo', 'cantidad_total' => 500, 'abreviatura_unidad' => 'g'],
    ['nombre_ingrediente' => 'Arroz Basmati', 'cantidad_total' => 250, 'abreviatura_unidad' => 'g'],
    ['nombre_ingrediente' => 'Aceite de Oliva Virgen Extra', 'cantidad_total' => 100, 'abreviatura_unidad' => 'ml'],
    ['nombre_ingrediente' => 'Sal Marina', 'cantidad_total' => 1, 'abreviatura_unidad' => 'c.p.'],
    ['nombre_ingrediente' => 'Pimienta Negra Molida', 'cantidad_total' => 1, 'abreviatura_unidad' => 'c.p.'],
    ['nombre_ingrediente' => 'Limones', 'cantidad_total' => 3, 'abreviatura_unidad' => 'unid.'],
    ['nombre_ingrediente' => 'Ajo', 'cantidad_total' => 4, 'abreviatura_unidad' => 'dientes'],
    ['nombre_ingrediente' => 'Pan Integral', 'cantidad_total' => 1, 'abreviatura_unidad' => 'barra'],
    ['nombre_ingrediente' => 'Lechuga Romana', 'cantidad_total' => 1, 'abreviatura_unidad' => 'unid.'],
    ['nombre_ingrediente' => 'Zanahorias', 'cantidad_total' => 300, 'abreviatura_unidad' => 'g'],
];
?>

<!-- LISTA DE LA COMPRA ESTÁTICA (EJEMPLO) -->

<!-- migas (ejemplo) -->
<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="#">Demo</a></li>
      <li class="current">Lista de la Compra (Estática)</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>

<!-- Contenido principal (usando clases de lista-semana para el layout) -->
<section class="lista-semana"> <!-- Usamos clase lista-semana para el layout base -->
    <div class="contenedor-lista-semana"> <!-- Usamos clase lista-semana para el layout base -->

        <div class="titulo">
            <img src="sources/iconos/Shopping-Basket-3--Streamline-Ultimate.svg" width="48px" alt="Carrito de la compra">
            <h1>Lista de la compra (Ejemplo Estático)</h1>
        </div>
       
        <div class="contenido-lista-semana"> <!-- Usamos clase lista-semana para el layout base -->
          
            <?php if (!empty($ingredientes_compra_falsos)): ?>
                <div class="lista-ingredientes-compra" id="lista-para-descargar">
                    <?php foreach ($ingredientes_compra_falsos as $ingrediente): ?>
                        <div class="ingrediente-item">
                            <span class="ingrediente-nombre"><?php echo htmlspecialchars($ingrediente['nombre_ingrediente']); ?></span>
                            <span class="ingrediente-cantidad">
                                <?php echo htmlspecialchars($ingrediente['cantidad_total']); ?>
                                <?php echo htmlspecialchars($ingrediente['abreviatura_unidad']); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mensaje-lista-vacia">No hay ingredientes inventados para mostrar.</p>
            <?php endif; ?>

            <div class="acciones-lista">
            <button class="descargar-lista-btn" onclick="descargarListaPDF('lista-compra.pdf', 'Lista de la Compra')">
                    <img src="sources/iconos/Arrow-Double-Down-1--Streamline-Ultimate.svg" alt="Descargar">
                    Descargar lista ingredientes
                </button>
            </div>
            
            <p class="mensaje-apoyo-premium">
                ¡Gracias por seguir apoyándonos siendo un usuario <strong>Prémium</strong>!
            </p>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

            <!-- Arrow-Double-Down-1--Streamline-Ultimate.svg
             Download-Bottom--Streamline-Ultimate.svg-->