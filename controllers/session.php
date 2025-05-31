<?php
// Función para iniciar la sesión si no está iniciada
function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Función para verificar si el usuario está logueado
function isLoggedIn() {
    return isset($_SESSION['id_usuario']);
}

// Función para obtener el nick del usuario (sin necesidad de base de datos)
function getUserNick() {
    return isset($_SESSION['nick']) ? $_SESSION['nick'] : '';
}

// Función para cerrar sesión
function logout() {
    session_start();
    session_unset();
    session_destroy();
}
?> 