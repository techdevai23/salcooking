
<?php
require_once __DIR__ . '/../models/dieta.php';

class DietaController
{
    // Genera una dieta semanal personalizada para el usuario logueado y la muestra
    public function generarYMostrarDieta() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            // Redirige a login si no está logueado
            header('Location: login.php');
            exit;
        }
        $id_usuario = $_SESSION['id_usuario'];

        // 1. Obtener alergias y enfermedades del usuario
        $alergias = Dieta::getAlergiasUsuario($id_usuario);
        $enfermedades = Dieta::getEnfermedadesUsuario($id_usuario);

        // 2. Obtener recetas aptas
        $recetasAptas = Dieta::getRecetasAptas($alergias, $enfermedades);

        // 3. Generar plan semanal aleatorio sin repeticiones
        $plan = Dieta::generarPlanSemanal($recetasAptas);

        // 4. Guardar la dieta y las relaciones en la BD
        $id_dieta = Dieta::crearYGuardarDieta($id_usuario, $plan);

        // 5. Recuperar el plan para mostrarlo (nombre e imagen)
        $planDieta = Dieta::getPlanDieta($id_dieta);

        // 6. Pasar datos a la vista
        include __DIR__ . '/../dieta-semana-por-dias.php';
    }

    // Muestra una dieta ya generada (por ejemplo, desde el historial)
    public function verDieta($id_dieta) {
        $planDieta = Dieta::getPlanDieta($id_dieta);
        include __DIR__ . '/../dieta-semana-por-dias.php';
    }
}
?>