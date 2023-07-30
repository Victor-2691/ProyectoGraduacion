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

// Codigo para enviar parametros por el header

// header("Location:perfilusuariodescubrir.php?mensaje=estaesunaprueba&mensaje2=estaotromensaje");

// $mensaje = $_GET['mensaje'];
// <?php header("Location:perfilusuariodescubrir.php?id=$idCliente"
?>
<?php




$consulta4 = "select Estado from Usuarios_Clientes_Externo where id_cliente = $sessionid";
$ejecutar4 = mysqli_query($db, $consulta4);

$arreglo = mysqli_fetch_assoc($ejecutar4);
// 1 incompleto

$consulta = " SELECT Clientes_Externos.nombre, Clientes_Externos.edad,
    Clientes_Externos.id_cliente, imagenes_clientes.tipo_imagen, 
    imagenes_clientes.imagen
   FROM Clientes_Externos JOIN imagenes_clientes ON Clientes_Externos.id_cliente =
   imagenes_clientes.id_cliente JOIN  Usuarios_Clientes_Externo ON Clientes_Externos.id_cliente =
     Usuarios_Clientes_Externo.id_cliente
    WHERE imagenes_clientes.imagen_perfil = 1 AND Usuarios_Clientes_Externo.Estado = 0
    AND Usuarios_Clientes_Externo.id_cliente = 1";
$ejecutar = mysqli_query($db, $consulta);
foreach ($ejecutar as $key => $opciones) :
    $idPerfil =  $opciones['id_cliente'];
    $nombre =  $opciones['nombre'];
    $edad =  $opciones['edad'];
    $extension = $opciones['tipo_imagen'];
    $imagen =  $opciones['imagen'];
endforeach;

// Calcular la distancia entre usuarios
// Validar que los dos usuarios tenga la distancia
$consulta = "SELECT * FROM Geolocalizacion WHERE id_cliente = $sessionid";
$ejecutar = mysqli_query($db, $consulta);


$consulta2 = "SELECT * FROM Geolocalizacion WHERE id_cliente = $idPerfil ";
$ejecutar2 = mysqli_query($db, $consulta2);
// echo "<pre>";
// var_dump($ejecutar);
// echo "<pre>";
// echo "<pre>";
// var_dump($ejecutar2);
// echo "<pre>";

