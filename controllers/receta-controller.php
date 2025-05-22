<?php
require_once 'models/receta.php';

class RecetaController {
    public function buscar() {
        $termino = $_GET['q'] ?? '';
        $tipoPlato = $_GET['tipo_plato'] ?? '';
        $alergeno = $_GET['alergeno'] ?? '';
        $porciones = $_GET['porciones'] ?? '';
        $ingrediente = $_GET['ingrediente'] ?? null;
        $enfermedad = $_GET['enfermedad'] ?? null;
        $tiempoPrep = $_GET['tiempo'] ?? null;
        $esPremium = $_SESSION['usuario']['es_premium'] ?? false;

        $modelo = new Receta();
        $resultados = $modelo->buscarRecetas($termino, $tipoPlato, $alergeno, $porciones, $ingrediente, $enfermedad, $tiempoPrep, $esPremium);

        require 'views/resultado-recetas.php';
    }

    public function verDetalle() {
        $id = $_GET['id'] ?? 0;
        $modelo = new Receta();
        $receta = $modelo->getRecetaPorId($id);
        require 'detalle-receta.php';
    }
}
?>
