<?php
$css_extra = '';

$css_extra .= '<link rel="stylesheet" href="styles/contacto.css?v=' . filemtime('styles/contacto.css') . '">
  
';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Determinar el tipo de usuario
$es_usuario_logueado = isset($_SESSION['id_usuario']);
$es_usuario_premium = isset($_SESSION['es_premium']) && $_SESSION['es_premium'] == 1;

// Si es usuario premium, mostrar mensaje y opción de cerrar sesión



include 'header.php'; ?>

<!-- migas -->

<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li class="current">Contáctanos</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
    </div>
  </div>
</div>



<!-- titulo-->
<section class="Contacto">
  <div class="contenedor-Contacto">

    <div class="titulo">
      <img src="sources/iconos/contact--Streamline-Ultimate.svg" alt="Contacto">
      <h1>Contáctanos</h1>
    </div>



    <!-- Contenido principal con tres columnas -->
    <div class="contenido-Contacto">

      <!-- Columna izquierda - Imagen -->
      <div class="contact-left-column">

        <!-- texto-->
        <div class="left-column">
          <p>Estaremos encantados de atender como te mereces, para todo lo que necesites</p>
          <p>Si quieres tenes una cuenta <span class="premium">Prémium</span>, sólo tienes que seleccionarlo en este formulario.
            Si ya estas registrado elige <i>"Hacer el pago"</i>, si no <i>"Quiero registrarme"</i>. Tienes otras opciones también,
            porque no queremos que te quedes con ninguna duda. <strong>Porque tú y tu salud sois nuestra razón de ser</strong></p>
          <div class="imagen-contacto">
            <img src="sources/logos/tarjeta-salcooking-letras-grandes.png" alt="tarjeta salcooking" width="200px" class="tarjeta-imagen">


          </div>


        </div>


      </div>

      <!-- Columna central - Formulario -->
      <div class="contact-center-column">

        <h2>Formulario de Contacto</h2>
        <div class="contact-form-container">
          <form id="contactForm" class="needs-validation" action="controllers/procesar-contacto.php" method="POST" novalidate>
            <?php
            // Generar token CSRF
            $csrf_token = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrf_token;
            ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

            <?php if (!$es_usuario_logueado): ?>
              <!-- Campos solo para visitantes no registrados -->
              <div class="form-group">
                <label for="nombre"><i class="bi bi-person"></i> Nombre<b><span style="color:crimson">*</span></b>:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required
                  data-bs-toggle="tooltip" data-bs-placement="top"
                  title="Campo obligatorio. Introduce tu nombre ">
                <div class="invalid-feedback">
                  Por favor, introduce tu nombre.
                </div>
              </div>

              <div class="form-group">
                <label for="email"><i class="bi bi-envelope"></i> Email<b><span style="color:crimson">*</span></b>:</label>
                <input type="email" class="form-control" id="email" name="email" required
                  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-bs-toggle="tooltip"
                  data-bs-placement="top" title="Campo obligatorio. Introduce un email válido">
                <div class="invalid-feedback">
                  Por favor, introduce un email válido.
                </div>
              </div>

              <div class="form-group">
                <label for="telefono"><i class="bi bi-telephone"></i> Teléfono:</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" pattern="[0-9]{9}"
                  data-bs-toggle="tooltip" data-bs-placement="top"
                  title="Introduce un número de teléfono válido (9 dígitos)">
                <div class="invalid-feedback">
                  Por favor, introduce un número de teléfono válido.
                </div>
              </div>
            <?php endif; ?>

            <p>Es obligatorio que elijas una opción de uno de los selectores <b><span style="color:crimson">*</span></b></p>
            <div class="form-group" id="contacto-premium">
              <label for="modeloRobot"><i class="bi bi-robot"></i> Relacionado con cuenta prémium:</label>
              <select class="form-select" id="modeloRobot" name="modeloRobot" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Opcional si elegiste una opcion general">
                <option value="">Seleccione una opción</option>
                <option value="problemas">Quiero una cuenta prémium. Estoy registrado.</option>
                <option value="factura">He tenido un problema con el pago.</option>
                <option value="cancelar">Quiero cancelar mi cuenta prémium.</option>
                <option value="tecnico">Soy usuario prémium y necesito ayuda.</option>
              </select>
            </div>

            <div class="form-group">
              <label for="tipoConsulta"><i class="bi bi-question-circle"></i> Solicitar información general:</label>
              <select class="form-select" id="tipoConsulta" name="tipoConsulta" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Opcional si elegiste una opción Prémium">
                <option id="opcion" class="opcion" value="">Selecciona una opción</option>
                <option value="dudas">Quiero registrarme</option>
                <option value="compra">He tenido un problema en el momento de registro.</option>
                <option value="sugerencia">Quiero hacer una sugerencia.</option>
                <option value="otros">Otros.</option>
              </select>
            </div>

            <div class="form-check mb-3">
              <input type="checkbox" class="form-check-input" id="privacidad" name="privacidad" required>
              <label class="form-check-label" for="privacidad">
                He leído y acepto la <a href="#" data-bs-toggle="modal"
                  data-bs-target="#privacidadModal" style="text-decoration: underline;">política de privacidad</a><b><span style="color:crimson">*</span></b>
              </label>
              <div class="invalid-feedback">
                Debes aceptar la política de privacidad.
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-submit">
              <i class="bi bi-send"></i> Enviar mensaje
            </button>
          </form>
          <?php
          if (isset($_SESSION['contact_errors'])) {
            echo '<div class="alert alert-danger mt-3">';
            foreach ($_SESSION['contact_errors'] as $error) {
              echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            unset($_SESSION['contact_errors']);
          }

          if (isset($_SESSION['contact_success'])) {
            echo '<div class="alert alert-success mt-3">';
            echo '<p>' . htmlspecialchars($_SESSION['contact_success']) . '</p>';
            echo '</div>';
            unset($_SESSION['contact_success']);
          }
          ?>
        </div>
      </div>

      <!-- Columna derecha  -->
      <div class="contact-right-column">
        <div class="right-column">
          <!-- VIDEO-->
          <div class="video-container">
            <video autoplay muted loop playsinline width="100%">
              <source src="https://raw.githubusercontent.com/techdevai23/salcooking/main/sources/videos/letras-brillan-y-desaparecen-comprimido-2.mp4" type="video/mp4">
              Tu navegador no soporta el video.
            </video>


          </div>
          <!-- formas de contacto -->

          <div class="contact-image-container">

            <div class="contact-info-card">
              <h2>Nuestros Datos</h2>
              <ul class="contact-info-list">
                <li><i class="bi bi-geo-alt-fill"></i> Avenida Salud 69, El Burgo de Ebro, Zaragoza,
                  España</li>
                <li><i class="bi bi-telephone-fill"></i> +1 (555) 123-4567</li>
                <li><i class="bi bi-envelope-fill"></i> info@salcooking.es</li>
                <li><i class="bi bi-clock-fill"></i> Lunes a Viernes: 9:00 - 18:00</li>
              </ul>
              <div class="social-icons">
                <a href="https://www.facebook.com/SalCooking" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/SalCooking" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/SalCooking" target="_blank"><i class="fab fa-instagram"></i></a>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>

    <!-- Modal Política de Privacidad -->
    <div class="modal fade" id="privacidadModal" tabindex="-1" aria-labelledby="privacidadModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="privacidadModalLabel">Política de Privacidad de Salcooking</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <p>En Salcooking, nos comprometemos a proteger y respetar tu privacidad. Esta política describe cómo
              recopilamos y procesamos tus datos personales.</p>

            <h5>1. Datos que recopilamos</h5>
            <p>Recopilamos la información que nos proporcionas a través de nuestros formularios, incluyendo
              nombre, dirección de correo electrónico, número de teléfono y detalles sobre tu consulta o
              problema.</p>

            <h5>2. Cómo utilizamos tus datos</h5>
            <p>Utilizamos tus datos para:</p>
            <ul>
              <li>Responder a tus consultas y proporcionar soporte técnico</li>
              <li>Mejorar nuestros productos y servicios</li>
              <li>Enviarte información relevante sobre nuestros productos (si has dado tu consentimiento)</li>
            </ul>

            <h5>3. Protección de datos</h5>
            <p>Implementamos medidas de seguridad técnicas y organizativas para proteger tus datos personales
              contra accesos no autorizados, pérdida o alteración.</p>

            <h5>4. Tus derechos</h5>
            <p>Tienes derecho a acceder, rectificar, limitar o eliminar tus datos personales. Para ejercer estos
              derechos, contáctanos en privacy@techdevai.es.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-opciones" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- script incrustado para el formulario de contacto, he reciclado el que tenía en la web de robots
     de ahí el nombre de las clases-->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contactForm');
        const modeloRobot = document.getElementById('modeloRobot');
        const tipoConsulta = document.getElementById('tipoConsulta');
        const esUsuarioLogueado = <?php echo $es_usuario_logueado ? 'true' : 'false'; ?>;
        const esUsuarioPremium = <?php echo $es_usuario_premium ? 'true' : 'false'; ?>;

        contactForm.addEventListener('submit', function(e) {
          e.preventDefault();

          // Validar que al menos uno de los dos select tenga un valor seleccionado
          if (!modeloRobot.value && !tipoConsulta.value) {
            e.stopPropagation();
            modeloRobot.classList.add('is-invalid');
            tipoConsulta.classList.add('is-invalid');
            return;
          } else {
            modeloRobot.classList.remove('is-invalid');
            tipoConsulta.classList.remove('is-invalid');
          }

          // Validar el formulario
          if (contactForm.checkValidity() === false) {
            e.stopPropagation();
            contactForm.classList.add('was-validated');
            return;
          }

          // Validaciones específicas según el tipo de usuario
          if (esUsuarioLogueado) {
            if (modeloRobot.value === 'problemas') {
              if (esUsuarioPremium) {
                Swal.fire({
                  title: "¡Ya eres usuario Premium!",
                  html: "¿Qué deseas hacer?<br><br>Si quieres comprar un código para otra persona, primero puedes cerrar tu sesión o ir directamente a la pasarela de pago.",
                  icon: "info",
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: "Cerrar sesión",
                  denyButtonText: "Comprar código para otro",
                  cancelButtonText: "Cancelar",
                  customClass: {
                    container: "my-swal-container",
                    popup: "my-swal-popup",
                    header: "my-swal-header",
                    title: "my-swal-title",
                    content: "my-swal-content",
                    confirmButton: "my-swal-confirm-button",
                    denyButton: "my-swal-cancel-button",
                    cancelButton: "my-swal-cancel-button"
                  }
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = "logout.php";
                  } else if (result.isDenied) {
                    window.location.href = "pasarela-pago.php";
                  }
                  // Si cancela, no hace nada
                });
                return;
              } else {
                // Aquí va el código para usuarios no premium (redirigir a pasarela de pago)
                Swal.fire({
                  title: 'Redirigiendo a pasarela de pago',
                  text: 'Serás redirigido a la pasarela de pago para hacerte premium.',
                  icon: 'info',
                  confirmButtonText: 'Continuar',
                  customClass: {
                    container: 'my-swal-container',
                    popup: 'my-swal-popup',
                    header: 'my-swal-header',
                    title: 'my-swal-title',
                    content: 'my-swal-content',
                    confirmButton: 'my-swal-confirm-button'
                  }
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = 'pasarela-pago.php';
                  }
                });
                return;
              }
            } else if (tipoConsulta.value === 'dudas') {
              Swal.fire({
                title: 'Ya estás registrado',
                text: 'Ya tienes una cuenta registrada. ¿Deseas modificar tu perfil?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ir a mi perfil',
                cancelButtonText: 'Cancelar',
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
                  window.location.href = 'perfil-logueado.php';
                }
              });
              return;
            }
          } else {
            // Para visitantes no registrados
            if (modeloRobot.value === 'problemas') {
              Swal.fire({
                title: 'No estás registrado',
                text: 'Para hacerte premium primero debes registrarte.',
                icon: 'warning',
                confirmButtonText: 'Registrarme',
                customClass: {
                  container: 'my-swal-container',
                  popup: 'my-swal-popup',
                  header: 'my-swal-header',
                  title: 'my-swal-title',
                  content: 'my-swal-content',
                  confirmButton: 'my-swal-confirm-button'
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = 'perfil.php';
                }
              });
              return;
            } else if (tipoConsulta.value === 'dudas') {
              window.location.href = 'perfil.php';
              return;
            }
          }

          // Si todo está bien, mostrar confirmación y enviar formulario
          Swal.fire({
            title: '¡Formulario Procesado Correctamente!',
            html: `
              <p>Pronto tendrás noticas nuestras. Guarde este número de seguimiento</p>
              <p>Nº: <strong>${Math.floor(1000000 + Math.random() * 9000000)}</strong></p>
            `,
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Volver al inicio',
            cancelButtonText: 'Cerrar y seguir en ésta página',
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
              window.location.href = 'index.php';
            } else {
              contactForm.submit();
            }
          });
        });
      });
    </script>




    <!-- ultimo div contenedor principal -->
  </div>
</section>

<?php include 'footer.php'; ?>