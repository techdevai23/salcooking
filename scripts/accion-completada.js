document.addEventListener('DOMContentLoaded', function() {
  // Al cargar la página, el modal ya está visible
  
  // Si se hace clic en el botón de aceptar, redirigir a la página principal
  const btnAceptar = document.querySelector('.btn-aceptar');
  if (btnAceptar) {
      btnAceptar.addEventListener('click', function(e) {
          e.preventDefault();
          window.location.href = 'index.php';
      });
  }
  
  // Si se hace clic en el overlay (fuera del modal), también redirigir
  const overlay = document.querySelector('.overlay');
  if (overlay) {
      overlay.addEventListener('click', function() {
          window.location.href = 'index.php';
      });
  }
  
  // Opcional: Si se presiona la tecla Escape, también redirigir
  document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
          window.location.href = 'index.php';
      }
  });
});