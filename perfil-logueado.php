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

// recuperamos todos los datos de la tabla usuarios
$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";

// preparamos la consulta para prevenir inyecciones SQL
$stmt = $conexion->prepare($sql);
if (!$stmt) {
  die("Error al preparar la consulta: " . $conexion->error);
}

// le pasamos los parametros a la consulta con bind_param
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();
$stmt->close();
$conexion->close();

$nombre_pagina = "Mi Perfil";
$mensaje_feedback = '';
$tipo_mensaje = '';

$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/perfil-ajustes.css?v=' . filemtime('styles/perfil-ajustes.css') . '">';
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

      <div class="contenido-Perfil-Ajustes">
        <?php if (!empty($mensaje_feedback)): ?>
          <div class="mensaje-feedback <?php echo $tipo_mensaje; ?>"><?php echo $mensaje_feedback; ?></div>
        <?php endif; ?>

        <form id="perfilForm" method="POST" action="actualizar-perfil.php">
          <div class="perfil-form-grid">
            <div class="form-group">
              <label for="nombre_completo">Nombre Completo: <span class="required">*</span></label>
              <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars($usuario['nombre_completo']); ?>" required>
            </div>

            <div class="form-group">
              <label for="nick">Nick: <span class="required">*</span></label>
              <input type="text" id="nick" name="nick" value="<?php echo htmlspecialchars($usuario['nick']); ?>" required>
            </div>

            <div class="form-group">
              <label for="email">Email: <span class="required">*</span></label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>

            <div class="form-group">
              <label for="direccion">Dirección:</label>
              <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>">
            </div>

            <div class="form-group">
              <label for="ciudad">Ciudad:</label>
              <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($usuario['ciudad']); ?>">
            </div>


            <div class="form-group">
              <label for="pais">País:</label>
              <input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($usuario['pais']); ?>">
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
              <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Nueva contraseña">
            </div>
            <div class="form-group">
              <label for="confirmar_contrasena">Confirmar nueva contraseña:</label>
              <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar nueva contraseña">
            </div>
            <!-- Fin sección de cambio de contraseña -->
          </div>

        

          <!-- SECCIÓN PREMIUM (como en la imagen) -->

          <div class="form-group registro-codigo-group" style="max-width: 800px;">
            <div style="margin-top: 30px; margin-bottom: 20px;">
              <button type="button" class="action-btn-rosa" style="padding: 10px 20px !important;">Hazte Prémium</button>
            </div>

            <label for="codigo_registro" style="white-space: nowrap; margin-bottom:0; margin-right: 10px;">Código de registro:</label>
            <input type="text" id="codigo_registro" name="codigo_registro" placeholder="">
            <button type="button" title="Aplicar Código" style="background: #ccc; border:1px solid #999; color: #333; padding: 8px 12px; font-size: 1.2rem; cursor:pointer;">➤</button>
          </div>


          <div class="premium-section" style="margin-top:30px;">
            <h3>
              Opciones Prémium
              <img src="sources/iconos/info_icon.svg" alt="info" class="info-icon" title="Funcionalidades exclusivas para usuarios Prémium" style="width:20px; height:20px;">
              <!-- Reemplaza 'info_icon.svg' con un icono real -->
            </h3>
            <div class="premium-options-grid">
              <div class="form-group">
                <label for="intolerancias">Intolerancias</label>
                <select id="intolerancias" name="intolerancias[]" multiple style="min-height: 100px;">
                  <option selected>Gluten</option>
                  <option>Frutos secos</option>
                  <option selected>Pescados</option>

                </select>
              </div>
              <div class="form-group">
                <label for="enfermedades">Enfermedades</label>
                <select id="enfermedades" name="enfermedades[]" multiple style="min-height: 100px;">
                  <option>Colesterol</option>
                  <option selected>Diabetes</option>

                </select>
              </div>
            </div>
            <button type="button" class="action-btn-naranja" style="margin-top:20px; padding: 10px 20px !important;">Generar dieta semanal</button>
          </div>

          <div class="form-actions" style="margin-top:30px;">
            <button type="submit" name="accion" value="guardar_cambios" class="action-btn-verde" style="background-color: #2D3E2E; color: white; padding: 12px 30px !important; font-size: 1.1rem;">
              Actualizar datos
            </button>
          </div>


          <!-- <div class="form-actions" style="margin-top:30px;">
            <button type="submit" class="action-btn-verde">Guardar cambios</button>
          </div> -->
        </form>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>
</body>