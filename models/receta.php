<?php
class Receta {
    public function buscarRecetas($termino, $tipoPlato, $alergeno, $porciones, $ingrediente, $enfermedad, $tiempoPrep, $esPremium, $orden = '', $usarPerfil = null) {
        global $conexion;

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
            $tipoPlato = $conexion->real_escape_string($tipoPlato);
            $condiciones[] = "r.tipo_plato = '$tipoPlato'";
        }
        
        if ($alergeno && $alergeno !== '') {
            $alergeno = intval($alergeno);
            $condiciones[] = "r.id NOT IN (SELECT id_receta FROM receta_alergia WHERE id_alergia = $alergeno)";
        }
        
        if ($porciones && $porciones !== '') {
            if ($porciones == 'mas-4') {
                $condiciones[] = "r.porciones > 4";
            } else {
                $porciones = intval($porciones);
                $condiciones[] = "r.porciones = $porciones";
            }
        }
        
        // Filtros premium (solo si el usuario está logueado)
        if ($esPremium) {
            // Filtro por perfil de salud del usuario
            if ($usarPerfil && $usarPerfil == '1' && isset($_SESSION['id_usuario'])) {
                $idUsuario = intval($_SESSION['id_usuario']);
                
                // Obtener el perfil del usuario
                $sqlPerfil = "SELECT enfermedades, alergias FROM perfiles WHERE id_usuario = $idUsuario";
                $resultadoPerfil = $conexion->query($sqlPerfil);
                
                if ($resultadoPerfil && $resultadoPerfil->num_rows > 0) {
                    $perfil = $resultadoPerfil->fetch_assoc();
                    
                    // Procesar alergias del perfil (formato: "1,2,3" o similar)
                    if (!empty($perfil['alergias'])) {
                        $alergiasUsuario = explode(',', $perfil['alergias']);
                        $alergiasUsuario = array_map('trim', $alergiasUsuario);
                        $alergiasUsuario = array_filter($alergiasUsuario, 'is_numeric');
                        
                        if (!empty($alergiasUsuario)) {
                            $alergiasStr = implode(',', $alergiasUsuario);
                            $condiciones[] = "r.id NOT IN (
                                SELECT id_receta FROM receta_alergia 
                                WHERE id_alergia IN ($alergiasStr)
                            )";
                        }
                    }
                    
                    // Procesar enfermedades del perfil (formato: "1,2,3" o similar)
                    if (!empty($perfil['enfermedades'])) {
                        $enfermedadesUsuario = explode(',', $perfil['enfermedades']);
                        $enfermedadesUsuario = array_map('trim', $enfermedadesUsuario);
                        $enfermedadesUsuario = array_filter($enfermedadesUsuario, 'is_numeric');
                        
                        if (!empty($enfermedadesUsuario)) {
                            $enfermedadesStr = implode(',', $enfermedadesUsuario);
                            $condiciones[] = "r.id IN (
                                SELECT id_receta FROM receta_enfermedad 
                                WHERE id_enfermedad IN ($enfermedadesStr) AND apta = 1
                            )";
                        }
                    }
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
                $enfermedad = intval($enfermedad);
                $condiciones[] = "r.id IN (
                    SELECT id_receta FROM receta_enfermedad WHERE id_enfermedad = $enfermedad AND apta = 1
                )";
            }

            if ($tiempoPrep && $tiempoPrep !== '') {
                if ($tiempoPrep == 'menos-30') {
                    $condiciones[] = "r.tiempo_preparacion < 30";
                } elseif ($tiempoPrep == '31-60') {
                    $condiciones[] = "r.tiempo_preparacion BETWEEN 31 AND 60";
                } elseif ($tiempoPrep == 'mas-60') {
                    $condiciones[] = "r.tiempo_preparacion > 60";
                }
            }
        }

        $where = count($condiciones) ? "WHERE " . implode(" AND ", $condiciones) : "";
        
        // Añadir ordenamiento
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

        // Consulta principal
        $sql = "SELECT DISTINCT r.* FROM recetas r $where $orderBy";
        
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

    public function getRecetaPorId($id) {
        global $conexion;
        $id = intval($id);
        $sql = "SELECT * FROM recetas WHERE id = $id";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_assoc();
    }
}
?>
