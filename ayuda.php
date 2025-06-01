<?php
$css_extra = '';

$css_extra .= '<link rel="stylesheet" href="styles/ayuda.css?v=' . filemtime('styles/ayuda.css') . '">';
?>



<?php include 'header.php'; ?>

<!-- migas -->

<div class="migas-container">
  <div class="container migas-flex">
    <ul class="migas">
      <li><a href="index.php">Inicio</a></li>
      <li class="current">Ayuda</li>
    </ul>
    <div class="volver-atras-contenedor">
      <a href="javascript:history.back()" class="volver-atras"><img src="sources/iconos/Arrow-Thick-Left-3--Streamline-Ultimate.svg" width="32px" alt="icono atrás" title="Pantalla anterior"></a>
    </div>
  </div>
</div>



<!-- Contenido principal-->
<section class="Ayuda">
    <div class="contenedor-Ayuda">

    <div class="titulo">
  <img src="sources/iconos/Headphones-Customer-Support-Question--Streamline-Ultimate.svg"  alt="Book Star - Libro destacado">
  <h1>Ayuda</h1>
  </div>
       
    <div class="contenido-Ayuda">
        
    <img src="sources/iconos/Information-Circle--Streamline-Ultimate.svg"  alt="Book Star - Libro destacado">
    <img src="sources/iconos/Question-Help-Message--Streamline-Ultimate.svg"  alt="Book Star - Libro destacado">
 
    <p>Texto de la Ayuda</p>

    <h2 class="faq-titulo">Preguntas Frecuentes</h2>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Qué incluye el plan Prémium de SalCooking?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">El plan Prémium permite filtrar recetas por enfermedades, generar menús diarios o semanales, crear listas de la compra automáticas y marcar recetas como favoritas.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Cuánto cuesta la suscripción Prémium?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">La suscripción Prémium cuesta 10 € al mes. Con ella, se desbloquean todas las funcionalidades avanzadas.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Puedo usar SalCooking sin registrarme?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">Sí. Como visitante puedes buscar recetas básicas y ver sus alérgenos, así como consultar el blog de trucos de cocina.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Qué tipo de recetas ofrece SalCooking?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">Recetas saludables categorizadas como entrantes, principales, postres, desayunos o cenas, con ingredientes sencillos y compatibles con diferentes restricciones alimentarias.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Las recetas están adaptadas a alergias e intolerancias?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">Sí. Puedes filtrar las recetas para evitar alérgenos comunes como gluten, lactosa, frutos secos, etc. Esta opción está disponible para usuarios registrados o prémium.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Puedo buscar recetas compatibles con enfermedades como la diabetes o la hipertensión?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">Sí. SalCooking ofrece un buscador avanzado por enfermedades, exclusivo para usuarios con cuenta Prémium.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿SalCooking sustituye la opinión de un médico o nutricionista?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">No. Aunque el contenido es supervisado por un equipo de nutricionistas y profesionales de cocina, debes consultar siempre con tu médico antes de realizar cambios importantes en tu dieta.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Puedo crear perfiles distintos si cocino para más de una persona?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">Sí. Los usuarios registrados o prémium pueden crear hasta dos perfiles con condiciones de salud distintas, ideales para familias o parejas.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Puedo descargar las recetas?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">Solo los usuarios registrados o prémium pueden descargar recetas en formato PDF desde la ficha de cada plato.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>¿Cómo puedo activar mi cuenta Prémium?</span>
                    <img src="sources/iconos/Chevron-Down--Streamline-Ultimate.svg" alt="Desplegar" class="faq-icon">
                </div>
                <div class="faq-answer">Haz clic en "Hazte Prémium", sigue los pasos del formulario, realiza el pago externo y recibirás un código de activación que podrás introducir en tu perfil.</div>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const item = question.parentElement;
                const isOpen = item.classList.contains('active');
                
                // Cerrar todos los demás ítems
                document.querySelectorAll('.faq-item').forEach(i => {
                    i.classList.remove('active');
                });
                
                // Abrir el ítem clickeado si no estaba abierto
                if (!isOpen) {
                    item.classList.add('active');
                }
            });
        });
    });
    </script>
    
    <!-- div contenido -->
    </div>

    
   

    <!-- ultimo div contenedor principal -->
    </div>
</section>

<?php include 'footer.php'; ?>