<?php
$css_extra = '';

$css_extra .= '<link rel="stylesheet" href="styles/cambio.css?v=' . filemtime('styles/cambio.css') . '">';
?>



<!-- validar email y  actualizar contraseña -->
<?php
include 'controllers/conexion.php';
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
       $nueva_contrasena = $_POST['nueva-contrasena'];
      $confirmar_contrasena = $_POST['confirmar-contrasena'];
      

    // Verificar si el email existe
    $stmt = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

      if ($resultado->num_rows === 0) {
        $mensaje = '<span style="color: red;">* Lo siento. El email proporcionado no está registrado en el sistema.*</span>';
    } else if ($nueva_contrasena !== $confirmar_contrasena) {
        $mensaje = '<span style="color: red;">* Lo siento. Las contraseñas no coinciden.*</span>';
    } else {
        // Actualizar contraseña
        $usuario = $resultado->fetch_assoc();
        $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $stmt_update = $conexion->prepare("UPDATE usuarios SET contrasena_hash = ? WHERE id_usuario = ?");
        $stmt_update->bind_param("si", $contrasena_hash, $usuario['id_usuario']);
        if ($stmt_update->execute()) {
            header("Location: accion-completada.php?mensaje=contrasena_actualizada");
            exit();
        } else {
            $mensaje = "Error al actualizar la contraseña.";
        }
        $stmt_update->close();
    }
    $stmt->close();
    $conexion->close();
}
?>
<?php include 'header.php'; ?>

<!-- migas -->
<div class="migas-container">
    <div class="container migas-flex">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="perfil-ajustes.php">Perfil-Ajustes</a></li>
            <li class="current">Cambiar Contraseña</li>
        </ul>
        <div class="volver-atras-contenedor">
            <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
        </div>
    </div>
</div>

<!-- Contenido principal-->
<section class="cambio-contrasena-section">
    <div class="contenedor-nombre-landing">
        <div class="titulo">
            <img src="sources/iconos/Lock-Shield--Streamline-Ultimate.svg" alt="Icono cambio contraseña">
            <h1>Cambiar contraseña</h1>
        </div>

        <div class="contenido-landing cambio-contrasena-container">
            <h2 class="instruccion-principal">Por favor introduce un email registrado para cambiar la contraseña</h2>

            <div class="password-requirements">
                <div class="requirements-header">
                    <i class="info-icon">i</i>
                    <span>La contrraseña deberá contener</span>
                </div>
                <ul class="requirements-list">
                    <li class="requirement-met">
                        <span class="check-icon">✓</span>
                        Ser de al menos 8 carácteres
                    </li>
                    <li class="requirement-met">
                        <span class="check-icon">✓</span>
                        Tener al menos 1 letra mayúscula
                    </li>
                    <li class="requirement-met">
                        <span class="check-icon">✓</span>
                        Tener al menos 1 número
                    </li>
                    <li class="requirement-met">
                        <span class="check-icon">✓</span>
                        Tener al menos un caracter especial
                    </li>
                </ul>
            </div>

            <div class="cambio-contrasena-form">
                <?php if (!empty($mensaje)): ?>
                    <div class="mensaje-error"><?php echo $mensaje; ?></div>
                <?php endif; ?>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Introduce tu email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="nueva-contrasena">Nueva contraseña:</label>
                        <input type="password" id="nueva-contrasena" name="nueva-contrasena" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="confirmar-contrasena">Confirma contraseña:</label>
                        <input type="password" id="confirmar-contrasena" name="confirmar-contrasena" class="form-control" required>
                        <a href="#" class="show-password">Muestrame la contraseña</a>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-opciones">Restablecer la contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>