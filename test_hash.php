<?php
$hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
$pass = '12345';
if (password_verify($pass, $hash)) {
    echo "¡Funciona!";
} else {
    echo "No funciona";
}
?>