// Usuario conectado tiene la ubicacion 
if (mysqli_num_rows($ejecutar) > 0) {
    if (mysqli_num_rows($ejecutar2) > 0) {
        echo "entre al if";
        // Si el usuario concetado y el que visualiza el perfil tiene las cordenadas se calcula
        $cordeUsuarioConectado = mysqli_fetch_assoc($ejecutar);
        $cordeUsuarioPerfil = mysqli_fetch_assoc($ejecutar2);
        echo "<pre>";
        var_dump($cordeUsuarioConectado);
        echo "<pre>";
        // echo "<pre>";
        // var_dump( $cordeUsuarioPerfil );
        // echo "<pre>";
        // Radio de la Tierra en kilómetros
        $latitud1 = $cordeUsuarioConectado['latitud'];
        $longitud1 = $cordeUsuarioConectado['longitud'];
        $latitud2 = $cordeUsuarioPerfil['latitud'];
        $longitud2 = $cordeUsuarioPerfil['longitud'];
        echo "</br>";
        echo $latitud1;
        echo "</br>";
        echo $longitud1;
        echo "</br>";
        echo $latitud2;
        echo "</br>";
        echo $longitud2;


        $radioTierra = 6371;
        // Convertir las latitudes y longitudes de grados a radianes
        $latitud1Rad = deg2rad($latitud1);
        $longitud1Rad = deg2rad($longitud1);
        $latitud2Rad = deg2rad($latitud2);
        $longitud2Rad = deg2rad($longitud2);

        // Calcular la diferencia de latitudes y longitudes
        $diferenciaLatitudes = $latitud2Rad - $latitud1Rad;
        $diferenciaLongitudes = $longitud2Rad - $longitud1Rad;

        // Calcular la distancia entre los dos puntos utilizando la fórmula de Haversine
        $a = sin($diferenciaLatitudes / 2) * sin($diferenciaLatitudes / 2) +
            cos($latitud1Rad) * cos($latitud2Rad) *
            sin($diferenciaLongitudes / 2) * sin($diferenciaLongitudes / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distancia = $radioTierra * $c;
        // echo $distancia;
        // echo "<pre>";
        // var_dump($distancia);
        // echo "<pre>";

        $resultadodistancia = " A " . round($distancia) . " Kilómetros de distancia";

        echo "<pre>";
        var_dump($resultadodistancia);
        echo "<pre>";
    }
} else {

    $resultadodistancia = '';
}


// For Loop 2 al 10
// for ($i = 2; $i < 11; $i++) :
//     $consulta2 = "INSERT INTO  Geolocalizacion
//     (id_cliente,latitud,longitud)
//     VALUES
//     ($i, 9.93025 ,-84.05926)";
//     $ejecutar2 = mysqli_query($db, $consulta2);
// endfor;

// // For Loop 11 al 21
// for ($i = 11; $i < 22; $i++) :
//     $consulta2 = "INSERT INTO  Geolocalizacion
//     (id_cliente,latitud,longitud)
//     VALUES
//     ($i, 9.914697 ,-84.023012)";
//     $ejecutar2 = mysqli_query($db, $consulta2);
// endfor;

// // For Loop 28 al 33
// for ($i = 67; $i < 71; $i++) :
//     $consulta2 = "INSERT INTO  Geolocalizacion
//     (id_cliente,latitud,longitud)
//     VALUES
//     ($i,  9.947799,  -84.135167)";
//     $ejecutar2 = mysqli_query($db, $consulta2);
// endfor;
// // 




?>



<main class="contenedor_descrubrir">

    <p id="id_usuario_perfil" hidden><?php echo $idPerfil ?></p>

    <div class="card">
        <div class="content">
            <h2> <?php echo $nombre ?> <span class="edad"> <?php echo $edad ?> Años</span> </h2>

            <p> <?php echo  $resultadodistancia ?> </p>

            <div class="btn_contenedor_descubrir">
                <!-- BTN ATRAS -->
                <button class="btn_descrubrir atras">
                </button>

                <!-- BTN NO ME GUSTA -->
                <button onclick="btndescrubrir()" class="btn_descrubrir nomegusta">
                </button>


                <!-- BTN Me gusta -->
                <button onclick="insertalike()" class="btn_descrubrir megusta">
                </button>


                <!-- BTN Suspiro -->
                <button onclick="insertasuspiro()" class="btn_descrubrir suspiro">
                </button>


                <!-- BTN Ver Pefil -->
                <button onclick="btnperfil()" class="btn_descrubrir perfil_descubrir">
                </button>


            </div>

        </div>

    </div>
    </div>

    <div>
        <h1 hidden></h1>
    </div>

    <style>
        .card {
            background-image: url("data:image/<?php echo $extension ?>;base64,<?php echo base64_encode($imagen) ?>");

        }
    </style>

    <script type="text/javascript">
        function btnperfil() {
            var id = document.querySelector('#id_usuario_perfil').innerText;
            console.log(id);
            // window.location = 'perfilusuariodescubrir.php';
            window.location = `perfilusuariodescubrir.php?id=${id}`;
        }
    </script>

    <script type="text/javascript">
        function btndescrubrir() {
            location.reload();
        }
    </script>


    <!-- Funcion para insertar Suspiros -->
    <script>
        function insertasuspiro() {
            var id = document.querySelector('#id_usuario_perfil').innerText;

            var parametros = {
                "idusuario": id
            };

            $.ajax({
                data: parametros,
                url: 'funcionesphp/insertarsuspiros.php',
                type: 'POST',

                beforesend: function() {
                    $('#mostrar_mensaje').html("Mensaje antes de Enviar");
                    console("Enviando peticion...")
                },

                success: function(mensaje) {

                    if (mensaje == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Ya le habias dado suspiros a esta persona!',
                            showConfirmButton: false,
                        })
                        setInterval("location.reload()", 1000);

                    }

                    if (mensaje == 1) {
                        Swal.fire({
                            position: '',
                            icon: 'success',
                            title: 'Suspiro registrado',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval("location.reload()", 1000);

                    }

                    if (mensaje == 2) {
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

    <!-- Funcion para insertar LIKES -->
    <script>
        function insertalike() {
            var id = document.querySelector('#id_usuario_perfil').innerText;

            var parametros = {
                "idusuario": id
            };

            $.ajax({
                data: parametros,
                url: 'funcionesphp/insertalike.php',
                type: 'POST',

                beforesend: function() {
                    $('#mostrar_mensaje').html("Mensaje antes de Enviar");
                    console("Enviando peticion...")
                },

                success: function(mensaje) {

                    if (mensaje == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Ya le habias dado like a esta persona!',
                            showConfirmButton: false,
                        })
                        setInterval("location.reload()", 1000);

                    }

                    if (mensaje == 1) {
                        Swal.fire({
                            position: '',
                            icon: 'success',
                            title: 'like registrado',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setInterval("location.reload()", 1000);

                    }

                    if (mensaje == 2) {
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


</main>






<?php
incluirTempleate('footer');
?>