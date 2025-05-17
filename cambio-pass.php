<?php
$css_extra = '';

$css_extra .= '<link rel="stylesheet" href="styles/cambio.css?v=' . filemtime('styles/cambio.css') . '">';
?>

<?php include 'header.php'; ?>

<!-- migas -->
<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="perfil-ajustes.php">Perfil-Ajustes</a></li>
      <li class="current">Cambiar Contraseña</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>

<!-- Contenido principal-->
<section class="cambio-contrasena-section">
    <div class="contenedor-nombre-landing">
        <div class="titulo">
            <img src="sources/iconos/Lock-Shield--Streamline-Ultimate.svg" alt="Icono cambio contraseña">
            <h1>Cambiar contraseña</h1>
        </div>
        
        <div class="contenido-landing cambio-contrasena-container">
            <h2 class="instruccion-principal">Por favor introduce un email registrado para cambiar la contraseña</h2>
            
            <div class="password-requirements">
                <div class="requirements-header">
                    <i class="info-icon">i</i>
                    <span>La contrraseña deberá contener</span>
                </div>
                <ul class="requirements-list">
                    <li class="requirement-met">
                        <span class="check-icon">✓</span>
                        Ser de al menos 8 carácteres
                    </li>
                    <li class="requirement-met">
                        <span class="check-icon">✓</span>
                        Tener al menos 1 letra mayúscula
                    </li>
                    <li class="requirement-met">
                    <span class="check-icon">✓</span>
                        Tener al menos 1 número
                    </li>
                    <li class="requirement-met">
                        <span class="check-icon">✓</span>
                        Tener al menos un caracter especial
                    </li>
                </ul>
            </div>
            
            <div class="cambio-contrasena-form">
                <form action="accion-completada.php" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Introduce tu email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nueva-contrasena">Nueva contraseña:</label>
                        <input type="password" id="nueva-contrasena" name="nueva-contrasena" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirmar-contrasena">Confirma contraseña:</label>
                        <input type="password" id="confirmar-contrasena" name="confirmar-contrasena" class="form-control" required>
                        <a href="#" class="show-password">Muestrame la contraseña</a>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" class="btn-opciones">Restablecer la contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>