<?php
$page = $_GET['page'] ?? 'inicio';

require_once 'controllers/HomeController.php';

$controller = new HomeController();

switch ($page) {
    case 'inicio':
        $controller->inicio();
        break;
    case 'recetas':
        $controller->recetas();
        break;
    default:
        echo "Página no encontrada";
}
?>
