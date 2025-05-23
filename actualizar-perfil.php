<?php
session_start();
include 'controllers/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Recoger datos del formulario
$nombre_completo = trim($_POST['nombre_completo']);
$nick = trim($_POST['nick']);
$email = trim($_POST['email']);
$direccion = trim($_POST['direccion']) ?: NULL;
$fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : NULL;
$ciudad = trim($_POST['ciudad']) ?: NULL;
$pais = trim($_POST['pais']) ?: NULL;
$sexo = $_POST['sexo'] ?: NULL;
$peso_kg = isset($_POST['peso_kg_display']) ? str_replace(',', '.', $_POST['peso_kg_display']) : NULL;
$nueva_contrasena = $_POST['nueva_contrasena'] ?? '';
$confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

$errores = [];

// Validaciones básicas
if (empty($nombre_completo)) $errores[] = "El nombre completo es obligatorio.";
if (empty($nick)) $errores[] = "El nick es obligatorio.";
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido o está vacío.";
if (!empty($nueva_contrasena) && $nueva_contrasena !== $confirmar_contrasena) $errores[] = "Las contraseñas no coinciden.";
if (!empty($peso_kg) && !is_numeric($peso_kg)) $errores[] = "El peso debe ser un número válido (ej: 65.5).";
if (!empty($fecha_nacimiento) && !strtotime($fecha_nacimiento)) $errores[] = "La fecha de nacimiento no es válida.";

if (empty($errores)) {
    // Comprobar si el nick o email ya existen para otro usuario
    $sql_check = "SELECT id_usuario FROM usuarios WHERE (email = ? OR nick = ?) AND id_usuario != ?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param("ssi", $email, $nick, $id_usuario);
    $stmt_check->execute();
    $resultado_check = $stmt_check->get_result();
    if ($resultado_check->num_rows > 0) {
        $errores[] = "El email o nick introducido ya está registrado por otro usuario.";
    }
    $stmt_check->close();
}

if (empty($errores)) {
    // Construir la consulta de actualización
    $campos = "nombre_completo=?, nick=?, email=?, direccion=?, ciudad=?, pais=?, sexo=?, peso_kg=?, fecha_nacimiento=?";
    $valores = [$nombre_completo, $nick, $email, $direccion, $ciudad, $pais, $sexo, $peso_kg, $fecha_nacimiento];

    // Si se quiere cambiar la contraseña
    if (!empty($nueva_contrasena)) {
        $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $campos .= ", contrasena_hash=?";
        $valores[] = $contrasena_hash;
    }

    $valores[] = $id_usuario;

    $sql_update = "UPDATE usuarios SET $campos WHERE id_usuario=?";
    $stmt_update = $conexion->prepare($sql_update);

    // Crear los tipos para bind_param
    $tipos = "sssssssss";
    if (!empty($nueva_contrasena)) $tipos .= "s";
    $tipos .= "i";

    $stmt_update->bind_param($tipos, ...$valores);

    if ($stmt_update->execute()) {
        $mensaje = "¡Perfil actualizado correctamente!";
        header("Location: perfil-logueado.php?exito=1");
        exit();
    } else {
        $errores[] = "Error al actualizar el perfil: " . $stmt_update->error;
    }
    $stmt_update->close();
}

$conexion->close();
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