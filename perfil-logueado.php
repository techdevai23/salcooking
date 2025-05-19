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

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
// preparamos la consulta
$stmt = $conexion->prepare($sql);
// le pasamos los parametros a la consulta
$stmt->bind_param("i", $id_usuario);
// ejecutamos la consulta
$stmt->execute();
// obtenemos el resultado de la consulta
$resultado = $stmt->get_result();
// obtenemos el resultado de la consulta en forma de array asociativo
$usuario = $resultado->fetch_assoc();
// cerramos la consulta
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

            <div class="form-group edad-group">
              <label for="edad">Edad:</label>
              <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($usuario['edad']); ?>" style="width: 80px; text-align: center;" min="0">
            </div>

            <div class="form-group">
              <label for="ciudad">Ciudad:</label>
              <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($usuario['ciudad']); ?>">
            </div>
           
            <div class="form-group">
              <label for="pais">País:</label>
              <input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($usuario['pais']); ?>">
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

          <!-- Aquí puedes añadir la sección premium si el usuario es premium -->
          <div class="form-actions" style="margin-top:30px;">
            <button type="submit" class="action-btn-verde">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>
</body>