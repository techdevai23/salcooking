<?php
class Receta
{
    public function buscarRecetas($termino, $tipoPlato, $alergeno, $porciones, $ingrediente, $enfermedad, $tiempoPrep, $esPremium, $orden = '', $usarPerfil = null)
    {
        global $conexion;
        
        // Debug: Mensaje de inicio muy visible
        echo "\n<!-- ===== INICIO DEBUG ===== -->";
        echo "\n<!-- MÉTODO buscarRecetas EJECUTÁNDOSE -->";
        echo "\n<!-- ====================== -->\n";

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
                    echo "<!-- DEBUG - Enfermedades del usuario: " . print_r($enfermedadesUsuario, true) . " -->";
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

            // if ($enfermedad && $enfermedad !== '') {
            //     // Manejar múltiples enfermedades separadas por comas
            //     $enfermedades = explode(',', $enfermedad);
            //     $enfermedadesInt = array_map('intval', $enfermedades);
            //     $enfermedadesStr = implode(',', $enfermedadesInt);
            //     $condiciones[] = "r.id IN (
            //         SELECT id_receta FROM receta_enfermedad 
            //         WHERE id_enfermedad IN ($enfermedadesStr) AND apta = 1
            //     )";
            // }

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

            // if ($tiempoPrep && $tiempoPrep !== '') {
            //     // Manejar múltiples rangos de tiempo
            //     $opcionesTiempo = explode(',', $tiempoPrep);
            //     $condicionesTiempo = [];

            //     foreach ($opcionesTiempo as $opcion) {
            //         $opcion = trim($opcion);
            //         if ($opcion == 'menos-30') {
            //             $condicionesTiempo[] = "r.tiempo_preparacion < 30";
            //         } elseif ($opcion == '31-60') {
            //             $condicionesTiempo[] = "r.tiempo_preparacion BETWEEN 31 AND 60";
            //         } elseif ($opcion == 'mas-60') {
            //             $condicionesTiempo[] = "r.tiempo_preparacion > 60";
            //         }
            //     }

            //     if (!empty($condicionesTiempo)) {
            //         $condiciones[] = "(" . implode(" OR ", $condicionesTiempo) . ")";
            //     }
            // }
            // Modificar el filtro de tiempo para que coincida con los valores del formulario
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

        // Debug: Mostrar condiciones de filtrado*****************
        echo "<!-- DEBUG - Condiciones de filtrado: " . print_r($condiciones, true) . " -->";
        
        // Construir la consulta SQL
        $sql = "SELECT DISTINCT r.* FROM recetas r";

        // Añadir joins necesarios para los filtros
        if ($ingrediente) {
            $sql .= " INNER JOIN receta_ingrediente ri ON r.id = ri.id_receta";
            $sql .= " INNER JOIN ingredientes i ON ri.id_ingrediente = i.id";
        }

        $where = '';
        if (!empty($condiciones)) {
            $where = " WHERE " . implode(' AND ', $condiciones);
        }

        // Debug: Mostrar consulta SQL antes de la ordenación*****************
        $sqlDebug = $sql . $where;

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
                    $condiciones[] = "r.id IN (
                        SELECT id_receta FROM receta_ingrediente 
                        GROUP BY id_receta 
                        HAVING COUNT(*) < 6
                    )";
                    $orderBy = " ORDER BY (
                        SELECT COUNT(*) FROM receta_ingrediente ri2 
                        WHERE ri2.id_receta = r.id
                    ) ASC";
                    break;
                case 'ing-7-10':
                    // Filtrar recetas con entre 7 y 10 ingredientes y ordenar por cantidad
                    $condiciones[] = "r.id IN (
                        SELECT id_receta FROM receta_ingrediente 
                        GROUP BY id_receta 
                        HAVING COUNT(*) BETWEEN 7 AND 10
                    )";
                    $orderBy = " ORDER BY (
                        SELECT COUNT(*) FROM receta_ingrediente ri2 
                        WHERE ri2.id_receta = r.id
                    ) ASC";
                    break;
                case 'ing-mas-10':
                    // Filtrar recetas con más de 10 ingredientes y ordenar por cantidad
                    $condiciones[] = "r.id IN (
                        SELECT id_receta FROM receta_ingrediente 
                        GROUP BY id_receta 
                        HAVING COUNT(*) > 10
                    )";
                    $orderBy = " ORDER BY (
                        SELECT COUNT(*) FROM receta_ingrediente ri2 
                        WHERE ri2.id_receta = r.id
                    ) DESC";
                    break;
            }
        }

        // Construir consulta final
        $sql = $sql . $where . $orderBy;
        
        // Debug: Mostrar consulta SQL final
        echo "<!-- DEBUG - Consulta SQL final: " . htmlspecialchars($sql) . " -->";

        $resultado = $conexion->query($sql);

        if (!$resultado) {
            echo "<!-- Error en la consulta: " . $conexion->error . " -->";
            return [];
        }

        $recetas = $resultado->fetch_all(MYSQLI_ASSOC);

        // Agregar alérgenos y enfermedades para cada receta
        foreach ($recetas as &$receta) {
            // Obtener alérgenos
            $sqlAlergenos = "SELECT a.id, a.nombre, ra.observaciones 
                           FROM receta_alergia ra 
                           JOIN alergias a ON ra.id_alergia = a.id 
                           WHERE ra.id_receta = " . $receta['id'];
            $resAlergenos = $conexion->query($sqlAlergenos);
            $receta['alergenos'] = $resAlergenos ? $resAlergenos->fetch_all(MYSQLI_ASSOC) : [];

            // Obtener enfermedades (solo las NO aptas para mostrar como advertencia)
            $sqlEnfermedades = "SELECT e.id, e.nombre, re.indicaciones, re.apta 
                              FROM receta_enfermedad re 
                              JOIN enfermedades e ON re.id_enfermedad = e.id 
                              WHERE re.id_receta = " . $receta['id'] . " AND re.apta = 0";
            $resEnfermedades = $conexion->query($sqlEnfermedades);
            $receta['enfermedades'] = $resEnfermedades ? $resEnfermedades->fetch_all(MYSQLI_ASSOC) : [];
        }

        return $recetas;
    }

    public function getRecetaPorId($id)
    {
        global $conexion;
        $id = intval($id);
        $sql = "SELECT * FROM recetas WHERE id = $id";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_assoc();
    }
}
