<?php
// Configuración de la conexión
$host = "127.0.0.1";      // o localhost
$usuario = "admin";       // Usuario correcto que funciona en HeidiSQL
$contrasena = "osso";     // Contraseña correcta que funciona en HeidiSQL
$basedatos = "salcooking"; 
$puerto = 3306;

// Configurar el reporte de errores de MySQL
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Intentar conexión con timeout
    $conexion = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);
    
    // Configurar timeout de conexión
    $conexion->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
    
    // Configurar el charset
    $conexion->set_charset("utf8mb4");
    
    // Verificar la conexión
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Verificar que la base de datos existe
    $result = $conexion->query("SELECT DATABASE()");
    if (!$result) {
        throw new Exception("Error al verificar la base de datos");
    }
    
} catch (Exception $e) {
    // Log del error
    error_log("Error de conexión a la base de datos: " . $e->getMessage());
    
    // Intentar reconexión con credenciales alternativas
    try {
        $conexion = new mysqli($host, "root", "", $basedatos, $puerto);
        $conexion->set_charset("utf8mb4");
        
        if ($conexion->connect_error) {
            throw new Exception("Error en reconexión: " . $conexion->connect_error);
        }
    } catch (Exception $e2) {
        // Si falla la reconexión, mostrar mensaje amigable
        die("Lo sentimos, estamos experimentando problemas técnicos. Por favor, inténtalo de nuevo en unos minutos.");
    }
}
?>
