<?php
session_start();
include 'controllers/conexion.php';

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

// Insertar el código en la base de datos
$sql = "INSERT INTO codigos_premium (codigo) VALUES (?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $codigo);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Código premium guardado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el código premium']);
}

$stmt->close();
$conexion->close();
?> 