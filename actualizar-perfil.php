<?php
session_start();
include 'controllers/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'guardar_cambios') {
    // Actualizar datos básicos del usuario
    $nombre_completo = trim($_POST['nombre_completo']);
    $nick = trim($_POST['nick']);
    $email = trim($_POST['email']);
    $direccion = trim($_POST['direccion']) ?: NULL;
    $ciudad = trim($_POST['ciudad']) ?: NULL;
    $pais = trim($_POST['pais']) ?: NULL;
    $sexo = $_POST['sexo'] ?: NULL;
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : NULL;
    $peso_kg_input = trim($_POST['peso_kg_display']);

    // Convertir comas a puntos para DECIMAL y validar
    $peso_kg = NULL;
    if (!empty($peso_kg_input)) {
        $peso_kg_input_numeric = str_replace(',', '.', $peso_kg_input);
        if (is_numeric($peso_kg_input_numeric)) {
            $peso_kg = floatval($peso_kg_input_numeric);
        }
    }

    // Iniciar transacción
    $conexion->begin_transaction();
    $error = false;

    try {
        // Actualizar datos básicos
        $sql_update = "UPDATE usuarios SET 
                       nombre_completo = ?, 
                       nick = ?, 
                       email = ?, 
                       direccion = ?, 
                       ciudad = ?, 
                       pais = ?, 
                       sexo = ?, 
                       fecha_nacimiento = ?, 
                       peso_kg = ? 
                       WHERE id_usuario = ?";
        
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("ssssssssdi", 
            $nombre_completo, 
            $nick, 
            $email, 
            $direccion, 
            $ciudad, 
            $pais, 
            $sexo, 
            $fecha_nacimiento, 
            $peso_kg, 
            $id_usuario
        );

        if (!$stmt_update->execute()) {
            throw new Exception("Error al actualizar datos básicos: " . $stmt_update->error);
        }

        // Validar y actualizar contraseña si se proporcionó una nueva
        $nueva_contrasena = trim($_POST['nueva_contrasena'] ?? '');
        $confirmar_contrasena = trim($_POST['confirmar_contrasena'] ?? '');
        
        if (!empty($nueva_contrasena) || !empty($confirmar_contrasena)) {
            if (empty($nueva_contrasena) || empty($confirmar_contrasena)) {
                throw new Exception("Por favor, completa ambos campos de contraseña");
            }
            
            if ($nueva_contrasena !== $confirmar_contrasena) {
                throw new Exception("Las contraseñas no coinciden");
            }
            
            if (strlen($nueva_contrasena) < 8 || 
                !preg_match('/[A-Z]/', $nueva_contrasena) || 
                !preg_match('/[0-9]/', $nueva_contrasena) || 
                !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $nueva_contrasena)) {
                throw new Exception("La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial");
            }

            $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            $sql_update_pass = "UPDATE usuarios SET contrasena_hash = ? WHERE id_usuario = ?";
            $stmt_update_pass = $conexion->prepare($sql_update_pass);
            $stmt_update_pass->bind_param("si", $contrasena_hash, $id_usuario);
            
            if (!$stmt_update_pass->execute()) {
                throw new Exception("Error al actualizar la contraseña: " . $stmt_update_pass->error);
            }
        }

        // Actualizar alergias
        if (isset($_POST['intolerancias'])) {
            $sql_delete_alergias = "DELETE FROM usuario_alergia WHERE id_usuario = ?";
            $stmt_delete_alergias = $conexion->prepare($sql_delete_alergias);
            $stmt_delete_alergias->bind_param("i", $id_usuario);
            
            if (!$stmt_delete_alergias->execute()) {
                throw new Exception("Error al actualizar alergias: " . $stmt_delete_alergias->error);
            }

            $sql_insert_alergia = "INSERT INTO usuario_alergia (id_usuario, id_alergia) VALUES (?, ?)";
            $stmt_insert_alergia = $conexion->prepare($sql_insert_alergia);
            foreach ($_POST['intolerancias'] as $id_alergia) {
                $stmt_insert_alergia->bind_param("ii", $id_usuario, $id_alergia);
                if (!$stmt_insert_alergia->execute()) {
                    throw new Exception("Error al insertar alergia: " . $stmt_insert_alergia->error);
                }
            }
        }

        // Actualizar enfermedades
        if (isset($_POST['enfermedades'])) {
            $sql_delete_enfermedades = "DELETE FROM usuario_enfermedad WHERE id_usuario = ?";
            $stmt_delete_enfermedades = $conexion->prepare($sql_delete_enfermedades);
            $stmt_delete_enfermedades->bind_param("i", $id_usuario);
            
            if (!$stmt_delete_enfermedades->execute()) {
                throw new Exception("Error al actualizar enfermedades: " . $stmt_delete_enfermedades->error);
            }

            $sql_insert_enfermedad = "INSERT INTO usuario_enfermedad (id_usuario, id_enfermedad) VALUES (?, ?)";
            $stmt_insert_enfermedad = $conexion->prepare($sql_insert_enfermedad);
            foreach ($_POST['enfermedades'] as $id_enfermedad) {
                $stmt_insert_enfermedad->bind_param("ii", $id_usuario, $id_enfermedad);
                if (!$stmt_insert_enfermedad->execute()) {
                    throw new Exception("Error al insertar enfermedad: " . $stmt_insert_enfermedad->error);
                }
            }
        }

        // Si todo salió bien, confirmar la transacción
        $conexion->commit();
        
        // Guardar mensaje de éxito en la sesión
        $_SESSION['mensaje_feedback'] = "Perfil actualizado correctamente";
        $_SESSION['tipo_mensaje'] = "mensaje-exito";
        
        // Redirigir a accion-completada.php
        header("Location: accion-completada.php");
        exit();

    } catch (Exception $e) {
        // Si hubo error, revertir la transacción
        $conexion->rollback();
        $_SESSION['mensaje_feedback'] = $e->getMessage();
        $_SESSION['tipo_mensaje'] = "mensaje-error";
        header("Location: perfil-logueado.php");
        exit();
    }
}

$conexion->close();

// Redirigir de vuelta al perfil con el mensaje
$_SESSION['mensaje_feedback'] = $mensaje;
$_SESSION['tipo_mensaje'] = $tipo_mensaje;
header("Location: perfil-logueado.php");
exit();
?>

<?php include 'header.php'; ?>

<section class="perfil-ajustes">
    <div class="contenedor-Perfil-Ajustes">
        <div class="titulo">
            <img src="sources/iconos/Book-Star--Streamline-Ultimate.svg" alt="Icono Perfil">
            <h1>Actualizar Perfil</h1>
        </div>
        <div class="contenido-Perfil-Ajustes">
            <?php if (!empty($errores)): ?>
                <div class="mensaje-feedback mensaje-error">
                    <?php echo implode("<br>", $errores); ?>
                </div>
            <?php endif; ?>
            <a href="perfil-logueado.php" class="btn-opciones">Volver a mi perfil</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>