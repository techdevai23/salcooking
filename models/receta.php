<?php
class Receta {
    public function buscarRecetas($termino, $tipoPlato, $alergeno, $porciones, $ingrediente, $enfermedad, $tiempoPrep, $esPremium) {
        global $conexion;

        $stopwords = ['de', 'la', 'el', 'y', 'con', 'en', 'a', 'una', 'para'];
        $palabras = array_filter(explode(' ', strtolower($termino)), fn($w) => !in_array($w, $stopwords));

        $condiciones = [];

        foreach ($palabras as $palabra) {
            $condiciones[] = "r.nombre LIKE '%$palabra%'";
        }

        if ($tipoPlato) $condiciones[] = "r.tipo_plato = '$tipoPlato'";
        if ($alergeno) $condiciones[] = "r.id NOT IN (SELECT id_receta FROM receta_alergia WHERE id_alergia = $alergeno)";
        if ($porciones) $condiciones[] = "r.porciones = $porciones";

        if ($esPremium && $ingrediente) {
            $condiciones[] = "r.id IN (
                SELECT id_receta FROM receta_ingrediente ri
                JOIN ingredientes i ON ri.id_ingrediente = i.id
                WHERE i.nombre LIKE '%$ingrediente%'
            )";
        }

        if ($esPremium && $enfermedad) {
            $condiciones[] = "r.id IN (
                SELECT id_receta FROM receta_enfermedad WHERE id_enfermedad = $enfermedad
            )";
        }

        if ($esPremium && $tiempoPrep) {
            $condiciones[] = "r.tiempo_preparacion <= $tiempoPrep";
        }

        $where = count($condiciones) ? "WHERE " . implode(" AND ", $condiciones) : "";

        $sql = "SELECT DISTINCT r.* FROM recetas r $where";

        $resultado = $conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
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
