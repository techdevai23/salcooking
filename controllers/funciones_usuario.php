<?php
// funciones_usuario.php
// require_once 'db_config.php'; // No es necesario si db_config.php ya está incluido en el script principal

function obtenerUsuarioPorId($pdo, $id_usuario) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    return $stmt->fetch();
}

function obtenerUsuarioPorNick($pdo, $nick) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nick = ?");
    $stmt->execute([$nick]);
    return $stmt->fetch();
}

function obtenerUsuarioPorEmail($pdo, $email) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}

function crearUsuario($pdo, $datos) {
    // Validar que los campos obligatorios están presentes en $datos
    if (empty($datos['nick']) || empty($datos['email']) || empty($datos['contrasena'])) {
        return false; // O lanzar una excepción
    }

    $contrasena_hash = password_hash($datos['contrasena'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO usuarios (nick, email, contrasena_hash, nombre_completo, fecha_nacimiento, direccion, ciudad, pais, sexo, peso_kg, es_premium) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            $datos['nick'],
            $datos['email'],
            $contrasena_hash,
            $datos['nombre_completo'] ?? null,
            empty($datos['fecha_nacimiento']) ? null : $datos['fecha_nacimiento'],
            $datos['direccion'] ?? null,
            $datos['ciudad'] ?? null,
            $datos['pais'] ?? null,
            $datos['sexo'] ?? null,
            empty($datos['peso_kg']) ? null : $datos['peso_kg'],
            $datos['es_premium'] ?? 0
        ]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        // Manejar error de duplicidad de nick o email
        if ($e->errorInfo[1] == 1062) { // Código de error para entrada duplicada
            // Puedes ser más específico sobre qué campo está duplicado
            if (strpos($e->getMessage(), 'nick') !== false) {
                throw new Exception("El nick '{$datos['nick']}' ya está en uso.");
            } elseif (strpos($e->getMessage(), 'email') !== false) {
                throw new Exception("El email '{$datos['email']}' ya está registrado.");
            }
        }
        throw $e; // Re-lanzar otras excepciones
    }
}

function actualizarUsuario($pdo, $id_usuario, $datos) {
    // Construir la query dinámicamente basada en los datos proporcionados
    $campos = [];
    $valores = [];

    if (isset($datos['nick'])) { $campos[] = 'nick = ?'; $valores[] = $datos['nick']; }
    if (isset($datos['email'])) { $campos[] = 'email = ?'; $valores[] = $datos['email']; }
    if (isset($datos['nombre_completo'])) { $campos[] = 'nombre_completo = ?'; $valores[] = $datos['nombre_completo']; }
    if (isset($datos['fecha_nacimiento'])) { $campos[] = 'fecha_nacimiento = ?'; $valores[] = empty($datos['fecha_nacimiento']) ? null : $datos['fecha_nacimiento']; }
    if (isset($datos['direccion'])) { $campos[] = 'direccion = ?'; $valores[] = $datos['direccion']; }
    if (isset($datos['ciudad'])) { $campos[] = 'ciudad = ?'; $valores[] = $datos['ciudad']; }
    if (isset($datos['pais'])) { $campos[] = 'pais = ?'; $valores[] = $datos['pais']; }
    if (isset($datos['sexo'])) { $campos[] = 'sexo = ?'; $valores[] = $datos['sexo']; }
    if (isset($datos['peso_kg'])) { $campos[] = 'peso_kg = ?'; $valores[] = empty($datos['peso_kg']) ? null : $datos['peso_kg']; }
    
    if (empty($campos)) {
        return true; // Nada que actualizar
    }

    $sql = "UPDATE usuarios SET " . implode(', ', $campos) . " WHERE id_usuario = ?";
    $valores[] = $id_usuario;
    
    $stmt = $pdo->prepare($sql);
    try {
        return $stmt->execute($valores);
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            if (strpos($e->getMessage(), 'nick') !== false) {
                throw new Exception("El nick '{$datos['nick']}' ya está en uso.");
            } elseif (strpos($e->getMessage(), 'email') !== false) {
                throw new Exception("El email '{$datos['email']}' ya está registrado.");
            }
        }
        throw $e;
    }
}

function actualizarContrasena($pdo, $id_usuario, $nueva_contrasena) {
    $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE usuarios SET contrasena_hash = ? WHERE id_usuario = ?");
    return $stmt->execute([$contrasena_hash, $id_usuario]);
}

