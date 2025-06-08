<?php
// Comprobamos si la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Si el usuario ya está logueado, redirigir a su perfil
if (isset($_SESSION['id_usuario'])) {
  header("Location: perfil-logueado.php");
  exit();
}

include 'controllers/conexion.php'; // Conexión a la BD

$nombre_pagina = "Crear Perfil"; // Para el título y migas cuando es nuevo
$mensaje_feedback = '';
$tipo_mensaje = ''; // 'mensaje-exito' o 'mensaje-error'


//Aqui se gestiona el registro de un nuevo usuario, con todos los campos que se muestran en el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'guardar_cambios') {
  // Recoger datos del formulario
  $nombre_completo = trim($_POST['nombre_completo']);
  $nick = trim($_POST['nick']);
  $email = trim($_POST['email']);
  $direccion = trim($_POST['direccion']) ?: NULL;
  $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : NULL;
  $ciudad = trim($_POST['ciudad']) ?: NULL;
  $pais = trim($_POST['pais']) ?: NULL;
  $sexo = $_POST['sexo'] ?: NULL;
  $peso_kg_input = trim($_POST['peso_kg_display']);

  // Para la contraseña, solo necesitamos nueva y confirmar para registro
  $nueva_contrasena = $_POST['nueva_contrasena'];
  $confirmar_contrasena = $_POST['confirmar_contrasena'];

  // Validaciones
  $errores = [];
  if (empty($nombre_completo)) $errores[] = "El nombre completo es obligatorio.";
  if (empty($nick)) $errores[] = "El nick es obligatorio.";
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido o está vacío.";
  if (empty($nueva_contrasena)) $errores[] = "La contraseña es obligatoria.";
  if ($nueva_contrasena !== $confirmar_contrasena) $errores[] = "Las contraseñas no coinciden.";
  if (!empty($fecha_nacimiento) && !strtotime($fecha_nacimiento)) $errores[] = "La fecha de nacimiento no es válida.";

  if (!empty($peso_kg_input)) {
    // Convertir comas a puntos para DECIMAL y validar
    $peso_kg_input_numeric = str_replace(',', '.', $peso_kg_input);
    if (!is_numeric($peso_kg_input_numeric)) {
      $errores[] = "El peso debe ser un número válido (ej: 65.5).";
      $peso_kg = NULL;
    } else {
      $peso_kg = floatval($peso_kg_input_numeric);
    }
  } else {
    $peso_kg = NULL;
  }

  // Verificar si el email de la tabla usuarios ya existe
  if (empty($errores)) {
    $sql_check = "SELECT id_usuario FROM usuarios WHERE email = ?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $resultado_check = $stmt_check->get_result();
    if ($resultado_check->num_rows > 0) {
      $existing_user = $resultado_check->fetch_assoc();
      $errores[] = "El email introducido ya está registrado.";
    }
    $stmt_check->close();
  }

  //verificar si el nick ya existe
  if (empty($errores)) {
    $sql_check = "SELECT id_usuario FROM usuarios WHERE nick = ?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param("s", $nick);
    $stmt_check->execute();
    $resultado_check = $stmt_check->get_result();
    if ($resultado_check->num_rows > 0) {
      $errores[] = "El nick introducido ya está registrado.";
    }
    $stmt_check->close();
  }

  if (empty($errores)) {
    // Hashear contraseña
    $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

    // Insertar en la BD Salcooking®
    $sql_insert = "INSERT INTO usuarios (nombre_completo, nick, email, direccion, ciudad, pais, sexo, peso_kg, fecha_nacimiento, contrasena_hash, es_premium, fecha_registro) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW())";
    $stmt_insert = $conexion->prepare($sql_insert);
    // Tipos: s: string, i: integer, d: double/decimal
    $stmt_insert->bind_param(
      "ssssssssss",
      $nombre_completo,
      $nick,
      $email,
      $direccion,
      $ciudad,
      $pais,
      $sexo,
      $peso_kg,
      $fecha_nacimiento,
      $contrasena_hash
    );

    if ($stmt_insert->execute()) {
      $mensaje_feedback = "¡Usuario registrado con éxito! Ahora puedes iniciar sesión.";
      $tipo_mensaje = 'mensaje-exito';
      // Limpiar el formulario después de un registro exitoso
      $_POST = array();
    } else {
      $mensaje_feedback = "Error al registrar el usuario: " . $stmt_insert->error;
      $tipo_mensaje = 'mensaje-error';
    }
    $stmt_insert->close();
  } else {
    $mensaje_feedback = "Por favor, corrige los siguientes errores:<br>" . implode("<br>", $errores);
    $tipo_mensaje = 'mensaje-error';
  }
}
$conexion->close();


