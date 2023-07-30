<?php
require 'includes/funciones.php';
incluirTempleate('header_interno');
// Conexion a base de datos
require 'includes/config/database.php';
$db = conectarBD();

if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
} else {
    header('location: inicio_sesion.php');
}

?>
<main class="contenedor_descrubrir">

    <p id="id_usuario" hidden><?php echo  $sessionid ?></p>
    <div class="card">
        <div class="content">
            <h2 id="nomb_perfil"> </h2>
            <p class="edad" id="edad_perfil"> Años</p>
            <p>A 8 Kilómetros de distancia</p>
            <div class="btn_contenedor_descubrir">

                <button class="btn_descrubrir atras">

                </button>

                <button id="btnnomegusta" onclick="nomegusta()" class="btn_descrubrir nomegusta">

                </button>

                <button onclick="" class="btn_descrubrir megusta">

                </button>

                <button onclick="saludame()" class="btn_descrubrir suspiro">

                </button>

                <button onclick="" class="btn_descrubrir perfil_descubrir">

                </button>

            </div>



        </div>

    </div>
    </div>



    <!-- <style>
        .card {
            background-image: url("data:image/<?php echo $extension ?>;base64,<?php echo base64_encode($imagen) ?>");

        }
    </style> -->
    <script>
        // document.addEventListener('DOMContentLoaded', function() {

        //     cargarperfiles() 

        //     // btnperfil();
        // });
    </script>

    <script>
        // const cuerpoDelDocumento = document.main;
        // cuerpoDelDocumento.onload = cargarperfiles;

        function cargarperfiles() {
       
            $.ajax({

                url: 'funcionesphp/prueba2.php',
                type: 'POST',

                beforesend: function() {
                    $('#mostrar_mensaje').html("Mensaje antes de Enviar");
                    console("Enviando peticion...")
                },

                success: function(mensaje, estado) {
                    var arrayDeCadenas = mensaje.split(',');
                    let nombre = arrayDeCadenas[0];
                    let edad = arrayDeCadenas[1] + " Años";
                    let extension = arrayDeCadenas[2];
                    let img = arrayDeCadenas[3];
                    $('#nomb_perfil').html(nombre);
                    $('#edad_perfil').html(edad);
                },

                Error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }

            });

        }
    </script>

</main>


<script>
    // $.get('funcionesphp/mostrarperfiles.php',function(informacion,estado){
    //      alert('informacion de php:' + informacion+ '\nEstado' + estado);
    // })

    $('#btnnomegusta').click(function(prueba1, prueba2) {
        $.get('funcionesphp/mostrarperfiles.php', function(mensaje, estado) {
            alert(mensaje);
            $('#prueba').html(mensaje);

        })

    })
</script>
<script>
    function saludame() {
        var id = document.querySelector('#id_usuario').innerText;

        var parametros = {
            "idusuario": id
        };

        $.ajax({
            data: parametros,
            url: 'funcionesphp/prueba2.php',
            type: 'POST',

            beforesend: function() {
                $('#mostrar_mensaje').html("Mensaje antes de Enviar");
                console("Enviando peticion...")
            },

            success: function(mensaje1) {
                $('#prueba').html(mensaje1);

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