function verificarCodigoPremium($pdo, $codigo) {
    $stmt = $pdo->prepare("SELECT * FROM codigos_premium_disponibles WHERE codigo = ? AND activo = 1 AND usado_por_usuario_id IS NULL");
    $stmt->execute([$codigo]);
    return $stmt->fetch();
}

function aplicarCodigoPremium($pdo, $id_usuario, $codigo_id, $codigo_texto) {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("UPDATE usuarios SET es_premium = 1, codigo_premium_usado = ? WHERE id_usuario = ?");
        $stmt->execute([$codigo_texto, $id_usuario]);

        $stmt = $pdo->prepare("UPDATE codigos_premium_disponibles SET activo = 0, usado_por_usuario_id = ?, fecha_uso = NOW() WHERE id_codigo = ?");
        $stmt->execute([$id_usuario, $codigo_id]);
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error al aplicar código Prémium: " . $e->getMessage());
        return false;
    }
}

// Funciones para intolerancias y enfermedades (obtener todas, obtener del usuario, actualizar para usuario)
function obtenerTodasIntolerancias($pdo) {
    $stmt = $pdo->query("SELECT id_intolerancia, nombre_intolerancia FROM intolerancias ORDER BY nombre_intolerancia");
    return $stmt->fetchAll();
}

function obtenerIntoleranciasUsuario($pdo, $id_usuario) {
    $stmt = $pdo->prepare("SELECT i.id_intolerancia, i.nombre_intolerancia 
                           FROM intolerancias i
                           JOIN usuario_intolerancias ui ON i.id_intolerancia = ui.id_intolerancia
                           WHERE ui.id_usuario = ?");
    $stmt->execute([$id_usuario]);
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // Devuelve [id_intolerancia => nombre_intolerancia]
}

function actualizarIntoleranciasUsuario($pdo, $id_usuario, $ids_intolerancias_seleccionadas) {
    $pdo->beginTransaction();
    try {
        // Borrar las existentes
        $stmt = $pdo->prepare("DELETE FROM usuario_intolerancias WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);

        // Insertar las nuevas (si hay alguna)
        if (!empty($ids_intolerancias_seleccionadas)) {
            $sql_insert = "INSERT INTO usuario_intolerancias (id_usuario, id_intolerancia) VALUES (?, ?)";
            $stmt_insert = $pdo->prepare($sql_insert);
            foreach ($ids_intolerancias_seleccionadas as $id_intolerancia) {
                $stmt_insert->execute([$id_usuario, $id_intolerancia]);
            }
        }
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error actualizando intolerancias: " . $e->getMessage());
        return false;
    }
}

// Funciones análogas para enfermedades
function obtenerTodasEnfermedades($pdo) {
    $stmt = $pdo->query("SELECT id_enfermedad, nombre_enfermedad FROM enfermedades ORDER BY nombre_enfermedad");
    return $stmt->fetchAll();
}

function obtenerEnfermedadesUsuario($pdo, $id_usuario) {
    $stmt = $pdo->prepare("SELECT e.id_enfermedad, e.nombre_enfermedad
                           FROM enfermedades e
                           JOIN usuario_enfermedades ue ON e.id_enfermedad = ue.id_enfermedad
                           WHERE ue.id_usuario = ?");
    $stmt->execute([$id_usuario]);
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

function actualizarEnfermedadesUsuario($pdo, $id_usuario, $ids_enfermedades_seleccionadas) {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("DELETE FROM usuario_enfermedades WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);

        if (!empty($ids_enfermedades_seleccionadas)) {
            $sql_insert = "INSERT INTO usuario_enfermedades (id_usuario, id_enfermedad) VALUES (?, ?)";
            $stmt_insert = $pdo->prepare($sql_insert);
            foreach ($ids_enfermedades_seleccionadas as $id_enfermedad) {
                $stmt_insert->execute([$id_usuario, $id_enfermedad]);
            }
        }
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error actualizando enfermedades: " . $e->getMessage());
        return false;
    }
}

// Función para obtener un valor de forma segura de un array (para rellenar el formulario)
function old($array, $key, $default = '') {
    return isset($array[$key]) ? htmlspecialchars($array[$key], ENT_QUOTES, 'UTF-8') : $default;
}
?>