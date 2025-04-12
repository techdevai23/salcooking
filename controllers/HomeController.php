<?php
class HomeController {
    public function inicio() {
        include 'views/header.php';
        include 'views/inicio.php';
        include 'views/footer.php';
    }

    public function recetas() {
        include 'views/header.php';
        include 'views/recetas.php';
        include 'views/footer.php';
    }
}
?>
