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
if ($arreglo['Estado'] == 1) {
    $consulta = " SELECT Clientes_Externos.nombre, Clientes_Externos.edad,
    Clientes_Externos.id_cliente, imagenes_clientes.tipo_imagen, 
    imagenes_clientes.imagen
   FROM Clientes_Externos JOIN imagenes_clientes ON Clientes_Externos.id_cliente =
   imagenes_clientes.id_cliente JOIN  Usuarios_Clientes_Externo ON Clientes_Externos.id_cliente =
     Usuarios_Clientes_Externo.id_cliente
    WHERE imagenes_clientes.imagen_perfil = 1 AND Usuarios_Clientes_Externo.Estado = 0
    AND Usuarios_Clientes_Externo.id_cliente <> $sessionid
    ORDER BY rand() LIMIT 1";
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
            // Si el usuario concetado y el que visualiza el perfil tiene las cordenadas se calcula
            $cordeUsuarioConectado = mysqli_fetch_assoc($ejecutar);
            $cordeUsuarioPerfil = mysqli_fetch_assoc($ejecutar2);

            // Radio de la Tierra en kilómetros
            $latitud1 = $cordeUsuarioConectado['latitud'];
            $longitud1 = $cordeUsuarioConectado['longitud'];
            $latitud2 = $cordeUsuarioPerfil['latitud'];
            $longitud2 = $cordeUsuarioPerfil['longitud'];
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
            $resultadodistancia = " A " . round($distancia) . " Kilómetros de distancia";
        }
    } else {

        $resultadodistancia = '';
    }

    // 

} else {
    $consulta = "SELECT Clientes_Externos.id_genero_buscador, generos_buscando.nombre_genero FROM Clientes_Externos JOIN generos_buscando ON
    Clientes_Externos.id_genero_buscador = generos_buscando.id_genero
     WHERE id_cliente = $sessionid";
    $ejecutar = mysqli_query($db, $consulta);
    $arregloasoc = mysqli_fetch_assoc($ejecutar);
    $generobuscado = $arregloasoc['id_genero_buscador'];
    $nombregenerobuscado = $arregloasoc['nombre_genero'];



    switch ($generobuscado) {
            //   Busca hombres
        case 1:
            $consulta = " SELECT Clientes_Externos.nombre, Clientes_Externos.edad,
            Clientes_Externos.id_cliente, imagenes_clientes.tipo_imagen, 
            imagenes_clientes.imagen
           FROM Clientes_Externos JOIN imagenes_clientes ON Clientes_Externos.id_cliente =
           imagenes_clientes.id_cliente JOIN  Usuarios_Clientes_Externo ON Clientes_Externos.id_cliente =
             Usuarios_Clientes_Externo.id_cliente
            WHERE imagenes_clientes.imagen_perfil = 1 AND Usuarios_Clientes_Externo.Estado = 0
            AND Clientes_Externos.id_genero_pertenece = $generobuscado
            AND Usuarios_Clientes_Externo.id_cliente <> $sessionid
            ORDER BY rand() LIMIT 1";
            $ejecutar = mysqli_query($db, $consulta);

            foreach ($ejecutar as $key => $opciones) :
                $idPerfil =  $opciones['id_cliente'];
                $nombre =  $opciones['nombre'];
                $edad =  $opciones['edad'];
                $extension = $opciones['tipo_imagen'];
                $imagen =  $opciones['imagen'];
            endforeach;
            break;
            // Calucla distancia
            // Validar que los dos usuarios tenga la distancia
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
                    // Si el usuario concetado y el que visualiza el perfil tiene las cordenadas se calcula
                    $cordeUsuarioConectado = mysqli_fetch_assoc($ejecutar);
                    $cordeUsuarioPerfil = mysqli_fetch_assoc($ejecutar2);

                    // Radio de la Tierra en kilómetros
                    $latitud1 = $cordeUsuarioConectado['latitud'];
                    $longitud1 = $cordeUsuarioConectado['longitud'];
                    $latitud2 = $cordeUsuarioPerfil['latitud'];
                    $longitud2 = $cordeUsuarioPerfil['longitud'];
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
                    $resultadodistancia = " A " . round($distancia) . " Kilómetros de distancia";
                }
            } else {

                $resultadodistancia = '';
            }

            // Busca mujeres
        case 2:
            $consulta = " SELECT Clientes_Externos.nombre, Clientes_Externos.edad,
            Clientes_Externos.id_cliente, imagenes_clientes.tipo_imagen, 
            imagenes_clientes.imagen
           FROM Clientes_Externos JOIN imagenes_clientes ON Clientes_Externos.id_cliente =
           imagenes_clientes.id_cliente JOIN  Usuarios_Clientes_Externo ON Clientes_Externos.id_cliente =
             Usuarios_Clientes_Externo.id_cliente
            WHERE imagenes_clientes.imagen_perfil = 1 AND Usuarios_Clientes_Externo.Estado = 0
            AND Clientes_Externos.id_genero_pertenece = $generobuscado
            AND Usuarios_Clientes_Externo.id_cliente <> $sessionid
            ORDER BY rand() LIMIT 1";
            $ejecutar = mysqli_query($db, $consulta);
            foreach ($ejecutar as $key => $opciones) :
                $idPerfil =  $opciones['id_cliente'];
                $nombre =  $opciones['nombre'];
                $edad =  $opciones['edad'];
                $extension = $opciones['tipo_imagen'];
                $imagen =  $opciones['imagen'];
            endforeach;
            // Calcula Distancia
            // Validar que los dos usuarios tenga la distancia
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
                    // Si el usuario concetado y el que visualiza el perfil tiene las cordenadas se calcula
                    $cordeUsuarioConectado = mysqli_fetch_assoc($ejecutar);
                    $cordeUsuarioPerfil = mysqli_fetch_assoc($ejecutar2);

                    // Radio de la Tierra en kilómetros
                    $latitud1 = $cordeUsuarioConectado['latitud'];
                    $longitud1 = $cordeUsuarioConectado['longitud'];
                    $latitud2 = $cordeUsuarioPerfil['latitud'];
                    $longitud2 = $cordeUsuarioPerfil['longitud'];
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
                    $resultadodistancia = " A " . round($distancia) . " Kilómetros de distancia";
                }
            } else {

                $resultadodistancia = '';
            }


            break;
            // Busca ambos
        case 3:
            $consulta = " SELECT Clientes_Externos.nombre, Clientes_Externos.edad,
            Clientes_Externos.id_cliente, imagenes_clientes.tipo_imagen, 
            imagenes_clientes.imagen
           FROM Clientes_Externos JOIN imagenes_clientes ON Clientes_Externos.id_cliente =
           imagenes_clientes.id_cliente JOIN  Usuarios_Clientes_Externo ON Clientes_Externos.id_cliente =
             Usuarios_Clientes_Externo.id_cliente
            WHERE imagenes_clientes.imagen_perfil = 1 AND Usuarios_Clientes_Externo.Estado = 0
            AND Usuarios_Clientes_Externo.id_cliente <> $sessionid
            ORDER BY rand() LIMIT 1";
            $ejecutar = mysqli_query($db, $consulta);
            foreach ($ejecutar as $key => $opciones) :
                $idPerfil =  $opciones['id_cliente'];
                $nombre =  $opciones['nombre'];
                $edad =  $opciones['edad'];
                $extension = $opciones['tipo_imagen'];
                $imagen =  $opciones['imagen'];
            endforeach;
            // Calcula Distancia
          // Validar que los dos usuarios tenga la distancia
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
        // Si el usuario concetado y el que visualiza el perfil tiene las cordenadas se calcula
        $cordeUsuarioConectado = mysqli_fetch_assoc($ejecutar);
        $cordeUsuarioPerfil = mysqli_fetch_assoc($ejecutar2);
    
        // Radio de la Tierra en kilómetros
        $latitud1 = $cordeUsuarioConectado['latitud'];
        $longitud1 = $cordeUsuarioConectado['longitud'];
        $latitud2 = $cordeUsuarioPerfil['latitud'];
        $longitud2 = $cordeUsuarioPerfil['longitud'];
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
        $resultadodistancia = " A " . round($distancia) . " Kilómetros de distancia";
    }
} else {

    $resultadodistancia = '';
}

            break;
    }
}



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