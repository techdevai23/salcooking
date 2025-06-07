<?php
// Comprobamos si la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si ya está logueado, redirigir a la página de perfil
if (isset($_SESSION['id_usuario'])) {
    header("Location: perfil-logueado.php");
    exit();
}
//  
include 'controllers/conexion.php'; // Conexión a la BD

$error_login = '';

// --- PANTALLA INTERMEDIA SI HAY COOKIE VÁLIDA ---
$bloque_bienvenida = '';
if (!isset($_SESSION['id_usuario']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    include 'controllers/conexion.php';
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE remember_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        if (!isset($_GET['continuar'])) {
            $bloque_bienvenida = "
                <div class='login-saludo'>
                    Hola, <b>" . htmlspecialchars((string)($usuario['nick'] ?? '')) . "</b>.<br>
                    <a href='login.php?olvidar=1' class='login-olvidar-link'>¿No eres tú? Inicia sesión con otra cuenta</a><br><br>
                    <a href='login.php?continuar=1' class='btn-continuar-sesion'>Sí, continuar como " . htmlspecialchars((string)($usuario['nick'] ?? '')) . "</a>
                </div>
            ";
        } else {
            // Si pulsa continuar, inicia sesión y redirige
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['nick'] = $usuario['nick'];
            $_SESSION['es_premium'] = $usuario['es_premium'];
            header("Location: perfil-logueado.php");
            exit();
        }
    }
}

// Mostrar bienvenida si hay cookie y NO hay sesión activa (cookie no válida)
if (!isset($_SESSION['id_usuario']) && isset($_COOKIE['remember_token']) && empty($bloque_bienvenida)) {
    $bloque_bienvenida = "<div class='login-saludo'>Hola, tienes una sesión recordada.<br><a href='login.php?olvidar=1' class='login-olvidar-link'>¿No eres tú? Inicia sesión con otra cuenta</a></div>";
}

// Si el usuario pulsa en "¿No eres tú?", eliminamos la cookie y recargamos la página
if (isset($_GET['olvidar'])) {
    setcookie('remember_token', '', time() - 3600, '/');
    header('Location: login.php');
    exit;
}

// continuamos  comprobando si hay usuario y contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_submit'])) {
    // // DEBUG
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    $usuario_input = trim($_POST['usuario']); // Puede ser email o nick
    $contrasena_input = trim($_POST['contrasena']);
    // si no hay usuario o contraseña, error
    if (empty($usuario_input) || empty($contrasena_input)) {
        $error_login = "Por favor, introduce tu usuario y contraseña.";
    } else {
        // Preparamos la consulta para buscar por email o nick
        // Asumiendo que tienes un campo 'nick' en tu tabla 'usuarios'
        $sql = "SELECT id_usuario, nombre_completo, email, nick, contrasena_hash, es_premium FROM usuarios WHERE email = ? OR nick = ?";
        $stmt = $conexion->prepare($sql);
        // con este if comprobamos si la consulta está preparada 
        if ($stmt) {
            // con este bind_param le pasamos los parametros a la consulta
            $stmt->bind_param("ss", $usuario_input, $usuario_input);
            // con este execute ejecutamos la consulta
            $stmt->execute();
            // con este get_result obtenemos el resultado de la consulta
            $resultado = $stmt->get_result();
            // con este if comprobamos si el resultado de la consulta es 1
            if ($resultado->num_rows === 1) {
                // con este fetch_assoc obtenemos el resultado de la consulta
                $usuario_db = $resultado->fetch_assoc();
                    // // DEBUG
                    // echo '<pre>';
                    // print_r($usuario_db);
                    // echo '</pre>';

                // con este if comprobamos si la contraseña es correcta
                if (password_verify($contrasena_input, $usuario_db['contrasena_hash'])) {
                    // Contraseña correcta, iniciar sesión
                    $_SESSION['id_usuario'] = $usuario_db['id_usuario'];
                    $_SESSION['nombre_completo'] = $usuario_db['nombre_completo'];
                    $_SESSION['email'] = $usuario_db['email'];
                    $_SESSION['nick'] = $usuario_db['nick']; // Guardar nick si existe y se usa
                    $_SESSION['es_premium'] = $usuario_db['es_premium'];

                    // Manejar la opción "Recuérdame"
                    if (isset($_POST['recordar']) && $_POST['recordar'] == 'on') {
                        $token = bin2hex(random_bytes(32)); // Genera token seguro
                        $expiry = time() + (30 * 24 * 60 * 60); // 30 días

                        // Guardar token en la base de datos
                        $stmt = $conexion->prepare("UPDATE usuarios SET remember_token = ?, token_expiry = ? WHERE id_usuario = ?");
                        $stmt->bind_param("ssi", $token, date('Y-m-d H:i:s', $expiry), $usuario_db['id_usuario']);
                        $stmt->execute();

                        // Crear cookie segura
                        setcookie('remember_token', $token, $expiry, '/', '', true, true);
                    }

                    // Redirigir a la página de inicio o perfil
                    if (isset($_SESSION['redirect_after_login'])) {
                        $redirect = $_SESSION['redirect_after_login'];
                        unset($_SESSION['redirect_after_login']);
                        header("Location: " . $redirect);
                    } else {
                        header("Location: perfil-logueado.php");
                    }
                    exit();
                } else {
                    // // DEBUG
                    // echo "Hash en BD: " . $usuario_db['contrasena_hash'] . "<br>";
                    // echo "Contraseña introducida: " . $contrasena_input . "<br>";
                    $error_login = "Lo siento: Usuario o contraseña incorrectos.";
                }
            } else {
                $error_login = "Lo siento: Usuario o contraseña incorrectos.";
            }
            $stmt->close();
        } else {
            $error_login = "Lo siento: Error en la preparación de la consulta: " . $conexion->error;
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
            <?php
            // Mostrar el bloque de bienvenida si corresponde
            if (!empty($bloque_bienvenida)) {
                echo $bloque_bienvenida;
                // Opcional: return; // Si quieres ocultar el formulario cuando hay bienvenida
            }
            ?>
            <form class="login-form" method="POST" action="<?php echo htmlspecialchars((string)($_SERVER["PHP_SELF"] ?? '')); ?>">
                <?php if (!empty($error_login)): ?>
                    <div class="mensaje-feedback mensaje-error" style="margin-bottom: 15px;"><?php echo $error_login; ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="usuario">Usuario (Email o Nick):</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Introduce email o nick" class="form-control" required value="<?php echo isset($_POST['usuario']) ? htmlspecialchars((string)($_POST['usuario'] ?? '')) : ''; ?>">
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