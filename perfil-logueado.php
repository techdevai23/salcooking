<?php
// Comprobamos si la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'controllers/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
  header("Location: login.php");
  exit();
}
// guardamos el usuario que ha entrado a la página de perfil
$id_usuario = $_SESSION['id_usuario'];
//DEPURACION
echo "<!-- id_usuario de sesión: " . $_SESSION['id_usuario'] . " -->";

require_once 'models/usuario.php';
$usuario_model = new Usuario();
$usuario = $usuario_model->obtenerPorId($id_usuario);

// Obtener alergias y enfermedades del usuario
$alergias_usuario = [];
$enfermedades_usuario = [];

// Obtener alergias del usuario
$sql_alergias = "SELECT a.id, a.nombre 
                 FROM alergias a 
                 JOIN usuario_alergia ua ON a.id = ua.id_alergia 
                 WHERE ua.id_usuario = ?";
$stmt_alergias = $conexion->prepare($sql_alergias);
$stmt_alergias->bind_param("i", $id_usuario);
$stmt_alergias->execute();
$result_alergias = $stmt_alergias->get_result();
while ($alergia = $result_alergias->fetch_assoc()) {
  $alergias_usuario[] = $alergia;
}
$stmt_alergias->close();

// Obtener enfermedades del usuario
$sql_enfermedades = "SELECT e.id, e.nombre 
                     FROM enfermedades e 
                     JOIN usuario_enfermedad ue ON e.id = ue.id_enfermedad 
                     WHERE ue.id_usuario = ?";
$stmt_enfermedades = $conexion->prepare($sql_enfermedades);
$stmt_enfermedades->bind_param("i", $id_usuario);
$stmt_enfermedades->execute();
$result_enfermedades = $stmt_enfermedades->get_result();
while ($enfermedad = $result_enfermedades->fetch_assoc()) {
  $enfermedades_usuario[] = $enfermedad;
}
$stmt_enfermedades->close();

// Obtener todas las alergias y enfermedades disponibles para poder seleccionar en el perfil
$sql_todas_alergias = "SELECT id, nombre FROM alergias ORDER BY nombre";
$sql_todas_enfermedades = "SELECT id, nombre FROM enfermedades ORDER BY nombre";

$result_todas_alergias = $conexion->query($sql_todas_alergias);
$result_todas_enfermedades = $conexion->query($sql_todas_enfermedades);

$todas_alergias = [];
$todas_enfermedades = [];

while ($alergia = $result_todas_alergias->fetch_assoc()) {
  $todas_alergias[] = $alergia;
}
while ($enfermedad = $result_todas_enfermedades->fetch_assoc()) {
  $todas_enfermedades[] = $enfermedad;
}

$nombre_pagina = "Mi Perfil";
$mensaje_feedback = '';
$tipo_mensaje = '';

$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/perfil-ajustes.css?v=' . filemtime('styles/perfil-ajustes.css') . '">';
$css_extra .= '<link rel="stylesheet" href="styles/password-validation.css?v=' . filemtime('styles/password-validation.css') . '">';
$css_extra .= '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
$css_extra .= '<script src="scripts/validacion-password.js"></script>';
?>

<?php include 'header.php'; ?>

