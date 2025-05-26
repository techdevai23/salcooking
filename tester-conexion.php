<?php
// Datos de conexión
$host = "127.0.0.1";       // o 127.0.0.1
$usuario = "admin";         // El mismo que en HeidiSQL
$contrasena = "osso";  // La misma que en HeidiSQL
$basedatos = "salcooking";    // El nombre correcto de tu base de datos
$puerto = 3306;              // Estás usando el puerto estándar

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);

// Comprobar conexión
if ($conexion->connect_error) {
    die("<h2 style='color:red;'>❌ Conexión fallida:</h2> " . $conexion->connect_error);
} else {
    echo "<h2 style='color:green;'>✅ Conexión exitosa a la base de datos '$basedatos' en $host:$puerto.</h2>";
}

$conexion->set_charset("utf8mb4");
$conexion->close();
?>
