<footer class="footer">
    <div class="contenedor contenedor-footer">
        <?php
        // Obtener fecha del servidor le pasamos el formato
        // y miniscula solo year corto 22 y Y imprime completo 2022
        $fecha =  date('Y');
        ?>
        <p class="copyright">Todos los derechos Reservados <?php echo date('Y') ?> &copy;</p>
        <a href="#" target="_blank">
            <img class="footer " src="build/img/icons8-facebook.svg" alt="icono-facebook">
        </a>
        <a href="#" target="_blank">
            <img class="footer " src="build/img/icons8-instagram.svg" alt="icono-telegran">

        </a>

        <a href="https://wa.me/50671381640?text=Hola%20escribo%20a%20la%20linea%20de%20soporte%20ya%20que%20necesito%20ayuda%20con%20el%20siguiente%20tema" target="_blank">
            <img src="build/img/icons8-whatsapp (7).svg" alt="icono-What">

        </a>
    </div>

    <div class="contenedor_footer_movil">
        <a href="descubrir.php"><img class="iconos25" src="https://img.icons8.com/ios-glyphs/30/000000/search-client.png"/></a>

        <a href="like.php"> <img class="iconos25" src="https://img.icons8.com/ios/50/null/delivery-time--v2.png"/> </a>

        <a href="suspiros.php"> 
        <img class="iconos25" src="build/img/suspiroblanco.svg"/>
     
        </a>

        <a href="salir.php">
        <img class="iconos25" src="build/img/cerrar-sesion.png"/>
        </a>
        
        <a href="perfil.php">
        <img class="iconos25" src="https://img.icons8.com/ios-glyphs/30/null/user--v1.png"/>
        </a>

    </div>

</footer>
<script src="build/js/bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
     crossorigin=""></script>


</body>

</html>