<?php
// footer.php
?>
<footer class="main-footer">
    <div class="container">
        <!-- parte de arriba footer -->
        <div class="footer-grid">
            <!-- columna 1 -->
            <div class="footer-column">
                <h4>Compañia</h4>
                <ul>
                    <li><a href="about.php">¿Quienes somos?</a></li>
                </ul>
            </div>
            <!-- columna 2 -->
            <div class="footer-column">
                <h4>Enlaces rápidos</h4>
                <ul class="footer-links">
                    <li><a href="planes.php">Planes de suscripción</a></li>
                    <li><a href="ayuda.php">Ayuda</a></li>
                    <li><a href="profile.php">Editar Perfil</a></li>
                    <li><a href="sitemap.php">Sitemap</a></li>
                </ul>
            </div>
            <!-- columna 3 -->
            <div class="footer-column">
                <h5>Píde nuestro boletín o síguenos en RRSS</h5>
                <form class="subscribe-form">
                    <input type="email" placeholder="Tu email">
                    <div class="btn-suscribir"><button type="submit">Suscribir</button></div>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/SalCooking" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/SalCooking" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/SalCooking" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </form>

            </div>
        </div>
        <!-- parte de abajo footer -->
        <div class="footer-bottom">
            <!-- columna 1 -->

            <div class="footer-column">

                <div class="copyright">
                    <p>Copyright © 2025 TeachDevAi Design. All Rights Reserved</p>
                </div>

            </div>


        </div>


</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/scripts/bootstrap.bundle.min.js"></script>
<script src="scripts/scripts.js"></script>

<!-- jsPDF (UMD version es preferible para compatibilidad con plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> <!-- Cambio: Usar jspdf.umd.min.js -->

<!-- AutoTable plugin (debe ir después de jsPDF) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<!-- Tu función personalizada -->
<?php

echo '<script src="scripts/descargarListaPDF.js"></script>'; // Para la lista de compra
echo '<script src="scripts/descargarFichaReceta.js"></script>'; // Para la ficha de receta
?>


</body>

</html>