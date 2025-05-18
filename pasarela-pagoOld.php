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
      <li class="current">nombre-landing</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>



<!-- Contenido principal-->
<section class="nombre-landing">
  <div class="contenedor-nombre-landing">

    <div class="titulo">
      <img src="sources/iconos/Lock-Shield--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
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
                <img src="sources/iconos/Credit-Card-Visa--Streamline-Ultimate.svg" style="height: 30px;" alt="Visa">

                <img src="sources/iconos/Credit-Card-Mastercard--Streamline-Ultimate.png" style="height: 30px;" alt="MasterCard">

              </div>
            </label>

            <div>
              <label>
                <input type="radio" name="payment_method" value="paypal">
                <img src="sources/iconos/Paypal-Logo--Streamline-Ultimate.svg" alt="PayPal" style="height: 30px;">
                <!-- <a href="#" class="paypal-info">¿Qué es PayPal?</a> -->
              </label>

              <div id="detalles-paypal">
                <label for="card_number">Dirección email<span class="required">*</span></label>
                <input type="text" id="email_paypal" class="form-control" required>
              </div>
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
          <button type="submit" class="btn-opciones">Realizar el pago</button>
        </div>
      </form>

    </div>

    <!-- Importamos Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
      /**** script para manejar datos correctos y modal de confirmación */

      // Esperamos a que el DOM esté completamente cargado
      // y luego ejecutamos el código
      document.addEventListener('DOMContentLoaded', function() {
        // Configuración de los métodos de pago
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const creditCardDetails = document.getElementById('credit-card-details');
        const paypalDetalles = document.getElementById('detalles-paypal');

        // Función para actualizar la visibilidad de los campos
        function actualizarCampos() {
          const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
          
          if (selectedMethod === 'credit_card') {
            creditCardDetails.style.display = 'block';
            paypalDetalles.style.display = 'none';

    //         // Limpiar los campos de PayPal cuando no están visibles
    // document.getElementById('email_paypal').value = '';
          } else {
            creditCardDetails.style.display = 'none';
            paypalDetalles.style.display = 'block';
    //          // Limpiar los campos de tarjeta de crédito cuando no están visibles
    // document.getElementById('card_number').value = '';
    // document.getElementById('expiry_date').value = '';
    // document.getElementById('cvv').value = '';
          }
        }

        // Ejecutar al cargar la página
        actualizarCampos();

        // Actualizar cuando cambie el método de pago
        paymentMethods.forEach(method => {
          method.addEventListener('change', actualizarCampos);
        });

        // Configuración del formulario
        const paymentForm = document.getElementById('payment-form');

        // Añadimos un evento al formulario para manejar el envío
        paymentForm.addEventListener('submit', function(e) {
          e.preventDefault();

          // Obtener el método de pago seleccionado
          const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

          if (selectedMethod === 'credit_card') {
            // Validar los campos de tarjeta de crédito
            const cardNumber = document.getElementById('card_number').value.trim();
            const expiryDate = document.getElementById('expiry_date').value.trim();
            const cvv = document.getElementById('cvv').value.trim();

            if (!validarNumeroTarjeta(cardNumber) || !validarFecha(expiryDate) || !validarCVV(cvv)) {
              Swal.fire({
                title: 'Error',
                text: 'Por favor, completa correctamente todos los campos de la tarjeta de crédito.',
                icon: 'error',
                confirmButtonText: 'Aceptar',
              });
              return;
            }
          } else if (selectedMethod === 'paypal') {
            // Validar el campo de PayPal
            const emailPaypal = document.getElementById('email_paypal').value.trim();

            if (!emailPaypal || !validateEmail(emailPaypal)) {
              Swal.fire({
                title: 'Error',
                text: 'Por favor, introduce una dirección de correo electrónico válida para PayPal.',
                icon: 'error',
                confirmButtonText: 'Aceptar',
              });
              return;
            }
          }

          // Si todo está validado, mostrar el modal de SweetAlert
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
              cancelButton: 'my-swal-cancel-button',
            },
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'index.php';
            }
          });
        });

        // Función para validar correos electrónicos
        function validateEmail(email) {
          const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          return re.test(email);
        }

        function validarNumeroTarjeta(cardNumber) {
          // Eliminar espacios y guiones
          cardNumber = cardNumber.replace(/[\s-]/g, '');
          // Validar que sean solo números y longitud correcta
          return /^\d{16}$/.test(cardNumber);
        }

        function validarFecha(expiryDate) {
          // Eliminar espacios
          expiryDate = expiryDate.replace(/\s/g, '');
          // Validar formato MM/YY
          if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiryDate)) {
            return false;
          }
          
          // Validar que la fecha no sea pasada
          const [month, year] = expiryDate.split('/');
          const currentDate = new Date();
          const currentYear = currentDate.getFullYear() % 100;
          const currentMonth = currentDate.getMonth() + 1;
          
          if (parseInt(year) < currentYear || 
              (parseInt(year) === currentYear && parseInt(month) < currentMonth)) {
            return false;
          }
          
          return true;
        }

        function validarCVV(cvv) {
          // Eliminar espacios
          cvv = cvv.replace(/\s/g, '');
          // Validar que sean solo números y longitud correcta (3 o 4 dígitos)
          return /^\d{3,4}$/.test(cvv);
        }

        // Añadir formateo automático para los campos
        document.getElementById('card_number').addEventListener('input', function(e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 16) value = value.substr(0, 16);
          e.target.value = value.replace(/(\d{4})/g, '$1 ').trim();
        });

        document.getElementById('expiry_date').addEventListener('input', function(e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 4) value = value.substr(0, 4);
          if (value.length > 2) {
            value = value.substr(0, 2) + '/' + value.substr(2);
          }
          e.target.value = value;
        });

        document.getElementById('cvv').addEventListener('input', function(e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 4) value = value.substr(0, 4);
          e.target.value = value;
        });

      });
    </script>


</section>

<?php include 'footer.php'; ?>