<body class="usuario-logueado">

  <!-- migas -->
  <div class="migas-container">
    <div class="container migas-flex">
      <ul class="migas">
        <li><a href="index.php">Inicio</a></li>
        <li class="current"><?php echo htmlspecialchars($nombre_pagina); ?></li>
      </ul>
      <div class="volver-atras-contenedor">
        <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
      </div>
    </div>
  </div>

  <!-- Contenido principal-->
  <section class="perfil-ajustes">
    <div class="contenedor-Perfil-Ajustes">

      <div class="titulo">
        <img src="sources/iconos/Book-Star--Streamline-Ultimate.svg" alt="Icono Perfil">
        <h1><?php echo htmlspecialchars($nombre_pagina); ?></h1>
      </div>

      <h6>Estos son tus datos actuales. Modifica lo que necesites y guarda los cambios con el botón "Actualizar datos"</h6>

      <br>
      <div class="contenido-Perfil-Ajustes">
        <?php if (!empty($mensaje_feedback)): ?>
          <div class="mensaje-feedback <?php echo $tipo_mensaje; ?>"><?php echo $mensaje_feedback; ?></div>
        <?php endif; ?>

        <form id="perfilForm" method="POST" action="actualizar-perfil.php" onsubmit="return validarFormulario();">
          <div class="perfil-form-grid">
            <div class="form-group">
              <label for="nombre_completo">Nombre Completo: <span class="required">*</span></label>
              <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars((string)($usuario['nombre_completo'] ?? '')); ?>" required>
            </div>

            <div class="form-group">
              <label for="nick">Nick: <span class="required">*</span></label>
              <input type="text" id="nick" name="nick" value="<?php echo htmlspecialchars((string)($usuario['nick'] ?? '')); ?>" required>
            </div>

            <div class="form-group">
              <label for="email">Email: <span class="required">*</span></label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars((string)($usuario['email'] ?? '')); ?>" required>
            </div>

            <div class="form-group">
              <label for="direccion">Dirección:</label>
              <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars((string)($usuario['direccion'] ?? '')); ?>">
            </div>

            <div class="form-group">
              <label for="ciudad">Ciudad:</label>
              <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars((string)($usuario['ciudad'] ?? '')); ?>">
            </div>


            <div class="form-group">
              <label for="pais">País:</label>
              <!-- solo paises de habla hispana -->
              <select id="pais" name="pais" required>
                <option value="" <?php echo empty($usuario['pais']) ? 'selected' : ''; ?>>Seleccionar...</option>
                <option value="Argentina" <?php echo ($usuario['pais'] == 'Argentina') ? 'selected' : ''; ?>>Argentina</option>
                <option value="Bolivia" <?php echo ($usuario['pais'] == 'Bolivia') ? 'selected' : ''; ?>>Bolivia</option>
                <option value="Chile" <?php echo ($usuario['pais'] == 'Chile') ? 'selected' : ''; ?>>Chile</option>
                <option value="Colombia" <?php echo ($usuario['pais'] == 'Colombia') ? 'selected' : ''; ?>>Colombia</option>
                <option value="Costa Rica" <?php echo ($usuario['pais'] == 'Costa Rica') ? 'selected' : ''; ?>>Costa Rica</option>
                <option value="Cuba" <?php echo ($usuario['pais'] == 'Cuba') ? 'selected' : ''; ?>>Cuba</option>
                <option value="Ecuador" <?php echo ($usuario['pais'] == 'Ecuador') ? 'selected' : ''; ?>>Ecuador</option>
                <option value="El Salvador" <?php echo ($usuario['pais'] == 'El Salvador') ? 'selected' : ''; ?>>El Salvador</option>
                <option value="España" <?php echo ($usuario['pais'] == 'España') ? 'selected' : ''; ?>>España</option>
                <option value="Guatemala" <?php echo ($usuario['pais'] == 'Guatemala') ? 'selected' : ''; ?>>Guatemala</option>
                <option value="Honduras" <?php echo ($usuario['pais'] == 'Honduras') ? 'selected' : ''; ?>>Honduras</option>
                <option value="México" <?php echo ($usuario['pais'] == 'México') ? 'selected' : ''; ?>>México</option>
                <option value="Nicaragua" <?php echo ($usuario['pais'] == 'Nicaragua') ? 'selected' : ''; ?>>Nicaragua</option>
                <option value="Panamá" <?php echo ($usuario['pais'] == 'Panamá') ? 'selected' : ''; ?>>Panamá</option>
                <option value="Paraguay" <?php echo ($usuario['pais'] == 'Paraguay') ? 'selected' : ''; ?>>Paraguay</option>
                <option value="Perú" <?php echo ($usuario['pais'] == 'Perú') ? 'selected' : ''; ?>>Perú</option>
                <option value="Puerto Rico" <?php echo ($usuario['pais'] == 'Puerto Rico') ? 'selected' : ''; ?>>Puerto Rico</option>
                <option value="República Dominicana" <?php echo ($usuario['pais'] == 'República Dominicana') ? 'selected' : ''; ?>>República Dominicana</option>
                <option value="Uruguay" <?php echo ($usuario['pais'] == 'Uruguay') ? 'selected' : ''; ?>>Uruguay</option>
                <option value="Venezuela" <?php echo ($usuario['pais'] == 'Venezuela') ? 'selected' : ''; ?>>Venezuela</option>
                <option value="Guinea Ecuatorial" <?php echo ($usuario['pais'] == 'Guinea Ecuatorial') ? 'selected' : ''; ?>>Guinea Ecuatorial</option>
              </select>
            </div>

            <div class="form-group edad-group">
              <label for="fecha_nacimiento">Fecha de nacimiento:</label>
              <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                value="<?php echo htmlspecialchars($usuario['fecha_nacimiento'] ?? ''); ?>"
                class="form-control" style="width: 200px;">
            </div>

            <div class="form-group">
              <label>Sexo:</label>
              <select id="sexo" name="sexo" style="padding: 5px; width: 150px;">
                <option value="" <?php echo ($usuario['sexo'] == '') ? 'selected' : ''; ?>>Seleccionar...</option>
                <option value="Masculino" <?php echo ($usuario['sexo'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="Femenino" <?php echo ($usuario['sexo'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                <option value="Otro" <?php echo ($usuario['sexo'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
              </select>
            </div>

            <div class="form-group">
              <label for="peso_kg_display">Peso (kg):</label>
              <input type="text" id="peso_kg_display" name="peso_kg_display" value="<?php echo htmlspecialchars($usuario['peso_kg']); ?>" style="width: 80px;">
            </div>

            <div class="form-group">
              <label for="fecha_registro">Fecha y hora de registro:</label>
              <input type="text" id="fecha_registro" name="fecha_registro" value="<?php echo htmlspecialchars($usuario['fecha_registro']); ?>" style="width: 80px;">
            </div>

            <!-- Sección de cambio de contraseña -->
            <div class="form-group">
              <label for="nueva_contrasena">Nueva contraseña:</label>
              <div style="position: relative; display: inline-block;">
                <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Nueva contraseña">
                <button type="button" onclick="togglePassword('nueva_contrasena', this)" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;" title="Mostrar contraseña">
                  👁️
                </button>
              </div>

            </div>
            <div class="form-group">
              <label for="confirmar_contrasena">Confirmar nueva contraseña:</label>
              <div style="position: relative; display: inline-block;">
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar nueva contraseña" oninput="validarPassword()" style="padding-right: 30px;">
                <button type="button" onclick="togglePassword('confirmar_contrasena', this)" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;" title="Mostrar contraseña">
                  👁️
                </button>
              </div>
              <div id="password-match" class="password-match"></div>
            </div>
            <!-- Fin sección de cambio de contraseña -->

          </div>

          <!-- SECCIÓN PREMIUM (como en la imagen) -->
          <?php if ($usuario['es_premium']): ?>
            <!-- Contenido para usuarios premium -->
            <div class="premium-container">
              <div class="premium-status">
                <img src="sources/iconos/Vip-Circle--Streamline-Ultimate.png" alt="Premium">
                <span>Eres usuario Premium</span>
              </div>
              <a href="pasarela-pago.php">
                <button type="button" class="premium-button" title="Comprar un nuevo código de registro">
                  Renovar plan premium
                </button>
              </a>
              <button type="submit" name="accion" value="guardar_cambios" class="action-btn-verde">
                Actualizar datos
              </button>
            </div>
          <?php else: ?>
            <!-- Contenido para usuarios no premium -->
            <!-- SECCIÓN PREMIUM - Esto es para usuarios no registrados y logueados -->
            <div class="premium-section" style="margin-top:30px;">
              <h3>
                Opciones Prémium
                <img src="sources/iconos/Vip-Circle--Streamline-Ultimate.png" alt="info" class="info-icon" title="Funcionalidades exclusivas para usuarios Prémium" style="width:40px; height:40px;">
              </h3>
              <div style="text-align: center; margin-top: 20px;">
                <h5>Posibilidad de opciones Prémium disponibles una vez completado el registro</h5>
                <p>Filtros para especificar alergias, intolerancias, enfermedades y generar dieta semanal.</p>
              
                <a href="contacto.php" id="btn-premium-perfil" title="Solo puedes ganar: Hazte Prémium" class="btn-premium">Hazte Prémium</a>
              </div>

            </div>

            <!-- <div class="form-actions" style="margin-top:30px;">
                <button type="submit" name="accion" value="guardar_cambios" class="action-btn-verde" style="background-color: #2D3E2E; color: white; padding: 12px 30px !important; font-size: 1.1rem;">
                  <?php echo isset($_SESSION['id_usuario']) ? 'Guardar Cambios' : 'Crear Cuenta'; ?>
                </button>
              </div> -->
        </form>
      </div>
    </div>
  </section>
  <!-- <div class="premium-container">
                <a href="contacto.php">
                  <button type="button" class="premium-button">
                    Hazte Prémium
                  </button>
                </a>
                <div class="premium-status">
                  <label for="codigo_registro">Código de registro:</label>
                  <input type="text" id="codigo_registro" name="codigo_registro" placeholder="">
                  <button type="button" id="validarCodigoBtn" title="Aplicar Código" class="action-btn-verde">Validar</button>
                </div>
                <div id="mensajeCodigo"></div>
              </div> -->
<?php endif; ?>

<!-- selección de opciones premium filtros -->
<?php if ($usuario['es_premium']): ?>
  <!-- filtros para usuarios premium -->
  <div class="premium-section" style="margin-top:30px;">
    <h3>
      Opciones Prémium
      <img src="sources/iconos/Vip-Circle--Streamline-Ultimate.png" alt="info" class="info-icon" title="Funcionalidades exclusivas para usuarios Prémium" style="width:40px; height:40px;">
    </h3>
    <div class="premium-instructions">
      Selecciona todas las opciones que necesites. Haz clic nuevamente para deseleccionar.
    </div>
    <div class="premium-options-grid">
      <div class="form-group">
        <label>Alérgenos</label>
        <div class="checkbox-list">
          <?php foreach ($todas_alergias as $alergia): ?>
            <label class="checkbox-option">
              <input type="checkbox"
                name="intolerancias[]"
                value="<?php echo $alergia['id']; ?>"
                <?php echo in_array($alergia['id'], array_column($alergias_usuario, 'id')) ? 'checked' : ''; ?>>
              <span class="checkmark"></span>
              <?php echo htmlspecialchars((string)($alergia['nombre'] ?? '')); ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="form-group">
        <label>Enfermedades</label>
        <div class="checkbox-list">
          <?php foreach ($todas_enfermedades as $enfermedad): ?>
            <label class="checkbox-option">
              <input type="checkbox"
                name="enfermedades[]"
                value="<?php echo $enfermedad['id']; ?>"
                <?php echo in_array($enfermedad['id'], array_column($enfermedades_usuario, 'id')) ? 'checked' : ''; ?>>
              <span class="checkmark"></span>
              <?php echo htmlspecialchars((string)($enfermedad['nombre'] ?? '')); ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

  </div>
<?php else: ?>
  <!-- Contenido para usuarios no premium -->

<?php endif; ?>

<!-- actualizar datos -->
<div class="form-actions" style="margin-top:30px;">
  <button type="submit" name="accion" value="guardar_cambios" class="action-btn-verde" style="background-color: #2D3E2E; color: white; padding: 12px 30px !important; font-size: 1.1rem;">
    Actualizar datos
  </button>
</div>
</form>
</div>
</div>
</section>

<?php include 'footer.php'; ?>

<script>
  // Función para alternar la visibilidad de la contraseña
  function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
      input.type = 'text';
      button.title = 'Ocultar contraseña';
    } else {
      input.type = 'password';
      button.title = 'Mostrar contraseña';
    }
  }

  // Función para validar la contraseña en tiempo real
  function validarPassword() {
    const password = document.getElementById('nueva_contrasena').value;
    const confirm = document.getElementById('confirmar_contrasena').value;

    // Validar requisitos de contraseña
    const hasLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    // Actualizar indicadores visuales
    document.getElementById('length').style.color = hasLength ? 'green' : 'red';
    document.getElementById('uppercase').style.color = hasUppercase ? 'green' : 'red';
    document.getElementById('number').style.color = hasNumber ? 'green' : 'red';
    document.getElementById('special').style.color = hasSpecial ? 'green' : 'red';

    // Validar coincidencia de contraseñas
    const matchElement = document.getElementById('password-match');
    if (password && confirm) {
      if (password === confirm) {
        matchElement.textContent = 'Las contraseñas coinciden';
        matchElement.style.color = 'green';
      } else {
        matchElement.textContent = 'Las contraseñas no coinciden';
        matchElement.style.color = 'red';
      }
    } else {
      matchElement.textContent = '';
    }
  }

  // Toggle para mostrar/ocultar contraseña
  document.querySelector('.show-password').addEventListener('click', function(e) {
    e.preventDefault();
    const passwordInput = document.getElementById('nueva_contrasena');
    const confirmInput = document.getElementById('confirmar_contrasena');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      confirmInput.type = 'text';
      this.textContent = 'Ocultar contraseñas';
    } else {
      passwordInput.type = 'password';
      confirmInput.type = 'password';
      this.textContent = 'Mostrar contraseñas';
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    // Script para validar código premium
    const validarCodigoBtn = document.getElementById('validarCodigoBtn');
    const codigoInput = document.getElementById('codigo_registro');
    const mensajeCodigo = document.getElementById('mensajeCodigo');

    if (validarCodigoBtn) {
      validarCodigoBtn.addEventListener('click', function() {
        const codigo = codigoInput.value.trim();

        if (!codigo) {
          mostrarMensaje('Por favor, introduce un código', 'error');
          return;
        }

        const formData = new FormData();
        formData.append('codigo', codigo);

        fetch('controllers/validar-codigo-premium.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              mostrarMensaje(data.message, 'success');
              setTimeout(() => {
                window.location.reload();
              }, 2000);
            } else {
              mostrarMensaje(data.message, 'error');
            }
          })
          .catch(error => {
            mostrarMensaje('Error al procesar la solicitud', 'error');
            console.error('Error:', error);
          });
      });
    }

    function mostrarMensaje(mensaje, tipo) {
      mensajeCodigo.textContent = mensaje;
      mensajeCodigo.className = tipo === 'success' ? 'mensaje-exito' : 'mensaje-error';
    }
  });

  // Asegurarnos de que la validación se aplique a ambos botones
  document.querySelectorAll('button[type="submit"]').forEach(button => {
    button.addEventListener('click', function(e) {
      if (!validarFormulario()) {
        e.preventDefault();
      }
    });
  });

  function validarFormulario() {
    const password = document.getElementById('nueva_contrasena').value;
    const confirm = document.getElementById('confirmar_contrasena').value;

    // Si alguno de los campos de contraseña está lleno, validar ambos
    if (password || confirm) {
      if (!password || !confirm) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Debes completar ambos campos de contraseña'
        });
        return false;
      }

      // Validar requisitos de contraseña
      const hasLength = password.length >= 8;
      const hasUppercase = /[A-Z]/.test(password);
      const hasNumber = /[0-9]/.test(password);
      const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

      if (!hasLength || !hasUppercase || !hasNumber || !hasSpecial) {
        Swal.fire({
          icon: 'error',
          title: 'Contraseña no válida',
          text: 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.'
        });
        return false;
      }

      if (password !== confirm) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Las contraseñas no coinciden'
        });
        return false;
      }
    }

    return true;
  }
