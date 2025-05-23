<?php
session_start(); // Acceder a la sesión

// Eliminar cookie "Recuérdame"
if (isset($_COOKIE['remember_token'])) {
    include 'controllers/conexion.php';
    $token = $_COOKIE['remember_token'];
    
    // Limpiar token en la base de datos
    $stmt = $conexion->prepare("UPDATE usuarios SET remember_token = NULL, token_expiry = NULL WHERE remember_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    
    // Eliminar cookie
    setcookie('remember_token', '', time() - 3600, '/');
}

// Destruir todas las variables de sesión.
$_SESSION = array();
// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Finalmente, destruir la sesión.
session_destroy();

// Redirigir a la página de inicio
header("Location: index.php");
exit();
?>