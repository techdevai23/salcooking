<?php
session_start();
include 'controllers/conexion.php';

header('Content-Type: application/json');

// este archivo se encarga de validar el código premium y actualizar el usuario a premium

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}
// si el método no es POST, se devuelve un error, ya que es una petición AJAX
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

$codigo = trim($_POST['codigo'] ?? '');

if (empty($codigo)) {
    echo json_encode(['success' => false, 'message' => 'Código no proporcionado']);
    exit();
}

// Verificar el código premium si existe y no está usado en la base de datos
$sql_codigo = "SELECT id_codigo, usado FROM codigos_premium WHERE codigo = ? AND usado = FALSE";
$stmt_codigo = $conexion->prepare($sql_codigo);
$stmt_codigo->bind_param("s", $codigo);
$stmt_codigo->execute();
$resultado_codigo = $stmt_codigo->get_result();

// si el código no existe o ya está usado, se devuelve un error
if ($resultado_codigo->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Código premium inválido o ya utilizado']);
    exit();
}

// Iniciar transacción para que se realice la actualización de los datos de manera individual y si falla, se revierte
$conexion->begin_transaction();

try {
    $id_usuario = $_SESSION['id_usuario'];
    
    // Actualizar el código como usado
    // esta query es compleja, ya que se actualiza el código como usado y se guarda el id_usuario y la fecha de uso
    $sql_update_codigo = "UPDATE codigos_premium SET usado = TRUE, id_usuario = ?, fecha_uso = NOW() WHERE codigo = ?";
    $stmt_update_codigo = $conexion->prepare($sql_update_codigo);
    $stmt_update_codigo->bind_param("is", $id_usuario, $codigo);
    $stmt_update_codigo->execute();

    // Actualizar el usuario a premium
    $sql_update_usuario = "UPDATE usuarios SET es_premium = 1 WHERE id_usuario = ?";
    $stmt_update_usuario = $conexion->prepare($sql_update_usuario);
    $stmt_update_usuario->bind_param("i", $id_usuario);
    $stmt_update_usuario->execute();

    // Confirmar transacción
    $conexion->commit();
    
    $_SESSION['es_premium'] = 1; // Actualizar la sesión para que se guarde el estado de premium 
    //  y pueda acceder a las funciones premium de toda la web
    echo json_encode(['success' => true, 'message' => '¡Felicidades! Ahora eres usuario premium']);
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conexion->rollback();
    echo json_encode(['success' => false, 'message' => 'Error al procesar el código premium']);
}

$stmt_codigo->close();
$conexion->close();
?> 