$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/perfil-ajustes.css?v=' . filemtime('styles/perfil-ajustes.css') . '">';
// $nombre_pagina se define arriba
?>

<?php include 'header.php'; ?>

<body class="<?php echo isset($_SESSION['id_usuario']) ? 'usuario-logueado' : ''; ?>">

  <!-- migas -->
  <div class="migas-container">
    <div class="container migas-flex">
      <ul class="migas">
        <li><a href="index.php">Inicio</a></li>
        <li class="current"><?php echo htmlspecialchars((string)($nombre_pagina ?? '')); ?></li>
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
        <h1><?php echo htmlspecialchars((string)($nombre_pagina ?? '')); ?></h1>
      </div>

      <div class="contenido-Perfil-Ajustes">
        <?php if (!empty($mensaje_feedback)): ?>
          <div class="mensaje-feedback <?php echo $tipo_mensaje; ?>"><?php echo $mensaje_feedback; ?></div>
        <?php endif; ?>

        <form id="perfilForm" method="POST" action="<?php echo htmlspecialchars((string)($_SERVER["PHP_SELF"] ?? '')); ?>" autocomplete="off">
          <div class="perfil-form-grid">
            <div class="form-group">
              <label for="nombre_completo">Nombre Completo: <span class="required">*</span></label>
              <input type="text" id="nombre_completo" name="nombre_completo" value="" required autocomplete="off">
            </div>

            <div class="form-group">
              <label for="nick">Nick: <span class="required">*</span></label>
              <input type="text" id="nick" name="nick" value="" required autocomplete="off">
            </div>

            <div class="form-group">
              <label for="email">Email: <span class="required">*</span></label>
              <input type="email" id="email" name="email" value="" required autocomplete="off">
            </div>

            <div class="form-group">
              <label for="direccion">Dirección:</label>
              <input type="text" id="direccion" name="direccion" value="" autocomplete="off">
            </div>

            <div class="form-group edad-group">
              <label for="fecha_nacimiento">Fecha de nacimiento:</label>
              <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" 
                     value="" 
                     class="form-control" style="width: 200px;" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="ciudad">Ciudad:</label>
              <input type="text" id="ciudad" name="ciudad" value="" autocomplete="off">
            </div>

            <div class="form-group">
              <label for="pais">País:</label>
              <!-- solo paises de habla hispana -->
              <select id="pais" name="pais" required>
                <option value="" selected>Seleccionar...</option>
                <option value="Argentina">Argentina</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Chile">Chile</option>
                <option value="Colombia">Colombia</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cuba">Cuba</option>
                <option value="Ecuador">Ecuador</option>
                <option value="El Salvador">El Salvador</option>
                <option value="España">España</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Honduras">Honduras</option>
                <option value="México">México</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Panamá">Panamá</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Perú">Perú</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="República Dominicana">República Dominicana</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Guinea Ecuatorial">Guinea Ecuatorial</option>
              </select>
            </div>

            <div class="form-group">
              <label>Sexo:</label>
              <select id="sexo" name="sexo" style="padding: 5px; width: 150px;" autocomplete="off">
                <option value="" selected>Seleccionar...</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <div class="form-group">
              <label for="peso_kg_display">Peso (kg):</label>
              <input type="text" id="peso_kg_display" name="peso_kg_display" placeholder="ej: 65.5" value="" style="width: 80px;" autocomplete="off">
            </div>

            <!-- Sección de Contraseña para NUEVO REGISTRO -->
            <div class="form-group">
              <label for="nueva_contrasena">Contraseña: <span class="required">*</span></label>
              <div style="position: relative; display: inline-block;">
                <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Nueva contraseña" required autocomplete="new-password">
                <button type="button" onclick="togglePassword('nueva_contrasena', this)" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;" title="Mostrar contraseña">
                  👁️
                </button>
              </div>
              <a href="#" class="show-password form-link">Mostrar contraseña</a>
              <div class="password-validation">
                <ul class="requirements-list">
                  <li id="length">Al menos 8 caracteres</li>
                  <li id="uppercase">Al menos una mayúscula</li>
                  <li id="number">Al menos un número</li>
                  <li id="special">Al menos un carácter especial</li>
                </ul>
              </div>
            </div>
            <div class="form-group">
              <label for="confirmar_contrasena">Confirmar Contraseña: <span class="required">*</span></label>
              <div style="position: relative; display: inline-block;">
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar nueva contraseña" required autocomplete="new-password">
                <button type="button" onclick="togglePassword('confirmar_contrasena', this)" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;" title="Mostrar contraseña">
                  👁️
                </button>
              </div>
              <div id="password-match" class="password-match"></div>
            </div>
            <!-- Fin Sección de Contraseña para NUEVO REGISTRO -->

            <!-- El campo de contraseña actual y el enlace 'Cambio contraseña' son para usuarios logueados modificando su perfil -->
            <!-- <div class="form-group">
              <label for="contrasena_display">Contraseña:</label>
              <input type="text" id="contrasena_display" name="contrasena_display" value="" >
              <a href="#" id="cambiarContrasenaLink" class="form-link">Cambio contraseña</a>
            </div>
            <div class="form-group">
              <div id="cambiarContrasenaCampos" class="hidden"> 
                <input type="password" id="contrasena_actual" name="contrasena_actual" placeholder="Contraseña actual" style="margin-top:5px; margin-bottom:5px;">
                <input type="password" id="nueva_contrasena_modificar" name="nueva_contrasena_modificar" placeholder="Nueva contraseña" style="margin-bottom:5px;">
                <input type="password" id="confirmar_contrasena_modificar" name="confirmar_contrasena_modificar" placeholder="Confirmar nueva contraseña">
              </div>
            </div> -->

          </div>

          <!-- SECCIÓN PREMIUM - Esto es para usuarios no registrados y logueados -->
          <div class="premium-section" style="margin-top:30px;">
            <h3>
              Opciones Prémium
              <img src="sources/iconos/Vip-Circle--Streamline-Ultimate.png" alt="info" class="info-icon" title="Funcionalidades exclusivas para usuarios Prémium" style="width:40px; height:40px;">
            </h3>
            <div style="text-align: center; margin-top: 20px;">
              <h5>Posibilidad de opciones Prémium disponibles una vez completado el registro</h5>
              <p>Filtros para especificar alergias, intolerancias, enfermedades y generar dieta semanal.</p>
            </div>
            <div class="premium-options-grid">
              <div class="form-group">
                <label for="intolerancias">Intolerancias</label>
                <select id="intolerancias" name="intolerancias[]" multiple style="min-height: 100px;" disabled>
                  <option>Gluten</option>
                  <option>Frutos secos</option>
                  <option>Pescados</option>
                </select>
              </div>
              <div class="form-group">
                <label for="enfermedades">Enfermedades</label>
                <select id="enfermedades" name="enfermedades[]" multiple style="min-height: 100px;" disabled>
                  <option>Colesterol</option>
                  <option>Diabetes</option>
                </select>
              </div>
            </div>
            
          </div>

          <div class="form-actions" style="margin-top:30px;">
            <button type="submit" name="accion" value="guardar_cambios" class="action-btn-verde" style="background-color: #2D3E2E; color: white; padding: 12px 30px !important; font-size: 1.1rem;">
              <?php echo isset($_SESSION['id_usuario']) ? 'Guardar Cambios' : 'Crear Cuenta'; ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="scripts/validacion-password.js"></script>
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
  </script>
</body>