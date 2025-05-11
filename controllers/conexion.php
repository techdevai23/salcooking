<?php
$host = "127.0.0.1";      // o 127.0.0.1
$usuario = "admin";       
$contrasena = "osso";         
$basedatos = "salcooking"; 
$puerto = 3306;

$conexion = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);

// Verificamos la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
// Fuerza el charset para resultados correctos. Muy importante: forzamos UTF-8 para evitar caracteres raros como � o Ã©
$conexion->set_charset("utf8mb4");
?>
