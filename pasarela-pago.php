<?php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/pasarela-pago.css?v=' . filemtime('styles/pasarela-pago.css') . '">
<link rel="stylesheet" href="styles/modal.css?v=' . filemtime('styles/modal.css') . '">
';
?>

<?php include 'header.php'; ?>


<!-- migas -->

<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="contacto.php">Contáctanos</a></li>
      <li class="current">Pasarela de pago</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
    </div>
  </div>
</div>



<!-- Contenido principal-->
<section class="pasarela-pago">
  <div class="contenedor-pasarela-pago">

    <div class="titulo">
      <img src="sources/iconos/Lock-Shield--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
      <h1>Pasarela de pago</h1>
    </div>

    <div class="contenido-pasarela-pago">


      <form id="payment-form">
        <div class="payment-options">

<!-- LOGOS DE PAGOS -->
          <div class="payment-method">
            <label>
              <input type="radio" name="payment_method" value="credit_card" checked>
              Tarjeta de crédito (pago seguro)
              <div class="card-icons">
                <img src="sources/iconos/Credit-Card-Visa--Streamline-Ultimate.svg" style="height: 30px;" alt="Visa">

                <img src="sources/iconos/Credit-Card-Mastercard--Streamline-Ultimate.png" style="height: 30px;" alt="MasterCard">

              </div>
            </label>

            <!-- PAYPAL -->
            <div>
              <label>
                <input type="radio" name="payment_method" value="paypal">
                <img src="sources/iconos/Paypal-Logo--Streamline-Ultimate.svg" alt="PayPal" style="height: 30px;">
                <!-- <a href="#" class="paypal-info">¿Qué es PayPal?</a> -->
              </label>

              <div id="detalles-paypal">
                <label for="card_number">Dirección email de su cuenta PayPal <span class="required">*</span></label>
                <input type="text" id="email_paypal" class="form-control" required>
              </div>
            </div>

            <!-- TARJETA DE CRÉDITO -->
            <div class="payment-details" id="credit-card-details">
              <p>Pago seguro mediante tarjetas de crédito</p>

              <div class="form-group">
                <label for="card_number">Número de tarjeta <span class="required">*</span></label>
                <input type="text" id="card_number" class="form-control" placeholder="•••• •••• •••• ••••" required>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="expiry_date">Caducidad (MM/AA) <span class="required">*</span></label>
                  <input type="text" id="expiry_date" class="form-control" placeholder="MM / AA" required>
                </div>

                <div class="form-group">
                  <label for="cvv">Código de tarjeta <span class="required">*</span></label>
                  <input type="text" id="cvv" class="form-control" placeholder="CVV" required>
                </div>
              </div>
            </div>
          </div>


        </div>

        <div class="text-right">
          <button type="submit" class="btn-opciones">Realizar el pago</button>
          <!-- procesamos en el JS de pasarela -->
        </div>
      </form>

    </div>

    <!-- Importamos Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- importamos gestión de la pasarela de pago -->
    <script src="scripts/pasarela.js"></script>


</section>

<?php include 'footer.php'; ?>