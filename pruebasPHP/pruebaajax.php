<?php
require 'includes/funciones.php';
incluirTempleate('header_interno');
// Conexion a base de datos
require 'includes/config/database.php';
$db = conectarBD();

if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
    $nombreusuario = $_SESSION['nombre'];
} else {
    header('location: inicio_sesion.php');
}


?>

<main>

<button onclick="prueba()">
PRUEBA
</button>

</main>


<script>
    function prueba(){
      


        var parametros = {
            "latidud": 15,
            "longitud": -20
        
        };

        $.ajax({
            data: parametros,
            url: 'funcionesphp/registraubicacion.php',
            type: 'POST',

            
            beforesend: function() {
                    $('#mostrar_mensaje').html("Mensaje antes de Enviar");
                    console("Enviando peticion...")
                },


            success: function(mensaje) {

                if (mensaje == 1) {
                    location.reload();

                }

                if (mensaje == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'error!',

                    })
                    setInterval("location.reload()", 2000);
                }
            },

            Error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }
    
</script>


<?php
incluirTempleate('footer');
?>