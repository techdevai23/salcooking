<?php
require_once __DIR__ . '/../controllers/conexion.php';

require_once __DIR__ . '/receta.php';

class Dieta
{
    // Obtiene la última dieta generada por el usuario
    public static function getUltimaDietaUsuario($id_usuario)
    {
        global $conexion;
        $id_usuario = intval($id_usuario);
        $sql = "SELECT id_dieta, fecha_creacion FROM dietas WHERE id_usuario = ? ORDER BY fecha_creacion DESC LIMIT 1";
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
    public static function obtenerDietaUsuario($id_usuario)
    {
        return self::getUltimaDietaUsuario($id_usuario);
    }

    // Obtiene las alergias del usuario con sus nombres
    public static function getAlergiasUsuario($id_usuario)
    {
        global $conexion;
        $sql = "SELECT a.id, a.nombre 
                FROM alergias a 
                JOIN usuario_alergia ua ON a.id = ua.id_alergia 
                WHERE ua.id_usuario = $id_usuario";
        $res = $conexion->query($sql);
        $alergias = [];
        while ($row = $res->fetch_assoc()) {
            $alergias[] = [
                'id' => $row['id'],
                'nombre' => $row['nombre']
            ];
        }
        return $alergias;
    }

    // Obtiene las enfermedades del usuario con sus nombres
    public static function getEnfermedadesUsuario($id_usuario)
    {
        global $conexion;
        $sql = "SELECT e.id, e.nombre 
                FROM enfermedades e 
                JOIN usuario_enfermedad ue ON e.id = ue.id_enfermedad 
                WHERE ue.id_usuario = $id_usuario";
        $res = $conexion->query($sql);
        $enfermedades = [];
        while ($row = $res->fetch_assoc()) {
            $enfermedades[] = [
                'id' => $row['id'],
                'nombre' => $row['nombre']
            ];
        }
        return $enfermedades;
    }

    // Obtiene recetas aptas para el usuario (sin alergias ni enfermedades prohibidas)
    public static function getRecetasAptas($alergias, $enfermedades)
    {
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
        $sql = "SELECT r.id, r.nombre, r.tipo_plato FROM recetas r $where";

        // // debug**************
        // echo '<pre>';
        // var_dump($sql);
        // echo '</pre>';

        $res = $conexion->query($sql);
        if ($res === false) {
            error_log("Error en la consulta getRecetasAptas: " . $conexion->error . " | SQL: $sql");
            return [];
        }
        $recetas = [];
        while ($row = $res->fetch_assoc()) {
            $recetas[] = $row;
        }
        foreach ($recetas as $receta) {
            echo $receta['id'] . ' - ' . $receta['nombre'] . ' - ' . $receta['tipo_plato'] . '<br>';
        }
        return $recetas;
    }

    // Genera el plan semanal aleatorio, sin repeticiones salvo necesidad
    public static function generarPlanSemanal($recetasAptas)
    {
        $tiposPlato = ['Desayuno', 'Entrante', 'Principal', 'Postre', 'Cena'];
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        // Agrupar recetas por tipo
        $recetasPorTipo = [];
        $tiposFaltantes = [];
        foreach ($tiposPlato as $tipo) {
            $recetasPorTipo[$tipo] = array_filter($recetasAptas, fn($receta) => trim($receta['tipo_plato']) === $tipo);
            if (count($recetasPorTipo[$tipo]) === 0) {
                $tiposFaltantes[] = $tipo;
            }
        }

        if (!empty($tiposFaltantes)) {
            $mensaje = "No hay recetas aptas para los siguientes tipos de plato: " . implode(', ', $tiposFaltantes);
            error_log($mensaje);
            // También puedes lanzar una excepción para mostrarlo en la web:
            throw new Exception($mensaje);
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
        // // debug**************
        // echo '<pre>';
        // var_dump($plan);
        // var_dump($recetasAptas);
        // echo '</pre>';


        return $plan;
    }

    // Guarda la dieta y las recetas asignadas
    public static function crearYGuardarDieta($id_usuario, $plan)
    {
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
    public static function getPlanDieta($id_dieta)
    {
        global $conexion;
        $sql = "SELECT dr.comida, dr.dia_semana, r.id, r.nombre
                FROM dieta_receta dr
                JOIN recetas r ON dr.id_receta = r.id
                WHERE dr.id_dieta = $id_dieta";
        $res = $conexion->query($sql);
        $plan = [];
        while ($row = $res->fetch_assoc()) {
            $plan[$row['dia_semana']][$row['comida']] = [
                'id' => $row['id'],
                'nombre' => $row['nombre']
            ];
        }
        return $plan;
    }
}
?>