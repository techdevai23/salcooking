document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('nueva_contrasena') || document.getElementById('nueva-contrasena');
    const confirmPasswordInput = document.getElementById('confirmar_contrasena') || document.getElementById('confirmar-contrasena');
    
    // Elementos para la versión completa (cambio-pass.php)
    const requirements = {
        length: document.querySelector('.requirement-met:nth-child(1)'),
        uppercase: document.querySelector('.requirement-met:nth-child(2)'),
        number: document.querySelector('.requirement-met:nth-child(3)'),
        special: document.querySelector('.requirement-met:nth-child(4)')
    };

    // Función común para validar la contraseña
    function validatePassword(password) {
        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        return {
            isValid: hasLength && hasUppercase && hasNumber && hasSpecial,
            requirements: {
                length: hasLength,
                uppercase: hasUppercase,
                number: hasNumber,
                special: hasSpecial
            }
        };
    }

    // Función común para validar que las contraseñas coinciden
    function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        return password === confirmPassword;
    }

    /******************** Código específico para cambio-pass.php ********************/
    // Actualizar visualmente los requisitos en la página
    function updateRequirementsDisplay(requirements) {
        if (requirements.length) {
            requirements.length.classList.toggle('requirement-met', requirements.length);
            requirements.uppercase.classList.toggle('requirement-met', requirements.uppercase);
            requirements.number.classList.toggle('requirement-met', requirements.number);
            requirements.special.classList.toggle('requirement-met', requirements.special);
        }
    }

    // Evento para validar la contraseña mientras se escribe (versión completa)
    if (requirements.length && passwordInput) {
        passwordInput.addEventListener('input', function() {
            const validation = validatePassword(this.value);
            updateRequirementsDisplay(validation.requirements);
        });
    }
    /*****************************************************************************/

    /******************** Código específico para perfil-logueado.php ********************/
    // Función para mostrar los requisitos en un alert
    function showRequirementsAlert(requirements) {
        const missingRequirements = [];
        if (!requirements.length) missingRequirements.push('• Al menos 8 caracteres');
        if (!requirements.uppercase) missingRequirements.push('• Al menos una letra mayúscula');
        if (!requirements.number) missingRequirements.push('• Al menos un número');
        if (!requirements.special) missingRequirements.push('• Al menos un carácter especial');

        Swal.fire({
            title: 'Requisitos de Contraseña',
            html: `
                <div style="text-align: left;">
                    <p>La contraseña debe cumplir los siguientes requisitos:</p>
                    <ul style="list-style: none; padding-left: 0;">
                        ${missingRequirements.map(req => `<li>${req}</li>`).join('')}
                    </ul>
                </div>
            `,
            icon: 'info',
            confirmButtonText: 'Entendido',
            customClass: {
                container: 'my-swal-container',
                popup: 'my-swal-popup',
                header: 'my-swal-header',
                title: 'my-swal-title',
                content: 'my-swal-content',
                confirmButton: 'my-swal-confirm-button'
            }
        });
    }

    // Evento para validar la contraseña mientras se escribe (versión simplificada)
    if (!requirements.length && passwordInput) {
        passwordInput.addEventListener('input', function() {
            if (this.value) {
                const validation = validatePassword(this.value);
                if (!validation.isValid) {
                    showRequirementsAlert(validation.requirements);
                }
            }
        });
    }
    /*********************************************************************************/

    // Código común para ambas versiones
    // Evento para validar que las contraseñas coinciden
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            if (this.value && !validatePasswordMatch()) {
                Swal.fire({
                    title: 'Error de Validación',
                    text: 'Las contraseñas no coinciden.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        container: 'my-swal-container',
                        popup: 'my-swal-popup',
                        header: 'my-swal-header',
                        title: 'my-swal-title',
                        content: 'my-swal-content',
                        confirmButton: 'my-swal-confirm-button'
                    }
                });
            }
        });
    }

    // Función para mostrar/ocultar contraseña
    const showPasswordLink = document.querySelector('.show-password');
    if (showPasswordLink) {
        showPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            confirmPasswordInput.type = type;
            this.textContent = type === 'password' ? 'Muestrame la contraseña' : 'Ocultar contraseña';
        });
    }

    // Validación del formulario
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (passwordInput.value || confirmPasswordInput.value) {
                e.preventDefault();
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                const validation = validatePassword(password);
                if (!validation.isValid) {
                    if (requirements.length) {
                        updateRequirementsDisplay(validation.requirements);
                    } else {
                        showRequirementsAlert(validation.requirements);
                    }
                    return;
                }

                if (!validatePasswordMatch()) {
                    Swal.fire({
                        title: 'Error de Validación',
                        text: 'Las contraseñas no coinciden.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            container: 'my-swal-container',
                            popup: 'my-swal-popup',
                            header: 'my-swal-header',
                            title: 'my-swal-title',
                            content: 'my-swal-content',
                            confirmButton: 'my-swal-confirm-button'
                        }
                    });
                    return;
                }

                // Si todo está correcto, enviar el formulario
                this.submit();
            }
        });
    }
}); 