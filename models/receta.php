<?php
class Receta
{
    public function buscarRecetas($termino, $tipoPlato, $alergeno, $porciones, $ingrediente, $enfermedad, $tiempoPrep, $esPremium, $orden = '', $usarPerfil = null)
    {
        global $conexion;
        
        // Debug: MÉTODO buscarRecetas EJECUTÁNDOSE
        error_log("MÉTODO buscarRecetas EJECUTÁNDOSE");

        $stopwords = ['de', 'la', 'el', 'y', 'con', 'en', 'a', 'una', 'para'];
        $palabras = array_filter(explode(' ', strtolower($termino)), fn($w) => !in_array($w, $stopwords));

        $condiciones = [];

        // Filtro por término de búsqueda
        if (!empty($palabras)) {
            foreach ($palabras as $palabra) {
                $palabra = $conexion->real_escape_string($palabra);
                $condiciones[] = "r.nombre LIKE '%$palabra%'";
            }
        }

        // Filtros básicos
        if ($tipoPlato && $tipoPlato !== '') {
            // Manejar múltiples tipos de plato separados por comas
            $tipos = explode(',', $tipoPlato);
            $tiposEscapados = array_map(function ($tipo) use ($conexion) {
                return "'" . $conexion->real_escape_string(trim($tipo)) . "'";
            }, $tipos);
            $condiciones[] = "r.tipo_plato IN (" . implode(',', $tiposEscapados) . ")";
        }

        if ($alergeno && $alergeno !== '') {
            // Manejar múltiples alérgenos separados por comas
            $alergenos = explode(',', $alergeno);
            $alergenosInt = array_map('intval', $alergenos);
            $alergenosStr = implode(',', $alergenosInt);
            $condiciones[] = "r.id NOT IN (SELECT id_receta FROM receta_alergia WHERE id_alergia IN ($alergenosStr))";
        }

        if ($porciones && $porciones !== '') {
            // Manejar múltiples opciones de porciones
            $opcionesPorciones = explode(',', $porciones);
            $condicionesPorciones = [];

            foreach ($opcionesPorciones as $opcion) {
                $opcion = trim($opcion);
                if ($opcion == 'mas-4') {
                    $condicionesPorciones[] = "r.porciones > 4";
                } else {
                    $opcionInt = intval($opcion);
                    $condicionesPorciones[] = "r.porciones = $opcionInt";
                }
            }

            if (!empty($condicionesPorciones)) {
                $condiciones[] = "(" . implode(" OR ", $condicionesPorciones) . ")";
            }
        }

        /************* Filtros premium (solo si el usuario está logueado) *****************/
        if ($esPremium) {
            // Filtro por perfil de salud del usuario
            if ($usarPerfil && $usarPerfil == '1' && isset($_SESSION['id_usuario'])) {
                $idUsuario = intval($_SESSION['id_usuario']);
                
                // Obtener alergias del usuario
                $sqlAlergias = "SELECT id_alergia FROM usuario_alergia WHERE id_usuario = $idUsuario";
                $resultadoAlergias = $conexion->query($sqlAlergias);
                $alergiasUsuario = [];
                while ($row = $resultadoAlergias->fetch_assoc()) {
                    $alergiasUsuario[] = $row['id_alergia'];
                }
                
                // Obtener enfermedades del usuario
                $sqlEnfermedades = "SELECT id_enfermedad FROM usuario_enfermedad WHERE id_usuario = $idUsuario";
                $resultadoEnfermedades = $conexion->query($sqlEnfermedades);
                $enfermedadesUsuario = [];
                while ($row = $resultadoEnfermedades->fetch_assoc()) {
                    $enfermedadesUsuario[] = $row['id_enfermedad'];
                }
                
                // Aplicar filtros de alergias
                if (!empty($alergiasUsuario)) {
                    $alergiasStr = implode(',', $alergiasUsuario);
                    $condiciones[] = "r.id NOT IN (
                        SELECT id_receta FROM receta_alergia 
                        WHERE id_alergia IN ($alergiasStr)
                    )";
                }
                
                // Aplicar filtros de enfermedades
                if (!empty($enfermedadesUsuario)) {
                    $enfermedadesStr = implode(',', $enfermedadesUsuario);
                    $condiciones[] = "r.id NOT IN (
                        SELECT id_receta FROM receta_enfermedad 
                        WHERE id_enfermedad IN ($enfermedadesStr) AND apta = 0
                    )";
                    
                    // Debug: Mostrar las enfermedades del usuario
                    error_log("DEBUG - Enfermedades del usuario: " . print_r($enfermedadesUsuario, true));
                }
            }

