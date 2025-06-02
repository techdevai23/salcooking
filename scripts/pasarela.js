   /**** script para manejar datos correctos y modal de confirmación */

    document.addEventListener('DOMContentLoaded', function() {
    // Configuración de los métodos de pago
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const creditCardDetailsDiv = document.getElementById('credit-card-details');
    const paypalDetailsDiv = document.getElementById('detalles-paypal');

    // Campos de tarjeta de crédito
    const cardNumberInput = document.getElementById('card_number');
    const expiryDateInput = document.getElementById('expiry_date');
    const cvvInput = document.getElementById('cvv');

    // Campo de PayPal
    const emailPaypalInput = document.getElementById('email_paypal');

    // Función para actualizar la visibilidad y el atributo 'required' de los campos
    function actualizarCamposVisibilidadYRequeridos() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

        if (selectedMethod === 'credit_card') {
            creditCardDetailsDiv.style.display = 'block';
            paypalDetailsDiv.style.display = 'none';

            // Hacer requeridos los campos de tarjeta y no requeridos los de PayPal
            cardNumberInput.required = true;
            expiryDateInput.required = true;
            cvvInput.required = true;

            emailPaypalInput.required = false;
            // Opcional: Limpiar campo de PayPal si se cambia a tarjeta
            // emailPaypalInput.value = ''; 

        } else if (selectedMethod === 'paypal') {
            creditCardDetailsDiv.style.display = 'none';
            paypalDetailsDiv.style.display = 'block';

            // Hacer requerido el campo de PayPal y no requeridos los de tarjeta
            emailPaypalInput.required = true;

            cardNumberInput.required = false;
            expiryDateInput.required = false;
            cvvInput.required = false;
            // Opcional: Limpiar campos de tarjeta si se cambia a PayPal
            // cardNumberInput.value = '';
            // expiryDateInput.value = '';
            // cvvInput.value = '';
        }
    }

    // Ejecutar al cargar la página para establecer el estado inicial correcto
    actualizarCamposVisibilidadYRequeridos();

    // Actualizar cuando cambie el método de pago
    paymentMethods.forEach(method => {
        method.addEventListener('change', actualizarCamposVisibilidadYRequeridos);
    });

    // Configuración del formulario
    const paymentForm = document.getElementById('payment-form');

    // Añadimos un evento al formulario para manejar el envío
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir el envío real del formulario para validación JS

        // Obtener el método de pago seleccionado
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        let isValid = true; // Asumimos que es válido inicialmente

        if (selectedMethod === 'credit_card') {
            // Validar los campos de tarjeta de crédito
            const cardNumber = cardNumberInput.value.trim();
            const expiryDate = expiryDateInput.value.trim();
            const cvv = cvvInput.value.trim();

            if (!validarNumeroTarjeta(cardNumber) || !validarFecha(expiryDate) || !validarCVV(cvv)) {
                Swal.fire({
                    title: 'Error de Validación',
                    text: 'Por favor, completa correctamente todos los campos de la tarjeta de crédito.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                });
                isValid = false;
            }
        } else if (selectedMethod === 'paypal') {
            // Validar el campo de PayPal
            const emailPaypal = emailPaypalInput.value.trim();

            if (!emailPaypal || !validateEmail(emailPaypal)) {
                Swal.fire({
                    title: 'Error de Validación',
                    text: 'Por favor, introduce una dirección de correo electrónico válida para PayPal.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                });
                isValid = false;
            }
        }

        if (!isValid) {
            return; // Detener si hay errores de validación
        }

        // Desactiva el botón de pago (prevengo que se pueda pulsar mientras se procesa la petición) y muestra un loader mientras se procesa la petición
        const botonPago = document.querySelector('.btn-opciones');
        botonPago.disabled = true;
        const loader = document.createElement('div');
        loader.className = 'loader-pago';
        loader.innerHTML = 'Procesando pago...';
        botonPago.parentNode.insertBefore(loader, botonPago.nextSibling);

        // Se genera el código prémium aleatorio
        const codigoPremium = Math.floor(1000000 + Math.random() * 9000000).toString();
        
        // Guardar el código en la base de datos
        fetch('controllers/guardar-codigo-premium.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'codigo=' + codigoPremium
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Error del servidor: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            // Solo se muestra el modal de éxito si el código se guardó correctamente
            if (data.success) {
                Swal.fire({
                    title: '¡Pago Procesado Correctamente!',
                    html: `
                    <p>Su pedido ha sido procesado y confirmado. Se envió un correo electrónico con el código Prémium.</p>
                    <p>Introduzca éste código en su área de perfil para activar su cuenta Prémium.</p>
                    <p>Código Prémium: <strong>${codigoPremium}</strong></p>
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
            } else {
                // Si hay error, se muestra el mensaje de error devuelto por el backend
                Swal.fire({
                    title: 'Error',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
        .catch(error => {
            // Se muestra un mensaje de error detallado en caso de fallo en la petición
            console.error('Error completo:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un error al procesar el pago: ' + error.message,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        })
        .finally(() => {
            // Se reactiva el botón de pago y se elimina el loader tras finalizar la petición
            botonPago.disabled = false;
            if (loader && loader.parentNode) loader.parentNode.removeChild(loader);
        });
    });

    // --- TUS FUNCIONES DE VALIDACIÓN (sin cambios) ---
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validarNumeroTarjeta(cardNumber) {
        cardNumber = cardNumber.replace(/[\s-]/g, '');
        return /^\d{16}$/.test(cardNumber);
    }

    function validarFecha(expiryDate) {
        expiryDate = expiryDate.replace(/\s/g, '');
        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiryDate)) {
            return false;
        }
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
        cvv = cvv.replace(/\s/g, '');
        return /^\d{3,4}$/.test(cvv);
    }

    // --- TUS FORMATEADORES DE INPUT (sin cambios) ---
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 16) value = value.substr(0, 16);
        // Corregido para evitar espacios extra al principio o final si se borra todo
        e.target.value = value.replace(/(\d{4})(?=\d)/g, '$1 ').trim(); 
    });

    document.getElementById('expiry_date').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.substr(0, 4);
        if (value.length >= 2) { // Cambiado a >= 2 para que ponga el / antes si se pega M M Y Y
            value = value.substr(0, 2) + '/' + value.substr(2);
        }
        e.target.value = value.substring(0,5); // Asegurar que no exceda MM/YY
    });

    document.getElementById('cvv').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.substr(0, 4);
        e.target.value = value;
    });
});