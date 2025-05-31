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
                <button type="button" id="validarCodigoBtn" title="Aplicar Código" class="premium-button">➤</button>
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
                  <label for="intolerancias">Alérgenos</label>
                  <select id="intolerancias" name="intolerancias[]" multiple size="6">
                    <?php foreach ($todas_alergias as $alergia): ?>
                      <option value="<?php echo $alergia['id']; ?>"
                        <?php echo in_array($alergia['id'], array_column($alergias_usuario, 'id')) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($alergia['nombre']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="enfermedades">Enfermedades</label>
                  <select id="enfermedades" name="enfermedades[]" multiple size="6">
                    <?php foreach ($todas_enfermedades as $enfermedad): ?>
                      <option value="<?php echo $enfermedad['id']; ?>"
                        <?php echo in_array($enfermedad['id'], array_column($enfermedades_usuario, 'id')) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($enfermedad['nombre']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <button type="button" class="action-btn-naranja">Generar dieta semanal</button>
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


          <!-- <div class="form-actions" style="margin-top:30px;">
            <button type="submit" class="action-btn-verde">Guardar cambios</button>
          </div> -->
        </form>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>

  <script>
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
  </script>
</body>