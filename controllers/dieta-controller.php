<?php
require_once __DIR__ . '/../models/dieta.php';
require_once __DIR__ . '/../models/usuario.php';

class DietaController
{
    // Muestra la página principal de dieta
    public function index() {
        session_start();
        
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['id_usuario'])) {
            $_SESSION['redirect_after_login'] = 'dieta-semana-por-dias.php';
            header('Location: login.php?redirect=dieta');
            exit;
        }
        
        $id_usuario = $_SESSION['id_usuario'];
        $usuario = Usuario::getUsuarioById($id_usuario);
        
        // Verificar si el usuario es premium
        if (!$usuario || !$usuario['es_premium']) {
            $this->mostrarVistaNoPremium();
            return;
        }
        
        // Verificar si ya tiene una dieta generada
        $dieta_actual = Dieta::getUltimaDietaUsuario($id_usuario);
        
        if ($dieta_actual) {
            // Mostrar la dieta existente con el perfil de salud aplicado
            if (!isset($_GET['aplicar_perfil_salud'])) {
                // Si no está presente el parámetro, redirigir para incluirlo
                header('Location: dieta-semana-por-dias.php?aplicar_perfil_salud=1');
                exit;
            }
            $this->mostrarDieta($dieta_actual['id_dieta']);
        } else {
            // Mostrar pantalla de bienvenida para generar la primera dieta
            $this->mostrarPrimeraVez();
        }
    }
    
    // Genera una nueva dieta para el usuario
    public function generarNuevaDieta() {
        session_start();
        
        if (!isset($_SESSION['id_usuario'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }
        
        $id_usuario = $_SESSION['id_usuario'];
        $usuario = Usuario::getUsuarioById($id_usuario);
        
        if (!$usuario || !$usuario['es_premium']) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['error' => 'Se requiere cuenta premium']);
            exit;
        }
        
        // 1. Obtener alergias y enfermedades del usuario
        $alergias = Dieta::getAlergiasUsuario($id_usuario);
        $enfermedades = Dieta::getEnfermedadesUsuario($id_usuario);

        // 2. Obtener recetas aptas
        $recetasAptas = Dieta::getRecetasAptas($alergias, $enfermedades);

        if (empty($recetasAptas)) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'No hay recetas disponibles con tus preferencias actuales']);
            exit;
        }

        // 3. Generar plan semanal aleatorio sin repeticiones
        $plan = Dieta::generarPlanSemanal($recetasAptas);

        // 4. Guardar la dieta y las relaciones en la BD
        $id_dieta = Dieta::crearYGuardarDieta($id_usuario, $plan);

        if ($id_dieta) {
            echo json_encode([
                'success' => true,
                'redirect' => 'dieta-semana-por-dias.php?generada=1&aplicar_perfil_salud=1'
            ]);
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error al generar la dieta']);
        }
    }
    
    // Muestra una dieta específica
    public function verDieta($id_dieta) {
        $planDieta = Dieta::getPlanDieta($id_dieta);
        
        if (empty($planDieta)) {
            $this->mostrarError('No se encontró la dieta solicitada');
            return;
        }
        
        // Pasar el parámetro aplicar_perfil_salud a la vista
        $aplicar_perfil_salud = isset($_GET['aplicar_perfil_salud']) && $_GET['aplicar_perfil_salud'] == '1';
        include __DIR__ . '/../dieta-semana-por-dias.php';
    }
    
    // Muestra la pantalla para usuarios no premium
    private function mostrarVistaNoPremium() {
        include __DIR__ . '/../vistas/dieta/no-premium.php';
    }
    
    // Muestra la pantalla de bienvenida para generar la primera dieta
    private function mostrarPrimeraVez() {
        include __DIR__ . '/../vistas/dieta/primera-vez.php';
    }
    
    // Muestra una dieta específica
    private function mostrarDieta($id_dieta) {
        $planDieta = Dieta::getPlanDieta($id_dieta);
        // Pasar el parámetro aplicar_perfil_salud a la vista
        $aplicar_perfil_salud = isset($_GET['aplicar_perfil_salud']) && $_GET['aplicar_perfil_salud'] == '1';
        include __DIR__ . '/../dieta-semana-por-dias.php';
    }
    
    // Muestra un mensaje de error
    private function mostrarError($mensaje) {
        $error = $mensaje;
        include __DIR__ . '/../vistas/error.php';
    }
}
?>