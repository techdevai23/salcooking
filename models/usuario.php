<?php
class Usuario {
    public function obtenerPorEmail($email) {
        global $conexion;
        $email = $conexion->real_escape_string($email);
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = $conexion->query($sql);
        return $resultado->fetch_assoc();
    }

    public function registrar($datos) {
        global $conexion;
        $nick = $conexion->real_escape_string($datos['nick']);
        $email = $conexion->real_escape_string($datos['email']);
        $password = password_hash($datos['contrasena'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nick, email, contrasena_hash)
                VALUES ('$nick', '$email', '$password')";
        return $conexion->query($sql);
    }

    public function actualizarPerfil($id, $datos) {
        global $conexion;
        $nombre = $conexion->real_escape_string($datos['nombre_completo']);
        $ciudad = $conexion->real_escape_string($datos['ciudad']);
        $pais = $conexion->real_escape_string($datos['pais']);

        $sql = "UPDATE usuarios SET nombre_completo='$nombre', ciudad='$ciudad', pais='$pais'
                WHERE id_usuario = $id";
        return $conexion->query($sql);
    }

    public function activarPremium($id, $codigo) {
        global $conexion;
        $codigo = $conexion->real_escape_string($codigo);

        // Verificar si el código existe y está activo
        $verificar = "SELECT * FROM codigos_premium_disponibles WHERE codigo='$codigo' AND activo=1";
        $resultado = $conexion->query($verificar);

        if ($resultado && $resultado->num_rows > 0) {
            // Marcar código como usado
            $sqlCodigo = "UPDATE codigos_premium_disponibles SET activo=0, usado_por_usuario_id=$id, fecha_uso=NOW() WHERE codigo='$codigo'";
            $conexion->query($sqlCodigo);

            // Actualizar usuario a premium
            $sqlUsuario = "UPDATE usuarios SET es_premium=1, codigo_premium_usado='$codigo' WHERE id_usuario=$id";
            return $conexion->query($sqlUsuario);
        } else {
            return false;
        }
    }
}
?>
