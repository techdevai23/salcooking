<?php
$css_extra = '';
$css_extra .= '<link rel="stylesheet" href="styles/login.css?v=' . filemtime('styles/login.css') . '">';
?>

<?php include 'header.php'; ?>


<!-- migas -->
 <!-- migas -->
  <div class="migas-container">
    <div class="container migas-flex">
      <ul class="migas">
        <li><a href="index.php">Inicio</a></li>
        <li class="current">Login</li>
      </ul>
      <div class="volver-atras-contenedor">
        <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
      </div>
    </div>
  </div>

<!-- Contenido principal-->
<section class="login-section">
    <div class="contenedor-nombre-landing">
        <div class="titulo">
            <img src="sources/iconos/Dial-Finger-1--Streamline-Ultimate.svg" alt="Icono identificación">
            <h1>Identificación</h1>
        </div>
       
        <div class="contenido-landing login-container">
            <div class="login-form">
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Introduce usuario" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" placeholder="Introduce contraseña" class="form-control">
                </div>
                
                <div class="form-options">
                    <div class="remember-option">
                        <input type="checkbox" id="recordar" name="recordar">
                        <label for="recordar">Recuérdame</label>
                    </div>
                    <div class="help-links">
                        <a href="cambio-pass.php" class="forgot-link">Olvidé cómo acceder. Ayúdame</a>
                    </div>
                </div>
                
                <div class="form-buttons">
                    
                    <a href="perfil-loguedo.php" class="btn-entrar">Entrar</a>
                </div>
                
                <div class="create-account">
                    <a href="perfil.php" class="btn-opciones">Crear Nuevo Usuario</a>
                </div>
            </div>
            
            <div class="login-logo">
              <a href="index.php"><img src="sources//logos/salcooking-solo-logo- cuadrado.png" alt="SalCooking Logo"></a>  
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>