<?php
session_start();
require_once __DIR__ . '/models/usuario.php';
require_once __DIR__ . '/models/dieta.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$usuarioModel = new Usuario();
$usuario = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);

// Verificar si el usuario es premium
if (!$usuario || $usuario['es_premium'] != 1) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Se requiere cuenta premium']);
    exit;
}

try {
    // Obtener alergias y enfermedades del usuario
    $alergias = Dieta::getAlergiasUsuario($_SESSION['usuario_id']);
    $enfermedades = Dieta::getEnfermedadesUsuario($_SESSION['usuario_id']);
    
    // Obtener recetas aptas
    $recetasAptas = Dieta::getRecetasAptas($alergias, $enfermedades);
    
    if (empty($recetasAptas)) {
        throw new Exception('No hay suficientes recetas disponibles para generar una dieta con tus preferencias actuales.');
    }
    
    // Generar plan semanal
    $planSemanal = Dieta::generarPlanSemanal($recetasAptas);
    
    // Guardar la dieta
    $idDieta = Dieta::crearYGuardarDieta($_SESSION['usuario_id'], $planSemanal);
    
    // Redirigir a la página de la dieta
    header('Content-Type: application/json');
    echo json_encode(['redirect' => 'dieta-semana-por-dias.php']);
    
} catch (Exception $e) {
    // En caso de error, devolver mensaje de error
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
