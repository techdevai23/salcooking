<?php
// Asegurarnos de que no haya salida antes
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();
include 'conexion.php';

// Limpiar cualquier salida anterior
ob_clean();

// Verificar la conexión
if (!isset($conexion) || !$conexion) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

$codigo = trim($_POST['codigo'] ?? '');

if (empty($codigo)) {
    echo json_encode(['success' => false, 'message' => 'Código no proporcionado']);
    exit();
}

try {
    // Insertar el código en la base de datos
    $sql = "INSERT INTO codigos_premium (codigo) VALUES (?)";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
    }
    
    $stmt->bind_param("s", $codigo);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }
    
    echo json_encode(['success' => true, 'message' => 'Código premium guardado correctamente']);
    
} catch (Exception $e) {
    error_log("Error en guardar-codigo-premium.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error al guardar el código premium: ' . $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conexion)) {
        $conexion->close();
    }
}
?> 