<?php
// Configuración de conexión a la base de datos adaptativa

$modo = 'remoto'; // Cambia a 'local' si estás trabajando en XAMPP

if ($modo === 'local') {
    $host = "127.0.0.1";
    $usuario = "root";
    $contrasena = "";
    $basedatos = "salcooking";
    $puerto = 3306;
} else {
    $host = "sql305.infinityfree.com";
    $usuario = "if0_38954546";
    $contrasena = "Infi20252025";  // tu contraseña real del panel InfinityFree
    $basedatos = "if0_38954546_salcooking_db";
    $puerto = 3306;
}

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);


// Comprobar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");
// echo "Conexión exitosa";
?>

