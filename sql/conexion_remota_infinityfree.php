<?php
$host = "127.0.0.1";      // o 127.0.0.1
$usuario = "admin";       
$contrasena = "osso";         
$basedatos = "recooking"; 
$puerto = 3306;

$conexion = new mysqli('sql305.infinityfree.com', 'if0_38954546', '************', 'if0_38954546_XXX');

// Verificamos la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
// Fuerza el charset para resultados correctos. Muy importante: forzamos UTF-8 para evitar caracteres raros como � o Ã©
$conexion->set_charset("utf8mb4");
?>