</script>
</body><?php
        // Comprobamos si la sesión está iniciada
        if (session_status() === PHP_SESSION_NONE) {
          session_start();
        }
        include 'controllers/conexion.php';

        if (!isset($_SESSION['id_usuario'])) {
          header("Location: login.php");
          exit();
        }
        // guardamos el usuario que ha entrado a la página de perfil
        $id_usuario = $_SESSION['id_usuario'];
        //DEPURACION
        echo "<!-- id_usuario de sesión: " . $_SESSION['id_usuario'] . " -->";

        require_once 'models/usuario.php';
        $usuario_model = new Usuario();
        $usuario = $usuario_model->obtenerPorId($id_usuario);

        // Obtener alergias y enfermedades del usuario
        $alergias_usuario = [];
        $enfermedades_usuario = [];

        // Obtener alergias del usuario
        $sql_alergias = "SELECT a.id, a.nombre 
                 FROM alergias a 
                 JOIN usuario_alergia ua ON a.id = ua.id_alergia 
                 WHERE ua.id_usuario = ?";
        $stmt_alergias = $conexion->prepare($sql_alergias);
        $stmt_alergias->bind_param("i", $id_usuario);
        $stmt_alergias->execute();
        $result_alergias = $stmt_alergias->get_result();
        while ($alergia = $result_alergias->fetch_assoc()) {
          $alergias_usuario[] = $alergia;
        }
        $stmt_alergias->close();

        // Obtener enfermedades del usuario
        $sql_enfermedades = "SELECT e.id, e.nombre 
                     FROM enfermedades e 
                     JOIN usuario_enfermedad ue ON e.id = ue.id_enfermedad 
                     WHERE ue.id_usuario = ?";
        $stmt_enfermedades = $conexion->prepare($sql_enfermedades);
        $stmt_enfermedades->bind_param("i", $id_usuario);
        $stmt_enfermedades->execute();
        $result_enfermedades = $stmt_enfermedades->get_result();
        while ($enfermedad = $result_enfermedades->fetch_assoc()) {
          $enfermedades_usuario[] = $enfermedad;
        }
        $stmt_enfermedades->close();

        // Obtener todas las alergias y enfermedades disponibles para poder seleccionar en el perfil
        $sql_todas_alergias = "SELECT id, nombre FROM alergias ORDER BY nombre";
        $sql_todas_enfermedades = "SELECT id, nombre FROM enfermedades ORDER BY nombre";

        $result_todas_alergias = $conexion->query($sql_todas_alergias);
        $result_todas_enfermedades = $conexion->query($sql_todas_enfermedades);

        $todas_alergias = [];
        $todas_enfermedades = [];

        while ($alergia = $result_todas_alergias->fetch_assoc()) {
          $todas_alergias[] = $alergia;
        }
        while ($enfermedad = $result_todas_enfermedades->fetch_assoc()) {
          $todas_enfermedades[] = $enfermedad;
        }

        $nombre_pagina = "Mi Perfil";
        $mensaje_feedback = '';
        $tipo_mensaje = '';

        $css_extra = '';
        $css_extra .= '<link rel="stylesheet" href="styles/perfil-ajustes.css?v=' . filemtime('styles/perfil-ajustes.css') . '">';
        $css_extra .= '<link rel="stylesheet" href="styles/password-validation.css?v=' . filemtime('styles/password-validation.css') . '">';
        $css_extra .= '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        $css_extra .= '<script src="scripts/validacion-password.js"></script>';
        ?>

