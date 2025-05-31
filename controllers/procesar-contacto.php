<?php
session_start();

// Verificar token CSRF
if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die('Error de validación CSRF');
}

// Función para sanitizar datos
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Verificar que se recibieron los datos requeridos
$required_fields = ['nombre', 'email'];
$errors = [];

foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $errors[] = "El campo $field es obligatorio.";
    }
}

// Validar email
if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "El email proporcionado no es válido.";
}

// Validar que al menos un selector tenga valor
if (empty($_POST['modeloRobot']) && empty($_POST['tipoConsulta'])) {
    $errors[] = "Debes seleccionar al menos una opción en los selectores.";
}

// Si hay errores, redirigir de vuelta al formulario
if (!empty($errors)) {
    $_SESSION['contact_errors'] = $errors;
    header('Location: ../contacto.php');
    exit();
}

// Sanitizar todos los datos
$nombre = sanitize_input($_POST['nombre']);
$email = sanitize_input($_POST['email']);
$telefono = isset($_POST['telefono']) ? sanitize_input($_POST['telefono']) : '';
$modeloRobot = isset($_POST['modeloRobot']) ? sanitize_input($_POST['modeloRobot']) : '';
$tipoConsulta = isset($_POST['tipoConsulta']) ? sanitize_input($_POST['tipoConsulta']) : '';

// Aquí puedes agregar el código para enviar el email o guardar en base de datos
// Por ejemplo, usando mail():
$to = "info@salcooking.es";
$subject = "Nuevo mensaje de contacto de $nombre";
$message = "Nombre: $nombre\n";
$message .= "Email: $email\n";
$message .= "Teléfono: $telefono\n";
$message .= "Consulta Premium: $modeloRobot\n";
$message .= "Consulta General: $tipoConsulta\n";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $message, $headers)) {
    $_SESSION['contact_success'] = "Tu mensaje ha sido enviado correctamente. Nos pondremos en contacto contigo pronto.";
} else {
    $_SESSION['contact_errors'] = ["Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde."];
}

// Redirigir de vuelta al formulario
header('Location: ../contacto.php');
exit(); 