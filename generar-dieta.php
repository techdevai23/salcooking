<?php
session_start();
require_once __DIR__ . '/models/usuario.php';
require_once __DIR__ . '/models/dieta.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado. Por favor, inicia sesión.']);
    exit;
}

$usuarioModel = new Usuario();
$usuario = $usuarioModel->obtenerPorId($_SESSION['id_usuario']);

// Verificar si el usuario es premium
if (!$usuario) {
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(['error' => 'Usuario no encontrado']);
    exit;
}

if ($usuario['es_premium'] != 1) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['error' => 'Se requiere cuenta premium para acceder a esta función']);
    exit;
}

try {
    // Verificar si ya existe una dieta generada
    $dietaExistente = Dieta::getUltimaDietaUsuario($_SESSION['id_usuario']);
    
    if ($dietaExistente) {
        // Si ya existe una dieta, redirigir directamente
        header('Content-Type: application/json');
        echo json_encode(['redirect' => 'dieta-semana-por-dias.php']);
        exit;
    }
    
    // Obtener alergias y enfermedades del usuario
    $alergias = Dieta::getAlergiasUsuario($_SESSION['id_usuario']);
    $enfermedades = Dieta::getEnfermedadesUsuario($_SESSION['id_usuario']);
    
    // Obtener recetas aptas
    $recetasAptas = Dieta::getRecetasAptas($alergias, $enfermedades);
    
    if (empty($recetasAptas)) {
        throw new Exception('No hay suficientes recetas disponibles para generar una dieta con tus preferencias actuales.');
    }
    
    // Generar plan semanal
    $planSemanal = Dieta::generarPlanSemanal($recetasAptas);
    
    if (empty($planSemanal)) {
        throw new Exception('No se pudo generar el plan semanal. Por favor, inténtalo de nuevo.');
    }
    
    // Guardar la dieta
    $idDieta = Dieta::crearYGuardarDieta($_SESSION['id_usuario'], $planSemanal);
    
    if (!$idDieta) {
        throw new Exception('Error al guardar la dieta. Por favor, inténtalo de nuevo.');
    }
    
    // Devolver éxito con redirección
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'redirect' => 'dieta-semana-por-dias.php',
        'message' => '¡Dieta generada con éxito!'
    ]);
    
} catch (Exception $e) {
    // En caso de error, devolver mensaje de error
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
