<?php
session_start(); // Siempre al principio

// Si ya está logueado, redirigir a la página de perfil o index
if (isset($_SESSION['id_usuario'])) {
    header("Location: perfil-logueado.php"); // O index.php si prefieres
    exit();
}

include 'controllers/conexion.php'; // Conexión a la BD

$error_login = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_submit'])) {
    $usuario_input = trim($_POST['usuario']); // Puede ser email o nick
    $contrasena_input = trim($_POST['contrasena']);

    if (empty($usuario_input) || empty($contrasena_input)) {
        $error_login = "Por favor, introduce tu usuario y contraseña.";
    } else {
        // Preparamos la consulta para buscar por email o nick
        // Asumiendo que tienes un campo 'nick' en tu tabla 'usuarios'
        $sql = "SELECT id_usuario, nombre_completo, email, nick, contrasena_hash, es_premium FROM usuarios WHERE email = ? OR nick = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $usuario_input, $usuario_input);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $usuario_db = $resultado->fetch_assoc();
                if (password_verify($contrasena_input, $usuario_db['contrasena_hash'])) {
                    // Contraseña correcta, iniciar sesión
                    $_SESSION['id_usuario'] = $usuario_db['id_usuario'];
                    $_SESSION['nombre_completo'] = $usuario_db['nombre_completo'];
                    $_SESSION['email'] = $usuario_db['email'];
                    $_SESSION['nick'] = $usuario_db['nick']; // Guardar nick si existe y se usa
                    $_SESSION['es_premium'] = $usuario_db['es_premium'];

                    // Redirigir a la página de inicio o perfil
                    header("Location: index.php"); // O perfil-logueado.php
                    exit();
                } else {
                    $error_login = "Usuario o contraseña incorrectos.";
                }
            } else {
                $error_login = "Usuario o contraseña incorrectos.";
            }
            $stmt->close();
        } else {
            $error_login = "Error en la preparación de la consulta: " . $conexion->error;
        }
    }
}
$conexion->close();

$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/login.css?v=' . filemtime('styles/login.css') . '">';
?>

<?php include 'header.php'; ?>

<!-- migas -->
<div class="migas-container">
    <div class="container migas-flex">
        <ul class="migas">
            <li><a href="index.php">Inicio</a></li>
            <li class="current">Login</li>
        </ul>
        <div class="volver-atras-contenedor">
            <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
        </div>
    </div>
</div>

<!-- Contenido principal-->
<section class="login-section">
    <div class="contenedor-nombre-landing">
        <div class="titulo">
            <img src="sources/iconos/Dial-Finger-1--Streamline-Ultimate.svg" alt="Icono identificación">
            <h1>Identificación</h1>
        </div>

        <div class="contenido-landing login-container">
            <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <?php if (!empty($error_login)): ?>
                    <div class="mensaje-feedback mensaje-error" style="margin-bottom: 15px;"><?php echo $error_login; ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="usuario">Usuario (Email o Nick):</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Introduce email o nick" class="form-control" required value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" placeholder="Introduce contraseña" class="form-control" required>
                </div>

                <div class="form-options">
                    <div class="remember-option">
                        <input type="checkbox" id="recordar" name="recordar">
                        <label for="recordar">Recuérdame</label>
                    </div>
                    <div class="help-links">
                        <a href="cambio-pass.php" class="forgot-link">Olvidé cómo acceder. Ayúdame</a>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="login_submit" class="btn-entrar">Entrar</button>
                </div>

                <div class="create-account">
                    <a href="perfil.php" class="btn-opciones">Crear Nuevo Usuario</a>
                </div>
            </form>

            <div class="login-logo">
                <a href="index.php"><img src="sources//logos/salcooking-solo-logo- cuadrado.png" alt="SalCooking Logo"></a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>