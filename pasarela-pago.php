<?php
$css_extra = '<link rel="stylesheet" href="styles/pasarela-pago.css"><link rel="stylesheet" href="styles/modal.css">';
?>


<?php include 'header.php'; ?>

<!-- migas -->

<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li class="current">nombre-landing</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="images/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>



<!-- Contenido principal-->
<section class="nombre-landing">
  <div class="contenedor-nombre-landing">

    <div class="titulo">
      <img src="images/iconos/Lock-Shield--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
      <h1>Pasarela de pago</h1>
    </div>

    <div class="contenido-nombre-landing">
     

        <form id="payment-form">
          <div class="payment-options">


            <div class="payment-method">
              <label>
                <input type="radio" name="payment_method" value="credit_card" checked>
                Tarjeta de crédito (pago seguro)
                <div class="card-icons">
                 <img src="images/iconos/Credit-Card-Visa--Streamline-Ultimate.svg" style="height: 30px;" alt="Visa">

                  <img src="images/iconos/Credit-Card-Mastercard--Streamline-Ultimate.png" style="height: 30px;"alt="MasterCard">
                  
                </div>
              </label>
             
              <div>
              <label>
                <input type="radio" name="payment_method" value="paypal">
                <img src="images/iconos/Paypal-Logo--Streamline-Ultimate.svg" alt="PayPal" style="height: 30px;">
                <a href="#" class="paypal-info">¿Qué es PayPal?</a>
              </label>
              </div>

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
            <button type="submit" class="btn">Realizar el pedido</button>
          </div>
        </form>
     
    </div>

    <!-- Importamos Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Configuración de los métodos de pago
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const creditCardDetails = document.getElementById('credit-card-details');

        paymentMethods.forEach(method => {
          method.addEventListener('change', function() {
            if (this.value === 'credit_card') {
              creditCardDetails.style.display = 'block';
            } else {
              creditCardDetails.style.display = 'none';
            }
          });
        });

        // Configuración del formulario
        const paymentForm = document.getElementById('payment-form');

        paymentForm.addEventListener('submit', function(e) {
          e.preventDefault(); // Previene que el formulario se envíe

          // Sweet Alert personalizado para confirmación de pago
          Swal.fire({
            title: '¡Pago Procesado Correctamente!',
            html: `
                        <p>Su pedido ha sido procesado y confirmado. Introduzca éste código en su área de perfil.</p>
                        <p>Código Prémium: <strong>${Math.floor(1000000 + Math.random() * 9000000)}</strong></p>
                    `,
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Volver al inicio',
            cancelButtonText: 'Cerrar',
            customClass: {
              container: 'my-swal-container',
              popup: 'my-swal-popup',
              header: 'my-swal-header',
              title: 'my-swal-title',
              content: 'my-swal-content',
              confirmButton: 'my-swal-confirm-button',
              cancelButton: 'my-swal-cancel-button'
            }
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'index.php'; // Redirigir al inicio
            }
          });
        });

        // Formateo básico de la tarjeta de crédito
        const cardNumberInput = document.getElementById('card_number');
        cardNumberInput.addEventListener('input', function(e) {
          let value = this.value.replace(/\D/g, '');
          if (value.length > 16) value = value.substr(0, 16);

          // Insertar espacios cada 4 dígitos
          let formattedValue = '';
          for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) {
              formattedValue += ' ';
            }
            formattedValue += value[i];
          }

          this.value = formattedValue;
        });

        // Formateo de la fecha de caducidad
        const expiryDateInput = document.getElementById('expiry_date');
        expiryDateInput.addEventListener('input', function(e) {
          let value = this.value.replace(/\D/g, '');
          if (value.length > 4) value = value.substr(0, 4);

          // Formatear como MM / AA
          if (value.length > 2) {
            this.value = value.substr(0, 2) + ' / ' + value.substr(2);
          } else {
            this.value = value;
          }
        });

        // Limitar CVV a 3-4 dígitos
        const cvvInput = document.getElementById('cvv');
        cvvInput.addEventListener('input', function(e) {
          let value = this.value.replace(/\D/g, '');
          if (value.length > 4) value = value.substr(0, 4);
          this.value = value;
        });
      });
    </script>

</section>

<?php include 'footer.php'; ?>
