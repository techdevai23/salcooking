<?php
$css_extra = '<link rel="stylesheet" href="styles/filosofia.css?v=<?php echo time(); ?>">';
?>


<?php include 'header.php'; ?>

<!-- migas -->
<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li class="current">Nuestra Filosofía</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>

<section class="filosofia">
  <div class="contenedor-filosofia">

    <div class="titulo">
      <img src="sources/iconos/Book-Star--Streamline-Ultimate.svg" alt="Book Star - Libro destacado">
      <h1>Nuestra Filosofía: El arte de cocinar cuidando tu salud</h1>
    </div>

    <div class="contenido-filosofia">

      <div class="foto">
        <img src="sources/recursos/nosotros.png" alt="Foto nosotros" width="300px">
        <p>Oscar y Sonia</p>
        <!-- Faldón 1 -->
        <!-- <section class="faldon">
          <h2>🥗 Cada receta es un paso hacia tu bienestar</h2>
          <a href="index.php?page=recetas" class="boton-faldon">Explora nuestras recetas</a>
        </section> -->

      </div>

      <div class="texto-filosofia">

        <h4>> Cómo surgió SalCooking</h4>
        <p> SalCooking nace de la pasión por la cocina saludable y de una necesidad real detectada durante un hackathon de innovación organizado por INCIBE en La Terminal. En aquel reto de 48 horas, surgió la primera idea bajo el nombre de Recooking, centrada inicialmente en el reaprovechamiento de alimentos. Sin embargo, al observar la gran cantidad de personas afectadas por intolerancias, alergias o enfermedades como la diabetes y la hipertensión, el proyecto evolucionó hacia lo que hoy es SalCooking:
          una plataforma dedicada a planificar tu alimentación de forma inteligente, segura y totalmente adaptada a tu salud y gustos.
        </p>
        <br>

        <div class="faldon">
          Hablan de nosotros en el programa especializado de Startups de
          <b><span style="color:red">RNE</span></b>
          <a href="#" class="abrir-modal-audio" id="openAudioModal">🎧 Escuchar entrevista</a>
        </div>

<!-- Modal -->
<div id="audioModal" class="filosofia-modal" style="display:none;">
  <div class="filosofia-modal-dialog">
    <div class="filosofia-modal-content">
      <span id="closeAudioModal" class="close"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="25px" alt="volver"></span>
      <h2>Entrevista en RNE</h2>
      <h2>(ficción sonora)</h2>
      <p>Escucha la entrevista completa en el programa especializado de Startups de RNE, donde hablan sobre SalCooking y su impacto en la cocina saludable.</p>
      <!-- <audio controls>
        <source src="sources/audios/entrevista-completa-SalCooking-Premium.wav" type="audio/wav">
        Tu navegador no soporta el elemento de audio.
      </audio> -->
  <audio controls>
  <source src="https://raw.githubusercontent.com/techdevai23/salcooking/main/sources/audios/entrevista-completa-SalCooking-Premium.wav" type="audio/wav">
  Tu navegador no soporta el elemento de audio.
</audio>

      
    </div>
  </div>
</div>

<script>
  // Función para abrir el modal
function abrirModal() {
  const modal = document.getElementById("audioModal");
  modal.style.display = "block";
  document.body.classList.add("modal-open");

  // Aplicar desenfoque solo a los elementos que no son el modal
  document.querySelectorAll('#audioModal').parentNode.querySelectorAll(':scope > *:not(#audioModal)').forEach(element => {
    if (!modal.contains(element)) {
      element.classList.add('blur-background');
    }
  });
}
  
  document.addEventListener("DOMContentLoaded", function() {
    // Buscar todos los elementos que deban abrir el modal
    const botonesAbrir = document.querySelectorAll(".abrir-modal-audio");
    
    botonesAbrir.forEach(boton => {
      boton.addEventListener("click", abrirModal);
    });
    
    // Función para cerrar el modal
    function cerrarModal() {
      const modal = document.getElementById("audioModal");
      modal.style.display = "none";
      document.body.classList.remove("modal-open");
      
      // Quitar el efecto de desenfoque
      document.querySelectorAll('.blur-background').forEach(element => {
        element.classList.remove('blur-background');
      });
    }
    
    // Cerrar modal con la X
    document.getElementById("closeAudioModal").addEventListener("click", cerrarModal);
    
    // Cerrar modal al hacer clic fuera
    window.addEventListener("click", function(event) {
      if (event.target === document.getElementById("audioModal")) {
        cerrarModal();
      }
    });
  });
</script>

        <br>
        <h4>> Nuestra Filosofía: Planifica. Cocina. Cuida tu salud.</h4>

        En SalCooking creemos que comer bien no debería ser complicado, costoso ni estresante. Nuestra filosofía parte de un principio sencillo pero poderoso: cuidar de tu bienestar empieza en tu plato.

        La web está diseñada para acompañarte desde la búsqueda de recetas a la confección de una dieta semanal y la preparación de tus comidas diarias, integrando de manera natural:



        <ul>
          <li><strong>🧬 Personalización total:</strong> Puedes configurar tu perfil con tus intolerancias, alergias y necesidades médicas.</li>
          <li><strong>🍽️ Creatividad:</strong> Sugerencias de recetas equilibradas y adaptadas a tus preferencias de salud</li>
          <li><strong>🧂Trucos de cocina:</strong> Que facilitan tu día a día y hacen de la cocina una experiencia agradable.</li>

        </ul>
        Todo ello con un compromiso firme: hacer que cuidar de tu salud sea fácil, de manera inteligente y sabrosa. SalCooking no es solo una herramienta, es un compañero de cocina que entiende tus necesidades reales y se adapta a tu vida.


        <!-- Faldón 2 -->
        <section class="faldon">
          <h2>Nuestros Ingredientes Clave</h2>
          <div class="ingredientes-clave">
            <div>❤️ Salud</div>
            <div>🧠Conocimiento</div>
            <div>😋 Sabor</div>
          </div>
          <h4>Tres valores que guían cada receta y cada decisión en SalCooking.</h4>
        </section>

      </div>

    </div>

  </div>
</section>
<?php include('footer.php'); ?>