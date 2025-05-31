document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const passwordInput = document.getElementById('nueva-contrasena') || document.getElementById('nueva_contrasena');
    const confirmPasswordInput = document.getElementById('confirmar-contrasena') || document.getElementById('confirmar_contrasena');
    const showPasswordLink = document.querySelector('.show-password');
    const requirementsList = document.querySelector('.requirements-list');
    const form = document.querySelector('form');

    // Función para validar la contraseña
    function validatePassword(password) {
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        return {
            isValid: Object.values(requirements).every(req => req),
            requirements
        };
    }

    // Función para mostrar alerta con requisitos faltantes
    function showRequirementsAlert(requirements) {
        const missingRequirements = [];
        if (!requirements.length) missingRequirements.push('Ser de al menos 8 carácteres');
        if (!requirements.uppercase) missingRequirements.push('Tener al menos 1 letra mayúscula');
        if (!requirements.number) missingRequirements.push('Tener al menos 1 número');
        if (!requirements.special) missingRequirements.push('Tener al menos un caracter especial');

        Swal.fire({
            title: 'Requisitos de contraseña',
            html: `La contraseña debe cumplir los siguientes requisitos:<br><br>
                  ${missingRequirements.join('<br>')}`,
            icon: 'warning',
            confirmButtonText: 'Entendido',
            customClass: {
                container: 'my-swal-container',
                popup: 'my-swal-popup',
                title: 'my-swal-title',
                confirmButton: 'my-swal-confirm-button'
            }
        });
    }

    // Función para validar contraseñas coincidentes
    function validateMatchingPasswords() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            Swal.fire({
                title: 'Error',
                text: 'Las contraseñas no coinciden',
                icon: 'error',
                confirmButtonText: 'Entendido',
                customClass: {
                    container: 'my-swal-container',
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    confirmButton: 'my-swal-confirm-button'
                }
            });
            return false;
        }
        return true;
    }

    // Función para mostrar/ocultar contraseña
    function togglePasswordVisibility() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        if (confirmPasswordInput) {
            confirmPasswordInput.type = type;
        }
        showPasswordLink.textContent = type === 'password' ? 'Muestrame la contraseña' : 'Ocultar contraseña';
    }

    // Event listeners
    if (showPasswordLink) {
        showPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            togglePasswordVisibility();
        });
    }

    // Validación al perder el foco del campo de contraseña
    if (passwordInput) {
        passwordInput.addEventListener('blur', function() {
            if (this.value) {
                const { isValid, requirements } = validatePassword(this.value);
                if (!isValid) {
                    showRequirementsAlert(requirements);
                }
            }
        });
    }

    // Validación al perder el foco del campo de confirmación
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('blur', function() {
            if (this.value && passwordInput.value !== this.value) {
                Swal.fire({
                    title: 'Error',
                    text: 'Las contraseñas no coinciden',
                    icon: 'error',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        container: 'my-swal-container',
                        popup: 'my-swal-popup',
                        title: 'my-swal-title',
                        confirmButton: 'my-swal-confirm-button'
                    }
                });
            }
        });
    }

    // Validación al enviar el formulario
    if (form) {
        form.addEventListener('submit', function(e) {
            if (passwordInput && passwordInput.value) {
                const { isValid, requirements } = validatePassword(passwordInput.value);
                if (!isValid) {
                    e.preventDefault();
                    showRequirementsAlert(requirements);
                    return;
                }
            }

            if (confirmPasswordInput && !validateMatchingPasswords()) {
                e.preventDefault();
            }
        });
    }
}); 