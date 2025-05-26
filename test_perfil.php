<?php
// Script de prueba para verificar el filtro de perfil
session_start();
$_SESSION['id_usuario'] = 1; // Simular usuario premium
$_GET['page'] = 'buscar';
$_GET['perfil'] = '1'; // Activar filtro de perfil

require_once 'controllers/conexion.php';

echo "=== PRUEBA DEL FILTRO DE PERFIL ===\n";
echo "Usuario ID: " . $_SESSION['id_usuario'] . "\n";
echo "Filtro perfil activado: " . ($_GET['perfil'] ?? 'no') . "\n\n";

// Verificar si existe el perfil del usuario
$idUsuario = intval($_SESSION['id_usuario']);
$sqlPerfil = "SELECT * FROM perfiles WHERE id_usuario = $idUsuario";
$resultadoPerfil = $conexion->query($sqlPerfil);

if ($resultadoPerfil && $resultadoPerfil->num_rows > 0) {
    $perfil = $resultadoPerfil->fetch_assoc();
    echo "=== DATOS DEL PERFIL ===\n";
    echo "ID Perfil: " . $perfil['id_perfil'] . "\n";
    echo "Nick: " . $perfil['nick'] . "\n";
    echo "Alergias: '" . $perfil['alergias'] . "'\n";
    echo "Enfermedades: '" . $perfil['enfermedades'] . "'\n\n";
    
    // Procesar alergias
    if (!empty($perfil['alergias'])) {
        $alergiasUsuario = explode(',', $perfil['alergias']);
        $alergiasUsuario = array_map('trim', $alergiasUsuario);
        $alergiasUsuario = array_filter($alergiasUsuario, 'is_numeric');
        echo "Alergias procesadas: " . implode(', ', $alergiasUsuario) . "\n";
    }
    
    // Procesar enfermedades
    if (!empty($perfil['enfermedades'])) {
        $enfermedadesUsuario = explode(',', $perfil['enfermedades']);
        $enfermedadesUsuario = array_map('trim', $enfermedadesUsuario);
        $enfermedadesUsuario = array_filter($enfermedadesUsuario, 'is_numeric');
        echo "Enfermedades procesadas: " . implode(', ', $enfermedadesUsuario) . "\n";
    }
} else {
    echo "=== NO SE ENCONTRÓ PERFIL ===\n";
    echo "Creando perfil de prueba...\n";
    
    // Crear un perfil de prueba
    $sqlInsert = "INSERT INTO perfiles (id_usuario, nick, alergias, enfermedades) 
                  VALUES ($idUsuario, 'usuario_test', '1,2', '1') 
                  ON DUPLICATE KEY UPDATE 
                  alergias = '1,2', enfermedades = '1'";
    
    if ($conexion->query($sqlInsert)) {
        echo "Perfil de prueba creado:\n";
        echo "- Alergias: 1,2 (frutos secos, gluten)\n";
        echo "- Enfermedades: 1 (diabetes)\n";
    } else {
        echo "Error creando perfil: " . $conexion->error . "\n";
    }
}

echo "\n=== PROBANDO CONTROLADOR ===\n";
require_once 'controllers/receta-controller.php';

$controller = new RecetaController();
ob_start();
$controller->buscar();
$output = ob_get_clean();

// Extraer comentarios de debug del perfil
preg_match_all('/<!-- Debug Perfil:.*? -->/', $output, $matches);
echo "Comentarios debug del perfil encontrados: " . count($matches[0]) . "\n";

if (count($matches[0]) > 0) {
    echo "\n=== DEBUG DEL PERFIL ===\n";
    foreach($matches[0] as $debug) {
        echo $debug . "\n";
    }
} else {
    echo "\n=== NO HAY DEBUG DEL PERFIL ===\n";
    echo "Primeros 500 caracteres del output:\n";
    echo substr($output, 0, 500) . "\n";
}
?> 