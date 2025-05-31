<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "127.0.0.1";
$usuario = "root";
$contrasena = "";
$puerto = 3306;

try {
    $conexion = new mysqli($host, $usuario, $contrasena);
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Verificar información del sistema
    $queries = [
        "SHOW VARIABLES LIKE 'datadir'",
        "SHOW VARIABLES LIKE 'innodb_force_recovery'",
        "SHOW DATABASES",
        "SELECT SCHEMA_NAME, DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME 
         FROM information_schema.SCHEMATA"
    ];
    
    foreach ($queries as $query) {
        $result = $conexion->query($query);
        if ($result) {
            error_log("Resultados de '$query':");
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                error_log(print_r($row, true));
            }
        }
    }
    
    return $conexion;
    
} catch (Exception $e) {
    error_log("Error detallado: " . $e->getMessage());
    die("<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px;'>
         Error de conexión. Detalles en el log.</div>");
}