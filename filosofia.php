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
      <a href="javascript:history.back()" class="volver-atras"><img src="images/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás"></a>
    </div>
  </div>
</div>

<section class="filosofia">
  <div class="contenedor-filosofia">

  <div class="titulo">
  <img src="images/iconos/Book-Star--Streamline-Ultimate.svg"  alt="Book Star - Libro destacado">
  <h1>Nuestra Filosofía: El arte de cocinar cuidando tu salud</h1>
  </div>
 
    <div class="contenido-filosofia">

      <div class="foto">
        <img src="images/recursos/nosotros.png" alt="Foto nosotros" width="300px">
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
       

        <h4>> Nuestra Filosofía: Planifica. Cocina. Cuida tu salud.</h4>

        En SalCooking creemos que comer bien no debería ser complicado, costoso ni estresante. Nuestra filosofía parte de un principio sencillo pero poderoso: cuidar de tu bienestar empieza en tu plato.

        La web está diseñada para acompañarte desde la búsqueda de recetas a la confección de una dieta semanal y la preparación de tus comidas diarias, integrando de manera natural:



        <ul>
          <li><strong>Personalización total:</strong> Puedes configurar tu perfil con tus intolerancias, alergias y necesidades médicas.</li>
          <li><strong>Creatividad:</strong> Sugerencias de recetas equilibradas y adaptadas a tus preferencias de salud</li>
          <li><strong>Trucos de cocina:</strong> Que facilitan tu día a día y hacen de la cocina una experiencia agradable.</li>

        </ul>
        Todo ello con un compromiso firme: hacer que cuidar de tu salud sea fácil, de manera inteligente y sabrosa. SalCooking no es solo una herramienta, es un compañero de cocina que entiende tus necesidades reales y se adapta a tu vida.


        <!-- Faldón 2 -->
        <section class="faldon">
          <h2>Nuestros Ingredientes Clave</h2>
          <div class="ingredientes-clave">
            <div>❤️ Salud</div>
            <div>🧠Inteligencia</div>
            <div>😋 Sabroso</div>
          </div>
          <h4>Tres valores que guían cada receta y cada decisión en SalCooking.</h4>
        </section>

      </div>

    </div>

  </div>
</section>
<?php include('footer.php'); ?>