<footer class="footer">
    <div class="contenedor contenedor-footer_externo">
        <?php
        // Obtener fecha del servidor le pasamos el formato
        // y miniscula solo year corto 22 y Y imprime completo 2022
        $fecha =  date('Y');
        ?>
        <p class="copyright">Todos los derechos Reservados <?php echo date('Y') ?> &copy;</p>
        <a href="#" target="_blank">
            <img class="footer " src="build/img/icons8-facebook.svg" alt="icono-facebook">
        </a>
     

        <a href="https://wa.me/50671381640?text=Hola%20escribo%20a%20la%20linea%20de%20soporte%20ya%20que%20necesito%20ayuda%20con%20el%20siguiente%20tema" target="_blank">
            <img src="build/img/icons8-whatsapp (7).svg" alt="icono-What">

        </a>
    </div>


</footer>
<script src="build/js/bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>

</body>

</html>