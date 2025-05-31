<?php
$host = "127.0.0.1";      // o 127.0.0.1
$usuario = "admin";       
$contrasena = "osso";         
$basedatos = "salcooking"; 
$puerto = 3306;

// Intentar conexión con opciones adicionales
$conexion = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);

// Si falla, intentar con el método de autenticación antiguo
if ($conexion->connect_error) {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conexion = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);
    
    // Configurar el método de autenticación
    $conexion->query("SET SESSION sql_mode = ''");
    $conexion->query("SET SESSION authentication_plugin = 'mysql_native_password'");
}

// Verificamos la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Fuerza el charset para resultados correctos. Muy importante: forzamos UTF-8 para evitar caracteres raros como o Ã©
$conexion->set_charset("utf8mb4");
?>