<?php include 'header.php'; ?>

<body class="usuario-logueado">

  <!-- migas -->
  <div class="migas-container">
    <div class="container migas-flex">
      <ul class="migas">
        <li><a href="index.php">Inicio</a></li>
        <li class="current"><?php echo htmlspecialchars($nombre_pagina); ?></li>
      </ul>
      <div class="volver-atras-contenedor">
        <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
      </div>
    </div>
  </div>

  <!-- Contenido principal-->
  <section class="perfil-ajustes">
    <div class="contenedor-Perfil-Ajustes">

      <div class="titulo">
        <img src="sources/iconos/Book-Star--Streamline-Ultimate.svg" alt="Icono Perfil">
        <h1><?php echo htmlspecialchars($nombre_pagina); ?></h1>
      </div>

      <h6>Estos son tus datos actuales. Modifica lo que necesites y guarda los cambios con el botón "Actualizar datos"</h6>

      <br>
      <div class="contenido-Perfil-Ajustes">
        <?php if (!empty($mensaje_feedback)): ?>
          <div class="mensaje-feedback <?php echo $tipo_mensaje; ?>"><?php echo $mensaje_feedback; ?></div>
        <?php endif; ?>

        <form id="perfilForm" method="POST" action="actualizar-perfil.php" onsubmit="return validarFormulario();">
          <div class="perfil-form-grid">
            <div class="form-group">
              <label for="nombre_completo">Nombre Completo: <span class="required">*</span></label>
              <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars((string)($usuario['nombre_completo'] ?? '')); ?>" required>
            </div>

            <div class="form-group">
              <label for="nick">Nick: <span class="required">*</span></label>
              <input type="text" id="nick" name="nick" value="<?php echo htmlspecialchars((string)($usuario['nick'] ?? '')); ?>" required>
            </div>

            <div class="form-group">
              <label for="email">Email: <span class="required">*</span></label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars((string)($usuario['email'] ?? '')); ?>" required>
            </div>

            <div class="form-group">
              <label for="direccion">Dirección:</label>
              <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars((string)($usuario['direccion'] ?? '')); ?>">
            </div>

            <div class="form-group">
              <label for="ciudad">Ciudad:</label>
              <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars((string)($usuario['ciudad'] ?? '')); ?>">
            </div>


            <div class="form-group">
              <label for="pais">País:</label>
              <!-- solo paises de habla hispana -->
              <select id="pais" name="pais" required>
                <option value="" <?php echo empty($usuario['pais']) ? 'selected' : ''; ?>>Seleccionar...</option>
                <option value="Argentina" <?php echo ($usuario['pais'] == 'Argentina') ? 'selected' : ''; ?>>Argentina</option>
                <option value="Bolivia" <?php echo ($usuario['pais'] == 'Bolivia') ? 'selected' : ''; ?>>Bolivia</option>
                <option value="Chile" <?php echo ($usuario['pais'] == 'Chile') ? 'selected' : ''; ?>>Chile</option>
                <option value="Colombia" <?php echo ($usuario['pais'] == 'Colombia') ? 'selected' : ''; ?>>Colombia</option>
                <option value="Costa Rica" <?php echo ($usuario['pais'] == 'Costa Rica') ? 'selected' : ''; ?>>Costa Rica</option>
                <option value="Cuba" <?php echo ($usuario['pais'] == 'Cuba') ? 'selected' : ''; ?>>Cuba</option>
                <option value="Ecuador" <?php echo ($usuario['pais'] == 'Ecuador') ? 'selected' : ''; ?>>Ecuador</option>
                <option value="El Salvador" <?php echo ($usuario['pais'] == 'El Salvador') ? 'selected' : ''; ?>>El Salvador</option>
                <option value="España" <?php echo ($usuario['pais'] == 'España') ? 'selected' : ''; ?>>España</option>
                <option value="Guatemala" <?php echo ($usuario['pais'] == 'Guatemala') ? 'selected' : ''; ?>>Guatemala</option>
                <option value="Honduras" <?php echo ($usuario['pais'] == 'Honduras') ? 'selected' : ''; ?>>Honduras</option>
                <option value="México" <?php echo ($usuario['pais'] == 'México') ? 'selected' : ''; ?>>México</option>
                <option value="Nicaragua" <?php echo ($usuario['pais'] == 'Nicaragua') ? 'selected' : ''; ?>>Nicaragua</option>
                <option value="Panamá" <?php echo ($usuario['pais'] == 'Panamá') ? 'selected' : ''; ?>>Panamá</option>
                <option value="Paraguay" <?php echo ($usuario['pais'] == 'Paraguay') ? 'selected' : ''; ?>>Paraguay</option>
                <option value="Perú" <?php echo ($usuario['pais'] == 'Perú') ? 'selected' : ''; ?>>Perú</option>
                <option value="Puerto Rico" <?php echo ($usuario['pais'] == 'Puerto Rico') ? 'selected' : ''; ?>>Puerto Rico</option>
                <option value="República Dominicana" <?php echo ($usuario['pais'] == 'República Dominicana') ? 'selected' : ''; ?>>República Dominicana</option>
                <option value="Uruguay" <?php echo ($usuario['pais'] == 'Uruguay') ? 'selected' : ''; ?>>Uruguay</option>
                <option value="Venezuela" <?php echo ($usuario['pais'] == 'Venezuela') ? 'selected' : ''; ?>>Venezuela</option>
                <option value="Guinea Ecuatorial" <?php echo ($usuario['pais'] == 'Guinea Ecuatorial') ? 'selected' : ''; ?>>Guinea Ecuatorial</option>
              </select>
            </div>

            <div class="form-group edad-group">
              <label for="fecha_nacimiento">Fecha de nacimiento:</label>
              <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                value="<?php echo htmlspecialchars($usuario['fecha_nacimiento'] ?? ''); ?>"
                class="form-control" style="width: 200px;">
            </div>

            <div class="form-group">
              <label>Sexo:</label>
              <select id="sexo" name="sexo" style="padding: 5px; width: 150px;">
                <option value="" <?php echo ($usuario['sexo'] == '') ? 'selected' : ''; ?>>Seleccionar...</option>
                <option value="Masculino" <?php echo ($usuario['sexo'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="Femenino" <?php echo ($usuario['sexo'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                <option value="Otro" <?php echo ($usuario['sexo'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
              </select>
            </div>

            <div class="form-group">
              <label for="peso_kg_display">Peso (kg):</label>
              <input type="text" id="peso_kg_display" name="peso_kg_display" value="<?php echo htmlspecialchars($usuario['peso_kg']); ?>" style="width: 80px;">
            </div>

            <div class="form-group">
              <label for="fecha_registro">Fecha y hora de registro:</label>
              <input type="text" id="fecha_registro" name="fecha_registro" value="<?php echo htmlspecialchars($usuario['fecha_registro']); ?>" style="width: 80px;">
            </div>

            <!-- Sección de cambio de contraseña -->
            <div class="form-group">
              <label for="nueva_contrasena">Nueva contraseña:</label>
              <div style="position: relative; display: inline-block;">
                <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Nueva contraseña">
                <button type="button" onclick="togglePassword('nueva_contrasena', this)" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;" title="Mostrar contraseña">
                  👁️
                </button>
              </div>

            </div>
            <div class="form-group">
              <label for="confirmar_contrasena">Confirmar nueva contraseña:</label>
              <div style="position: relative; display: inline-block;">
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar nueva contraseña" oninput="validarPassword()" style="padding-right: 30px;">
                <button type="button" onclick="togglePassword('confirmar_contrasena', this)" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;" title="Mostrar contraseña">
                  👁️
                </button>
              </div>
              <div id="password-match" class="password-match"></div>
            </div>
            <!-- Fin sección de cambio de contraseña -->



            <!-- SECCIÓN PREMIUM (como en la imagen) -->
            <?php if ($usuario['es_premium']): ?>
              <!-- Contenido para usuarios premium -->
              <div class="premium-container">
                <div class="premium-status">
                  <img src="sources/iconos/Vip-Circle--Streamline-Ultimate.png" alt="Premium">
                  <span>Eres usuario Premium</span>
                </div>
                <a href="pasarela-pago.php">
                  <button type="button" class="premium-button" title="Comprar un nuevo código de registro">
                    Renovar plan premium
                  </button>
                </a>
                <button type="submit" name="accion" value="guardar_cambios" class="action-btn-verde">
                  Actualizar datos
                </button>
              </div>
            <?php else: ?>
              <!-- Contenido para usuarios no premium -->
              <div class="premium-container">
                <a href="contacto.php">
                  <button type="button" class="premium-button">
                    Hazte Prémium
                  </button>
                </a>
                <div class="premium-status">
                  <label for="codigo_registro">Código de registro:</label>
                  <input type="text" id="codigo_registro" name="codigo_registro" placeholder="">
                  <button type="button" id="validarCodigoBtn" title="Aplicar Código" class="action-btn-verde">Validar</button>
                </div>
                <div id="mensajeCodigo"></div>
              </div>
            <?php endif; ?>

            <!-- selección de opciones premium filtros -->
            <?php if ($usuario['es_premium']): ?>
              <!-- filtros para usuarios premium -->
              <div class="premium-section" style="margin-top:30px;">
                <h3>
                  Opciones Prémium
                  <img src="sources/iconos/Vip-Circle--Streamline-Ultimate.png" alt="info" class="info-icon" title="Funcionalidades exclusivas para usuarios Prémium" style="width:40px; height:40px;">
                </h3>
                <div class="premium-instructions">
                  Selecciona todas las opciones que necesites. Haz clic nuevamente para deseleccionar.
                </div>
                <div class="premium-options-grid">
                  <div class="form-group">
                    <label>Alérgenos</label>
                    <div class="checkbox-list">
                      <?php foreach ($todas_alergias as $alergia): ?>
                        <label class="checkbox-option">
                          <input type="checkbox"
                            name="intolerancias[]"
                            value="<?php echo $alergia['id']; ?>"
                            <?php echo in_array($alergia['id'], array_column($alergias_usuario, 'id')) ? 'checked' : ''; ?>>
                          <span class="checkmark"></span>
                          <?php echo htmlspecialchars((string)($alergia['nombre'] ?? '')); ?>
                        </label>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Enfermedades</label>
                    <div class="checkbox-list">
                      <?php foreach ($todas_enfermedades as $enfermedad): ?>
                        <label class="checkbox-option">
                          <input type="checkbox"
                            name="enfermedades[]"
                            value="<?php echo $enfermedad['id']; ?>"
                            <?php echo in_array($enfermedad['id'], array_column($enfermedades_usuario, 'id')) ? 'checked' : ''; ?>>
                          <span class="checkmark"></span>
                          <?php echo htmlspecialchars((string)($enfermedad['nombre'] ?? '')); ?>
                        </label>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>

              </div>
            <?php else: ?>
              <!-- Contenido para usuarios no premium -->
              <h5>
                Posibilidad de opciones Prémium disponibles una vez completado el registro
              </h5>
              <p>Filtros para especificar alergias, intolerancias, enfermedades y generar dieta semanal.</p>
            <?php endif; ?>

            <div class="form-actions" style="margin-top:30px;">
              <button type="submit" name="accion" value="guardar_cambios" class="action-btn-verde" style="background-color: #2D3E2E; color: white; padding: 12px 30px !important; font-size: 1.1rem;">
                Actualizar datos
              </button>
            </div>
        </form>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>

  <script>
    // Función para alternar la visibilidad de la contraseña
    function togglePassword(inputId, button) {
      const input = document.getElementById(inputId);
      if (input.type === 'password') {
        input.type = 'text';
        button.title = 'Ocultar contraseña';
      } else {
        input.type = 'password';
        button.title = 'Mostrar contraseña';
      }
    }

    // Función para validar la contraseña en tiempo real
    function validarPassword() {
      const password = document.getElementById('nueva_contrasena').value;
      const confirm = document.getElementById('confirmar_contrasena').value;

      // Validar requisitos de contraseña
      const hasLength = password.length >= 8;
      const hasUppercase = /[A-Z]/.test(password);
      const hasNumber = /[0-9]/.test(password);
      const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

      // Actualizar indicadores visuales
      document.getElementById('length').style.color = hasLength ? 'green' : 'red';
      document.getElementById('uppercase').style.color = hasUppercase ? 'green' : 'red';
      document.getElementById('number').style.color = hasNumber ? 'green' : 'red';
      document.getElementById('special').style.color = hasSpecial ? 'green' : 'red';

      // Validar coincidencia de contraseñas
      const matchElement = document.getElementById('password-match');
      if (password && confirm) {
        if (password === confirm) {
          matchElement.textContent = 'Las contraseñas coinciden';
          matchElement.style.color = 'green';
        } else {
          matchElement.textContent = 'Las contraseñas no coinciden';
          matchElement.style.color = 'red';
        }
      } else {
        matchElement.textContent = '';
      }
    }

    // Toggle para mostrar/ocultar contraseña
    document.querySelector('.show-password').addEventListener('click', function(e) {
      e.preventDefault();
      const passwordInput = document.getElementById('nueva_contrasena');
      const confirmInput = document.getElementById('confirmar_contrasena');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        confirmInput.type = 'text';
        this.textContent = 'Ocultar contraseñas';
      } else {
        passwordInput.type = 'password';
        confirmInput.type = 'password';
        this.textContent = 'Mostrar contraseñas';
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Script para validar código premium
      const validarCodigoBtn = document.getElementById('validarCodigoBtn');
      const codigoInput = document.getElementById('codigo_registro');
      const mensajeCodigo = document.getElementById('mensajeCodigo');

      if (validarCodigoBtn) {
        validarCodigoBtn.addEventListener('click', function() {
          const codigo = codigoInput.value.trim();

          if (!codigo) {
            mostrarMensaje('Por favor, introduce un código', 'error');
            return;
          }

          const formData = new FormData();
          formData.append('codigo', codigo);

          fetch('controllers/validar-codigo-premium.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                mostrarMensaje(data.message, 'success');
                setTimeout(() => {
                  window.location.reload();
                }, 2000);
              } else {
                mostrarMensaje(data.message, 'error');
              }
            })
            .catch(error => {
              mostrarMensaje('Error al procesar la solicitud', 'error');
              console.error('Error:', error);
            });
        });
      }

      function mostrarMensaje(mensaje, tipo) {
        mensajeCodigo.textContent = mensaje;
        mensajeCodigo.className = tipo === 'success' ? 'mensaje-exito' : 'mensaje-error';
      }
    });

    // Asegurarnos de que la validación se aplique a ambos botones
    document.querySelectorAll('button[type="submit"]').forEach(button => {
      button.addEventListener('click', function(e) {
        if (!validarFormulario()) {
          e.preventDefault();
        }
      });
    });

    function validarFormulario() {
      const password = document.getElementById('nueva_contrasena').value;
      const confirm = document.getElementById('confirmar_contrasena').value;

      // Si alguno de los campos de contraseña está lleno, validar ambos
      if (password || confirm) {
        if (!password || !confirm) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debes completar ambos campos de contraseña'
          });
          return false;
        }

        // Validar requisitos de contraseña
        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        if (!hasLength || !hasUppercase || !hasNumber || !hasSpecial) {
          Swal.fire({
            icon: 'error',
            title: 'Contraseña no válida',
            text: 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.'
          });
          return false;
        }

        if (password !== confirm) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden'
          });
          return false;
        }
      }

      return true;
    }
  </script>
</body>