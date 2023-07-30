<?php

session_start();
if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
} else {
    header('location: ../../inicio_sesion.php');
}
require '../includes/config/database.php';
$db = conectarBD();


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
            $idCliente =  $opciones['id_cliente'];
            $nombre =  $opciones['nombre'];
            $edad =  $opciones['edad'];
            $extension = $opciones['tipo_imagen'];
            $imagen =  $opciones['imagen'];
        endforeach;
        break;

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
            $idCliente =  $opciones['id_cliente'];
            $nombre =  $opciones['nombre'];
            $edad =  $opciones['edad'];
            $extension = $opciones['tipo_imagen'];
            $imagen =  $opciones['imagen'];

        endforeach;

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
            $idCliente =  $opciones['id_cliente'];
            $nombre =  $opciones['nombre'];
            $edad =  $opciones['edad'];
            $extension = $opciones['tipo_imagen'];
            $imagen =  $opciones['imagen'];
        endforeach;

        break;
}



echo $nombre. "," . $edad. ",". $extension ."," . $imagen;

?>

<style>
        .card {
            background-image: url("data:image/<?php echo $extension ?>;base64,<?php echo base64_encode($imagen) ?>");

        }
    </style>
