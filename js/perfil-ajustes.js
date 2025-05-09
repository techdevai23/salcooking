// js/perfil-ajustes.js
document.addEventListener('DOMContentLoaded', function() {
  const perfilForm = document.getElementById('perfilForm');
  const cambiarContrasenaLink = document.getElementById('cambiarContrasenaLink');
  const cambiarContrasenaCampos = document.getElementById('cambiarContrasenaCampos');
  const contrasenaActualInput = document.getElementById('contrasena_actual'); // Asumiendo que existe si se actualiza
  const nuevaContrasenaInput = document.getElementById('nueva_contrasena');
  const confirmarContrasenaInput = document.getElementById('confirmar_contrasena');

  // Lógica para mostrar/ocultar campos de cambio de contraseña
  if (cambiarContrasenaLink && cambiarContrasenaCampos) {
      cambiarContrasenaLink.addEventListener('click', function(e) {
          e.preventDefault();
          cambiarContrasenaCampos.classList.toggle('visible');
          // Si se muestran, los campos de nueva contraseña podrían volverse requeridos
          if (cambiarContrasenaCampos.classList.contains('visible')) {
              if (nuevaContrasenaInput) nuevaContrasenaInput.required = true;
              if (confirmarContrasenaInput) confirmarContrasenaInput.required = true;
              // Si el usuario está logueado y cambia contraseña, la actual es requerida
              const esUsuarioLogueado = !document.body.classList.contains('nuevo-usuario'); // Necesitas añadir esta clase al body en PHP
              if (esUsuarioLogueado && contrasenaActualInput) {
                  contrasenaActualInput.required = true;
              }
          } else {
              if (nuevaContrasenaInput) nuevaContrasenaInput.required = false;
              if (confirmarContrasenaInput) confirmarContrasenaInput.required = false;
              if (contrasenaActualInput) contrasenaActualInput.required = false;
          }
      });
  }

  // Validación del formulario (ejemplo básico)
  if (perfilForm) {
      perfilForm.addEventListener('submit', function(event) {
          let valido = true;
          // Limpiar mensajes de error previos
          document.querySelectorAll('.error-message').forEach(el => el.remove());

          // Validar Nick (ej: no vacío)
          const nickInput = document.getElementById('nick');
          if (nickInput && nickInput.value.trim() === '') {
              mostrarError(nickInput, 'El Nick es obligatorio.');
              valido = false;
          }

          // Validar Email
          const emailInput = document.getElementById('email');
          if (emailInput && !validarEmail(emailInput.value)) {
              mostrarError(emailInput, 'Introduce un email válido.');
              valido = false;
          }
          
          // Validar contraseña si los campos están visibles y es un nuevo usuario o se está cambiando
          const esNuevoUsuario = document.body.classList.contains('nuevo-usuario');
          if (esNuevoUsuario && nuevaContrasenaInput && nuevaContrasenaInput.value.trim() === '') {
               mostrarError(nuevaContrasenaInput, 'La contraseña es obligatoria para nuevos usuarios.');
               valido = false;
          }


          if (cambiarContrasenaCampos && cambiarContrasenaCampos.classList.contains('visible')) {
              if (nuevaContrasenaInput && nuevaContrasenaInput.value.length < 6) { // Ejemplo: mínimo 6 caracteres
                  mostrarError(nuevaContrasenaInput, 'La nueva contraseña debe tener al menos 6 caracteres.');
                  valido = false;
              }
              if (confirmarContrasenaInput && nuevaContrasenaInput.value !== confirmarContrasenaInput.value) {
                  mostrarError(confirmarContrasenaInput, 'Las contraseñas no coinciden.');
                  valido = false;
              }
          }


          if (!valido) {
              event.preventDefault(); // Detener envío del formulario
              // Opcional: scroll al primer error
              const primerError = perfilForm.querySelector('.error-message');
              if (primerError) {
                  primerError.previousElementSibling.focus();
              }
          }
      });
  }

  function validarEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(String(email).toLowerCase());
  }

  function mostrarError(inputElement, mensaje) {
      const errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      errorDiv.style.color = 'red';
      errorDiv.style.fontSize = '0.9em';
      errorDiv.style.marginTop = '3px';
      errorDiv.textContent = mensaje;
      inputElement.parentNode.appendChild(errorDiv);
      inputElement.classList.add('input-error'); // Podrías añadir una clase para borde rojo
  }
  
  // Toggle para contraseña (si quieres icono de ojo)
  // const togglePasswordButtons = document.querySelectorAll('.toggle-password');
  // togglePasswordButtons.forEach(button => {
  //     button.addEventListener('click', function() {
  //         const input = this.previousElementSibling;
  //         const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
  //         input.setAttribute('type', type);
  //         this.textContent = type === 'password' ? 'Mostrar' : 'Ocultar'; // O cambiar icono
  //     });
  // });

});