<?php
session_start(); // Siempre al principio
include 'controllers/conexion.php'; // Conexión a la BD

$nombre_pagina = "Crear Perfil"; // Para el título y migas cuando es nuevo
$mensaje_feedback = '';
$tipo_mensaje = ''; // 'mensaje-exito' o 'mensaje-error'

// Si el usuario ya está logueado, podría ser una página de "Ajustes de Perfil"
// Por ahora, este script se enfoca en el registro de un nuevo usuario.
// Si es un usuario logueado viendo su perfil, necesitarías otra lógica para cargar sus datos.

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'guardar_cambios') {
    // Recoger datos del formulario
    $nombre_completo = trim($_POST['nombre_completo']);
    $nick = trim($_POST['nick']); // Asumiendo que se añade a la BD
    $email = trim($_POST['email']);
    $direccion = trim($_POST['direccion']) ?: NULL; // Permitir NULL si está vacío
    $edad_input = trim($_POST['edad']); // Asumimos que se envía 'edad' (INT)
    $ciudad = trim($_POST['ciudad']) ?: NULL;
    $pais = trim($_POST['pais']) ?: NULL;
    $sexo = $_POST['sexo'] ?: NULL; // Asumir que se envía un valor válido del ENUM o NULL
    $peso_kg_input = trim($_POST['peso_kg_display']); // El campo se llama peso_kg_display
    
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
    if (!empty($edad_input) && !filter_var($edad_input, FILTER_VALIDATE_INT)) $errores[] = "La edad debe ser un número.";
    else $edad = !empty($edad_input) ? intval($edad_input) : NULL;

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


    // Verificar si el email o nick ya existen (si 'nick' es UNIQUE)
    if (empty($errores)) {
        $sql_check = "SELECT id_usuario FROM usuarios WHERE email = ? OR nick = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("ss", $email, $nick);
        $stmt_check->execute();
        $resultado_check = $stmt_check->get_result();
        if ($resultado_check->num_rows > 0) {
            $existing_user = $resultado_check->fetch_assoc();
            // Podrías ser más específico sobre si es el email o el nick
            $errores[] = "El email o nick introducido ya está registrado.";
        }
        $stmt_check->close();
    }

    if (empty($errores)) {
        // Hashear contraseña
        $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

        // Insertar en la BD
        // Asegúrate de que tu tabla 'usuarios' tiene el campo 'nick'
        // y que los campos opcionales como direccion, ciudad, etc., permiten NULL.
        $sql_insert = "INSERT INTO usuarios (nombre_completo, nick, email, direccion, ciudad, pais, sexo, peso_kg, edad, contrasena_hash, es_premium, fecha_registro) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW())";
        $stmt_insert = $conexion->prepare($sql_insert);
        // Tipos: s: string, i: integer, d: double/decimal
        $stmt_insert->bind_param("sssssssdis", 
            $nombre_completo, $nick, $email, $direccion, $ciudad, $pais, $sexo, $peso_kg, $edad, $contrasena_hash
        );

        if ($stmt_insert->execute()) {
            $mensaje_feedback = "¡Usuario registrado con éxito! Ahora puedes iniciar sesión.";
            $tipo_mensaje = 'mensaje-exito';
            // Podrías redirigir a login.php o incluso auto-loguear al usuario
            // header("Location: login.php");
            // exit();
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

      <div class="contenido-Perfil-Ajustes">
        <?php if (!empty($mensaje_feedback)): ?>
          <div class="mensaje-feedback <?php echo $tipo_mensaje; ?>"><?php echo $mensaje_feedback; ?></div>
        <?php endif; ?>

        <form id="perfilForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="perfil-form-grid">
            <div class="form-group">
              <label for="nombre_completo">Nombre Completo: <span class="required">*</span></label>
              <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo isset($_POST['nombre_completo']) ? htmlspecialchars($_POST['nombre_completo']) : ''; ?>" required>
            </div>

            <div class="form-group">
              <label for="nick">Nick: <span class="required">*</span></label>
              <input type="text" id="nick" name="nick" value="<?php echo isset($_POST['nick']) ? htmlspecialchars($_POST['nick']) : ''; ?>" required>
              <!-- <a href="#" class="form-link">cambiar usuario</a> Quitar para registro nuevo -->
            </div>

            <div class="form-group">
              <label for="email">Email: <span class="required">*</span></label>
              <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>

            <div class="form-group">
              <label for="direccion">Dirección:</label>
              <input type="text" id="direccion" name="direccion" value="<?php echo isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>">
            </div>

            <div class="form-group edad-group">
              <label for="edad">Edad:</label> <!-- Cambiado a 'edad' para coincidir con BD -->
              <input type="number" id="edad" name="edad" value="<?php echo isset($_POST['edad']) ? htmlspecialchars($_POST['edad']) : ''; ?>" style="width: 80px; text-align: center;" min="0">
              <!-- El input de fecha_nacimiento_display y el icono de calendario son para UX, necesitarías JS para poblar el campo 'edad' o manejar la fecha -->
            </div>

            <div class="form-group">
              <label for="ciudad">Ciudad:</label>
              <input type="text" id="ciudad" name="ciudad" value="<?php echo isset($_POST['ciudad']) ? htmlspecialchars($_POST['ciudad']) : ''; ?>">
            </div>
           
            <div class="form-group">
              <label for="pais">País:</label>
              <input type="text" id="pais" name="pais" value="<?php echo isset($_POST['pais']) ? htmlspecialchars($_POST['pais']) : ''; ?>">
            </div>

            <div class="form-group">
              <label>Sexo:</label>
              <select id="sexo" name="sexo" style="padding: 5px; width: 150px;">
                <option value="" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == '') ? 'selected' : ''; ?>>Seleccionar...</option>
                <option value="Masculino" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                <option value="Femenino" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                <option value="Otro" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
              </select>
            </div>

            <div class="form-group">
              <label for="peso_kg_display">Peso (kg):</label>
              <input type="text" id="peso_kg_display" name="peso_kg_display" placeholder="ej: 65.5" value="<?php echo isset($_POST['peso_kg_display']) ? htmlspecialchars($_POST['peso_kg_display']) : ''; ?>" style="width: 80px;">
            </div>

            <!-- Sección de Contraseña para NUEVO REGISTRO -->
            <div class="form-group">
              <label for="nueva_contrasena">Contraseña: <span class="required">*</span></label>
              <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Nueva contraseña" required>
            </div>
            <div class="form-group">
              <label for="confirmar_contrasena">Confirmar Contraseña: <span class="required">*</span></label>
              <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar nueva contraseña" required>
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

          <!-- SECCIÓN PREMIUM (como en la imagen) - Esto es para usuarios ya registrados y logueados -->
          <!-- Por ahora, para el registro, la ocultamos o la manejamos después del registro -->
          <div class="form-group registro-codigo-group" style="max-width: 400px; <?php echo isset($_SESSION['id_usuario']) ? '' : 'display:none;';?>">
            <!-- ... (resto de la sección premium como la tienes) ... -->
          </div>
          <div class="premium-section" style="margin-top:30px; <?php echo isset($_SESSION['id_usuario']) && $_SESSION['es_premium'] ? '' : 'display:none;';?>">
            <!-- ... (resto de la sección premium como la tienes) ... -->
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

  <!-- <script src="scripts/perfil-ajustes.js"></script> --> <!-- Descomentar si tienes JS específico -->
  <script>
    // Simular que el enlace de cambiar contraseña muestra los campos (para cuando sea perfil de usuario logueado)
    // const cambiarContrasenaLink = document.getElementById('cambiarContrasenaLink');
    // const cambiarContrasenaCampos = document.getElementById('cambiarContrasenaCampos');
    // if (cambiarContrasenaLink && cambiarContrasenaCampos) {
    //   cambiarContrasenaLink.addEventListener('click', function(e) {
    //     e.preventDefault();
    //     cambiarContrasenaCampos.classList.toggle('visible'); // 'visible' o quita/añade 'hidden'
    //     cambiarContrasenaCampos.classList.toggle('hidden');
    //   });
    // }
  </script>
</body>