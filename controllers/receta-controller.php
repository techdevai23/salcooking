<?php
require_once 'models/receta.php';

class RecetaController {
    public function buscar() {
        $termino = $_GET['q'] ?? '';
        
        // Manejar filtros que pueden ser múltiples (vienen como cadenas separadas por comas)
        $tipoPlato = $_GET['tipo_plato'] ?? '';
        $alergeno = $_GET['alergeno'] ?? '';
        $porciones = $_GET['porciones'] ?? '';
        $enfermedad = $_GET['enfermedad'] ?? null;
        $tiempoPrep = $_GET['tiempo'] ?? null;
        
        // Filtros individuales
        $ingrediente = $_GET['ingrediente'] ?? null;
        $orden = $_GET['orden'] ?? '';
        $usarPerfil = $_GET['aplicar_perfil_salud'] ?? null;
        
        // Verificar si el usuario está logueado para funciones premium
        $esPremium = isset($_SESSION['id_usuario']);
        
        // Solo procesar filtros premium si el usuario está logueado
        if (!$esPremium) {
            $ingrediente = null;
            $enfermedad = null;
            $tiempoPrep = null;
            $usarPerfil = null;
        }

        // Debug: Mostrar parámetros recibidos*****************
        error_log("DEBUG - Parámetros de búsqueda: " . print_r($_GET, true));

        $modelo = new Receta();
        $resultados = $modelo->buscarRecetas($termino, $tipoPlato, $alergeno, $porciones, $ingrediente, $enfermedad, $tiempoPrep, $esPremium, $orden, $usarPerfil);

        // Debug: Mostrar número de resultados*****************
        error_log("DEBUG - Número de resultados: " . count($resultados));

        require 'resultado-recetas.php';
    }

    public function verDetalle() {
        $id = $_GET['id'] ?? 0;
        $modelo = new Receta();
        $receta = $modelo->getRecetaPorId($id);
        
        // Si no se encuentra la receta, las siguientes variables no se ejecutarán
        if (!$receta) {
            require 'detalle-receta.php';
            return;
        }
        
        // Incluir conexión para las consultas adicionales
        global $conexion;
        
        // Inicializar variables por si fallan las consultas
        $ingredientes = false;
        $alergias = false;
        $enfermedades = false;
        
        // Obtener ingredientes
        $sqlIngredientes = "SELECT i.nombre, ri.cantidad, ri.fraccion, u.nombre as unidad 
                           FROM receta_ingrediente ri 
                           JOIN ingredientes i ON ri.id_ingrediente = i.id 
                           LEFT JOIN unidades u ON ri.id_unidad = u.id
                           WHERE ri.id_receta = " . intval($id);
        $ingredientes = $conexion->query($sqlIngredientes);
        
        // Debug temporal: mostrar algunos datos de ingredientes
        // if ($ingredientes && $ingredientes->num_rows > 0) {
        //     $ingredientes->data_seek(0); // Volver al inicio
        //     $primeraFila = $ingredientes->fetch_assoc();
        //     echo "<!-- Debug ingrediente: cantidad=" . $primeraFila['cantidad'] . ", tipo=" . gettype($primeraFila['cantidad']) . " -->";
        //     $ingredientes->data_seek(0); // Volver al inicio para el uso normal
        // }
        
        // Verificar si la consulta falló
        if (!$ingredientes) {
            error_log("Error en consulta de ingredientes: " . $conexion->error);
            error_log("SQL: " . $sqlIngredientes);
        }
        
        // Obtener alergias
        $sqlAlergias = "SELECT a.nombre, ra.observaciones 
                       FROM receta_alergia ra 
                       JOIN alergias a ON ra.id_alergia = a.id 
                       WHERE ra.id_receta = " . intval($id);
        $alergias = $conexion->query($sqlAlergias);
        
        // Verificar si la consulta falló
        if (!$alergias) {
            error_log("Error en consulta de alergias: " . $conexion->error);
            error_log("SQL: " . $sqlAlergias);
        }
        
        // Obtener enfermedades (todas para mostrar en detalle)
        $sqlEnfermedades = "SELECT e.nombre, re.indicaciones, re.apta 
                          FROM receta_enfermedad re 
                          JOIN enfermedades e ON re.id_enfermedad = e.id 
                          WHERE re.id_receta = " . intval($id);
        $enfermedades = $conexion->query($sqlEnfermedades);
        
        // Verificar si la consulta falló
        if (!$enfermedades) {
            error_log("Error en consulta de enfermedades: " . $conexion->error);
            error_log("SQL: " . $sqlEnfermedades);
        }
        
        require 'detalle-receta.php';
    }
}
?>
