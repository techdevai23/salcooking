<?php
$css_extra = '<link rel="stylesheet" href="styles/plantilla.css">';
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
 <div class="container">
        <h1>Finalizar compra</h1>
        
        <form id="payment-form">
            <div class="payment-options">
                <div class="payment-method">
                    <label>
                        <input type="radio" name="payment_method" value="credit_card" checked>
                        Tarjeta de crédito (pago seguro)
                        <div class="card-icons">
                            <img src="https://cdn.pixabay.com/photo/2015/05/26/09/37/visa-784536_960_720.png" alt="Visa">
                            <img src="https://cdn.pixabay.com/photo/2015/05/26/09/37/mastercard-784536_960_720.png" alt="MasterCard">
                            <img src="https://cdn.pixabay.com/photo/2015/05/26/09/37/american-express-784536_960_720.png" alt="American Express">
                        </div>
                    </label>
                    
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
                
                <div class="payment-method">
                    <label>
                        <input type="radio" name="payment_method" value="paypal">
                        <img src="https://cdn.pixabay.com/photo/2015/05/26/09/37/paypal-784536_960_720.png" alt="PayPal" style="height: 30px;">
                        <a href="#" class="paypal-info">¿Qué es PayPal?</a>
                    </label>
                </div>
            </div>
            
            <div class="text-right">
                <button type="submit" class="btn">Realizar el pedido</button>
            </div>
        </form>
    </div>
    
    <!-- Modal de confirmación -->
    <div class="modal" id="confirmation-modal">
        <div class="modal-content">
            <h2>¡Pago Procesado Correctamente!</h2>
            <p>Su pedido ha sido procesado y confirmado. Recibirá un correo electrónico con los detalles de su compra.</p>
            <p>Número de referencia: <strong><?php echo rand(1000000, 9999999); ?></strong></p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" id="close-modal">Cerrar</button>
                <button class="btn btn-primary" id="go-home">Volver al inicio</button>
            </div>
        </div>
    </div>
    </div>

    ¡Pago Procesado Correctamente!
Su pedido ha sido procesado y confirmado. Recibirá un correo electrónico con los detalles de su compra.

Número de referencia: 4248816
    
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
            const modal = document.getElementById('confirmation-modal');
            const closeModalBtn = document.getElementById('close-modal');
            const goHomeBtn = document.getElementById('go-home');
            
            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Previene que el formulario se envíe
                
                // Mostrar el modal
                modal.style.display = 'flex';
            });
            
            // Cerrar el modal
            closeModalBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });
            
            // Volver al inicio
            goHomeBtn.addEventListener('click', function() {
                window.location.href = 'index.php'; // Reemplazar con la URL correcta
            });
            
            // También cerrar el modal si se hace clic fuera de él
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
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