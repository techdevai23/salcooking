<?php
// Este archivo es solo para visualización HTML. No hay lógica PHP.
$css_extra = '<link rel="stylesheet" href="styles/perfil-ajustes.css">'; // CSS específico
$nombre_pagina = "Perfil-Ajustes"; // Para el título y migas
?>

<?php include 'header.php'; ?>

<body class="usuario-logueado"> <!-- Clase para JS, simula usuario existente -->
  <!-- migas -->
  <div class="migas-container">
    <div class="container migas-flex">
      <ul class="migas">
        <li><a href="index.php">Inicio</a></li>
        <li class="current"><?php echo htmlspecialchars($nombre_pagina); ?></li>
      </ul>
      <div class="volver-atras-contenedor">
        <a href="javascript:history.back()" class="volver-atras"><img src="images/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
      </div>
    </div>
  </div>



  <!-- Contenido principal-->
  <section class="perfil-ajustes">
    <div class="contenedor-Perfil-Ajustes">

      <div class="titulo">
        <img src="images/iconos/Book-Star--Streamline-Ultimate.svg" alt="Icono Perfil">
        <h1><?php echo htmlspecialchars($nombre_pagina); ?></h1>
      </div>

      <div class="contenido-Perfil-Ajustes">
        <!-- Mensajes de feedback (ejemplo estático) -->
        <!-- <div class="mensaje-feedback mensaje-exito">¡Perfil actualizado con éxito!</div> -->
        <!-- <div class="mensaje-feedback mensaje-error">Error: El campo Nick es obligatorio.</div> -->

        <form id="perfilForm" method="POST" action="#">
          <div class="perfil-form-grid">
            <div class="form-group">
              <label for="nombre_completo">Nombre:</label>
              <input type="text" id="nombre_completo" name="nombre_completo" value="Juan Pérez Ejemplo">
            </div>

            <div class="form-group">
              <label for="nick">Nick: <span class="required">*</span></label>
              <input type="text" id="nick" name="nick" value="juanito_p" required>
              <a href="#" class="form-link">cambiar usuario</a>
            </div>

            <div class="form-group">
              <label for="email">Email: <span class="required">*</span></label>
              <input type="email" id="email" name="email" value="juan.perez@example.com" required>
            </div>

            <div class="form-group">
              <label for="direccion">Dirección:</label>
              <input type="text" id="direccion" name="direccion" value="Calle Falsa 123, Apto 4B">
            </div>

            <div class="form-group edad-group">
              <label for="fecha_nacimiento">Edad:</label> <!-- En la imagen dice "Edad:" y luego el campo muestra // -->
              <div style="display: flex; align-items: center;">
                <input type="text" id="fecha_nacimiento_display" name="fecha_nacimiento_display" value="//" style="width: 80px; text-align: center;">
                <img src="images/iconos/calendar_icon.svg" alt="calendario" style="width:24px; height:24px; margin-left: 10px; cursor:pointer;" title="Seleccionar fecha de nacimiento">
                <!-- Nota: necesitarías un icono de calendario real en images/iconos/calendar_icon.svg -->
              </div>
            </div>

            <div class="form-group">
              <label for="ciudad">Ciudad:</label>
              <input type="text" id="ciudad" name="ciudad" value="Ciudad Ejemplo">
            </div>

           
            <div class="form-group">
              <label for="pais">País:</label>
              <input type="text" id="pais" name="pais" value="País Ejemplo">
            </div>

            <div class="form-group">
              <label>Sexo:</label>
              <div class="sexo-options" style="display: flex; align-items: center; gap: 10px;">
                <!-- En la imagen solo hay un cuadrado, asumo que es un placeholder para opciones -->
                <input type="text" style="width: 40px; height: 30px; border: 1px solid #ccc;" readonly>
              </div>
            </div>

            <div class="form-group">
              <label for="peso_kg">Peso:</label>
              <input type="text" id="peso_kg_display" name="peso_kg_display" value="" style="width: 60px; border: 1px solid #ccc;">
            </div>
            <div class="form-group">
              <label for="contrasena_display">Contraseña:</label>
              <input type="text" id="contrasena_display" name="contrasena_display" value="******************" readonly disabled>
              <a href="#" id="cambiarContrasenaLink" class="form-link">Cambio contraseña</a>
             
            </div>
            <div class="form-group">
            <div id="cambiarContrasenaCampos" class="visible"> <!-- 'visible' para mostrarlo por defecto para diseño -->
                <input type="password" id="contrasena_actual" name="contrasena_actual" placeholder="Contraseña actual" style="margin-top:5px; margin-bottom:5px;">
                <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Nueva contraseña" style="margin-bottom:5px;">
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar nueva contraseña">
              </div>
               </div>

          </div>



          <!-- SECCIÓN PREMIUM (como en la imagen) -->
          
          <div class="form-group registro-codigo-group" style="max-width: 400px;">
          <div style="margin-top: 30px; margin-bottom: 20px;">
            <button type="button" class="action-btn-rosa" style="padding: 10px 20px !important;">Hazte Prémium</button>
          </div>

            <label for="codigo_registro" style="white-space: nowrap; margin-bottom:0; margin-right: 10px;">Código de registro:</label>
            <input type="text" id="codigo_registro" name="codigo_registro" placeholder="">
            <button type="button" title="Aplicar Código" style="background: #ccc; border:1px solid #999; color: #333; padding: 8px 12px; font-size: 1.2rem; cursor:pointer;">➤</button>
          </div>


          <div class="premium-section" style="margin-top:30px;">
            <h3>
              Opciones Prémium
              <img src="images/iconos/info_icon.svg" alt="info" class="info-icon" title="Funcionalidades exclusivas para usuarios premium" style="width:20px; height:20px;">
              <!-- Reemplaza 'info_icon.svg' con un icono real -->
            </h3>
            <div class="premium-options-grid">
              <div class="form-group">
                <label for="intolerancias">Intolerancias</label>
                <select id="intolerancias" name="intolerancias[]" multiple style="min-height: 100px;">
                  <option selected>Gluten</option>
                  <option>Frutos secos</option>
                  <option selected>Pescado</option>
                  <option>Lactosa</option>
                  <option>Marisco</option>
                </select>
              </div>
              <div class="form-group">
                <label for="enfermedades">Enfermedades</label>
                <select id="enfermedades" name="enfermedades[]" multiple style="min-height: 100px;">
                  <option>Colesterol</option>
                  <option selected>Diabetes</option>
                  <option>Hipertensión</option>
                </select>
              </div>
            </div>
            <button type="button" class="action-btn-naranja" style="margin-top:20px; padding: 10px 20px !important;">Generar dieta semanal</button>
          </div>

          <div class="form-actions" style="margin-top:30px;">
            <button type="submit" name="accion" value="guardar_cambios" class="action-btn-verde" style="background-color: #2D3E2E; color: white; padding: 12px 30px !important; font-size: 1.1rem;">Guardar cambios</button>
          </div>

        </form>
      </div>
    </div>
  </section>



  <?php include 'footer.php'; ?>







  <script src="scripts/perfil-ajustes.js"></script>
  <script>
    // Pequeño script para añadir la clase al body para JS (simulado)
    document.body.classList.add('usuario-logueado');

    // Simular que el enlace de cambiar contraseña muestra los campos
    // (esto ya lo haría tu perfil-ajustes.js si está bien configurado)
    const cambiarContrasenaLink = document.getElementById('cambiarContrasenaLink');
    const cambiarContrasenaCampos = document.getElementById('cambiarContrasenaCampos');
    if (cambiarContrasenaLink && cambiarContrasenaCampos) {
      cambiarContrasenaLink.addEventListener('click', function(e) {
        e.preventDefault();
        cambiarContrasenaCampos.classList.toggle('visible');
      });
    }
  </script>
</body>