            if ($ingrediente && $ingrediente !== '') {
                $ingrediente = $conexion->real_escape_string($ingrediente);
                $condiciones[] = "r.id IN (
                    SELECT id_receta FROM receta_ingrediente ri
                    JOIN ingredientes i ON ri.id_ingrediente = i.id
                    WHERE i.nombre LIKE '%$ingrediente%'
                )";
            }

            if ($enfermedad && $enfermedad !== '') {
                // Manejar múltiples enfermedades separadas por comas
                $enfermedades = explode(',', $enfermedad);
                $enfermedadesInt = array_map('intval', $enfermedades);
                $enfermedadesStr = implode(',', $enfermedadesInt);

                // Excluir recetas que NO son aptas (apta = 0) para las enfermedades seleccionadas
                $condiciones[] = "r.id NOT IN (
                    SELECT re.id_receta 
                    FROM receta_enfermedad re 
                    WHERE re.id_enfermedad IN ($enfermedadesStr) 
                    AND re.apta = 0
                )";
            }

            if ($tiempoPrep && $tiempoPrep !== '') {
                $opcionesTiempo = explode(',', $tiempoPrep);
                $condicionesTiempo = [];

                foreach ($opcionesTiempo as $opcion) {
                    switch ($opcion) {
                        case 'menos-30':
                            $condicionesTiempo[] = "r.tiempo_preparacion <= 30";
                            break;
                        case '31-60':
                            $condicionesTiempo[] = "(r.tiempo_preparacion > 30 AND r.tiempo_preparacion <= 60)";
                            break;
                        case 'mas-60':
                            $condicionesTiempo[] = "r.tiempo_preparacion > 60";
                            break;
                    }
                }

                if (!empty($condicionesTiempo)) {
                    $condiciones[] = "(" . implode(" OR ", $condicionesTiempo) . ")";
                }
            }
        }

        // Debug: Mostrar condiciones de filtrado
        error_log("DEBUG - Condiciones de filtrado: " . print_r($condiciones, true));
        
        // Construir la consulta SQL
        $sql = "SELECT r.*, (SELECT COUNT(*) FROM receta_ingrediente ri WHERE ri.id_receta = r.id) AS num_ingredientes FROM recetas r";

        // Añadir joins necesarios para los filtros
        if ($ingrediente) {
            $sql .= " INNER JOIN receta_ingrediente ri ON r.id = ri.id_receta";
            $sql .= " INNER JOIN ingredientes i ON ri.id_ingrediente = i.id";
        }

        $where = '';
        if (!empty($condiciones)) {
            $where = " WHERE " . implode(' AND ', $condiciones);
        }

        // Debug: Mostrar consulta SQL antes de la ordenación
        error_log("DEBUG - SQL antes de ordenación: " . $sql . $where);

        // Añadir ordenación
        $orderBy = " ORDER BY r.id DESC"; // Por defecto
        if ($orden) {
            switch ($orden) {
                case 'nombre-asc':
                    $orderBy = " ORDER BY r.nombre ASC";
                    break;
                case 'nombre-desc':
                    $orderBy = " ORDER BY r.nombre DESC";
                    break;
                case 'ing-menos-6':
                    // Filtrar recetas con menos de 6 ingredientes y ordenar por cantidad
                    $condiciones[] = "(SELECT COUNT(*) FROM receta_ingrediente ri WHERE ri.id_receta = r.id) < 6";
                    $orderBy = " ORDER BY num_ingredientes ASC";
                    break;
                case 'ing-7-10':
                    // Filtrar recetas con entre 7 y 10 ingredientes y ordenar por cantidad
                    $condiciones[] = "(SELECT COUNT(*) FROM receta_ingrediente ri WHERE ri.id_receta = r.id) BETWEEN 7 AND 10";
                    $orderBy = " ORDER BY num_ingredientes ASC";
                    break;
                case 'ing-mas-10':
                    // Filtrar recetas con más de 10 ingredientes y ordenar por cantidad
                    $condiciones[] = "(SELECT COUNT(*) FROM receta_ingrediente ri WHERE ri.id_receta = r.id) > 10";
                    $orderBy = " ORDER BY num_ingredientes ASC";
                    break;
            }
        }

        $sql .= $where . $orderBy;
        
        // Mostrar la consulta SQL final para depuración
        echo '<pre style="color:red;z-index:99999;position:relative;">SQL FINAL: ' . htmlspecialchars(
            $sql
        ) . '</pre>';
        error_log('SQL FINAL: ' . $sql);
        // Debug: Mostrar consulta SQL final
        error_log("DEBUG - SQL final: " . $sql);

        $resultado = $conexion->query($sql);
        
        if (!$resultado) {
            error_log("Error en la consulta SQL: " . $conexion->error);
            return [];
        }

        $recetas = [];
        while ($row = $resultado->fetch_assoc()) {
            $recetas[] = $row;
        }

        return $recetas;
    }

    public function getRecetaPorId($id)
    {
        global $conexion;
        
        $id = intval($id);
        $sql = "SELECT * FROM recetas WHERE id = $id";
        $resultado = $conexion->query($sql);
        
        if (!$resultado || $resultado->num_rows === 0) {
            return null;
        }
        
        return $resultado->fetch_assoc();
    }
}
