<?php
require_once __DIR__ . '/../controllers/conexion.php';
require_once __DIR__ . '/receta.php';

class Dieta
{
    // Obtiene la última dieta generada por el usuario
    public static function getUltimaDietaUsuario($id_usuario) {
        global $conexion;
        $id_usuario = intval($id_usuario);
        
        // Primero verificamos si el usuario tiene un perfil
        $sql_check = "SELECT id_perfil FROM perfiles WHERE id_usuario = ?";
        $stmt_check = $conexion->prepare($sql_check);
        if (!$stmt_check) {
            error_log("Error en la preparación de la consulta de verificación: " . $conexion->error);
            return null;
        }
        
        $stmt_check->bind_param("i", $id_usuario);
        $stmt_check->execute();
        $resultado_check = $stmt_check->get_result();
        
        if ($resultado_check->num_rows === 0) {
            error_log("El usuario $id_usuario no tiene un perfil");
            return null;
        }
        
        // Si tiene perfil, buscamos su última dieta
        $sql = "SELECT d.id_dieta, d.fecha_creacion 
                FROM dietas d 
                JOIN perfiles p ON d.id_perfil = p.id_perfil
                WHERE p.id_usuario = ? 
                ORDER BY d.fecha_creacion DESC 
                LIMIT 1";
                
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            error_log("Error en la preparación de la consulta de dieta: " . $conexion->error);
            return null;
        }
        
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 0) {
            return null;
        }
        
        return $resultado->fetch_assoc();
    }

    // Alias para compatibilidad con el código existente
    public static function obtenerDietaUsuario($id_usuario) {
        return self::getUltimaDietaUsuario($id_usuario);
    }

    // Obtiene los IDs de alergias del usuario
    public static function getAlergiasUsuario($id_usuario) {
        global $conexion;
        $sql = "SELECT id_alergia FROM usuario_alergia WHERE id_usuario = $id_usuario";
        $res = $conexion->query($sql);
        $alergias = [];
        while ($row = $res->fetch_assoc()) {
            $alergias[] = $row['id_alergia'];
        }
        return $alergias;
    }

    // Obtiene los IDs de enfermedades del usuario
    public static function getEnfermedadesUsuario($id_usuario) {
        global $conexion;
        $sql = "SELECT id_enfermedad FROM usuario_enfermedad WHERE id_usuario = $id_usuario";
        $res = $conexion->query($sql);
        $enfermedades = [];
        while ($row = $res->fetch_assoc()) {
            $enfermedades[] = $row['id_enfermedad'];
        }
        return $enfermedades;
    }

    // Obtiene recetas aptas para el usuario (sin alergias ni enfermedades prohibidas)
    public static function getRecetasAptas($alergias, $enfermedades) {
        global $conexion;
        $condiciones = [];

        if (!empty($alergias)) {
            $alergiasStr = implode(',', array_map('intval', $alergias));
            $condiciones[] = "r.id NOT IN (SELECT id_receta FROM receta_alergia WHERE id_alergia IN ($alergiasStr))";
        }
        if (!empty($enfermedades)) {
            $enfermedadesStr = implode(',', array_map('intval', $enfermedades));
            $condiciones[] = "r.id NOT IN (SELECT id_receta FROM receta_enfermedad WHERE id_enfermedad IN ($enfermedadesStr) AND apta = 0)";
        }

        $where = count($condiciones) ? "WHERE " . implode(' AND ', $condiciones) : "";
        $sql = "SELECT r.id, r.nombre, r.tipo_plato, r.imagen FROM recetas r $where";
        $res = $conexion->query($sql);

        $recetas = [];
        while ($row = $res->fetch_assoc()) {
            $recetas[] = $row;
        }
        return $recetas;
    }

    // Genera el plan semanal aleatorio, sin repeticiones salvo necesidad
    public static function generarPlanSemanal($recetasAptas) {
        $tiposPlato = ['Desayuno', 'Entrante', 'Principal', 'Postre', 'Cena'];
        $diasSemana = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];

        // Agrupar recetas por tipo
        $recetasPorTipo = [];
        foreach ($tiposPlato as $tipo) {
            $recetasPorTipo[$tipo] = array_filter($recetasAptas, fn($receta) => $receta['tipo_plato'] === $tipo);
        }

        $plan = [];
        $usadas = [];

        foreach ($diasSemana as $dia) {
            foreach ($tiposPlato as $tipo) {
                // Recetas no usadas aún para ese tipo
                $disponibles = array_filter($recetasPorTipo[$tipo], fn($receta) => !in_array($receta['id'], $usadas));
                if (empty($disponibles)) {
                    // Si no hay más, permitimos repetición
                    $disponibles = $recetasPorTipo[$tipo];
                }
                if (!empty($disponibles)) {
                    $receta = $disponibles[array_rand($disponibles)];
                    $plan[$dia][$tipo] = $receta;
                    $usadas[] = $receta['id'];
                } else {
                    $plan[$dia][$tipo] = null;
                }
            }
        }
        return $plan;
    }

    // Guarda la dieta y las recetas asignadas
    public static function crearYGuardarDieta($id_usuario, $plan) {
        global $conexion;
        // Crear dieta
        $sql = "INSERT INTO dietas (id_usuario, nombre_dieta, tipo, fecha_creacion) VALUES ($id_usuario, 'Dieta personalizada', 'Semanal', NOW())";
        $conexion->query($sql);
        $id_dieta = $conexion->insert_id;

        // Guardar recetas asignadas
        foreach ($plan as $dia => $tipos) {
            foreach ($tipos as $tipo => $receta) {
                if ($receta !== null) {
                    $id_receta = $receta['id'];
                    $sql = "INSERT INTO dieta_receta (id_dieta, id_receta, comida, dia_semana) VALUES ($id_dieta, $id_receta, '$tipo', '$dia')";
                    $conexion->query($sql);
                }
            }
        }
        return $id_dieta;
    }

    // Recupera el plan de una dieta para mostrarlo (con nombre, imagen, etc)
    public static function getPlanDieta($id_dieta) {
        global $conexion;
        $sql = "SELECT dr.comida, dr.dia_semana, r.nombre, r.imagen
                FROM dieta_receta dr
                JOIN recetas r ON dr.id_receta = r.id
                WHERE dr.id_dieta = $id_dieta";
        $res = $conexion->query($sql);
        $plan = [];
        while ($row = $res->fetch_assoc()) {
            $plan[$row['dia_semana']][$row['comida']] = [
                'nombre' => $row['nombre'],
                'imagen' => $row['imagen']
            ];
        }
        return $plan;
    }
}