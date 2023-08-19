<?php
session_start();
$autenticado = $_SESSION['login'];

if (!$autenticado) {
    header('location: index.php');
}

require '../includes/config/database.php';

$fecha_actual = getdate();
$fecha_actual_completa = $fecha_actual['year'] . "-" . $fecha_actual['mon'] . "-" . $fecha_actual['mday'];

$db = conectarBD();

// // 1 consulta todos los clientes
// // 2 insert
// // 3 modificar
//  4 consulta provincias

$codigoCrud = $_POST['codigoCrud'] ?? null;
$valorbuscar = $_POST['valorbuscar'] ?? null;



if ($codigoCrud == 1) {
    $consulta = "SELECT placa, Marca.nombre as marca, modelo.nombre as modelo , anno, id_cliente, Clientes.nombre as nombrecliente, Clientes.Primer_Apeliido, Clientes.segundo_apellid 
    FROM  Vehiculos, Clientes, modelo, Marca WHERE Vehiculos.id_cliente = Clientes.identificacion 
   AND Vehiculos.id_marca = Marca.idMarca AND  modelo.id_modelo = Vehiculos.id_modelo
   order by Vehiculos.fecha_registro DESC";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);

    // echo "<pre>";
    // var_dump($arreglo);
    // echo "<pre>";

    //  Covierte un arreglo a Json
    // Para indicar el formato de conversion en este caso para leer aceptos
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}


    // Buscar valores especificos placa
    if ($codigoCrud == 11) {
        $consulta = "SELECT placa, Marca.nombre as marca, modelo.nombre as modelo , anno, id_cliente, Clientes.nombre as nombrecliente, Clientes.Primer_Apeliido, Clientes.segundo_apellid 
        FROM  Vehiculos, Clientes, modelo, Marca WHERE Vehiculos.id_cliente = Clientes.identificacion 
       AND Vehiculos.id_marca = Marca.idMarca AND  modelo.id_modelo = Vehiculos.id_modelo 
       AND Vehiculos.placa LIKE '%$valorbuscar%'";
        $ejecutar = mysqli_query($db, $consulta);
        $nr = mysqli_num_rows($ejecutar);
        if ($nr > 0) {
            $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
            $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
            echo $json;
        } else {
            echo 0;
        }
        
    }
    
// Buscar Marca
    if ($codigoCrud == 12) {
        $consulta = "SELECT placa, Marca.nombre as marca, modelo.nombre as modelo , anno, id_cliente, Clientes.nombre as nombrecliente, Clientes.Primer_Apeliido, Clientes.segundo_apellid 
        FROM  Vehiculos, Clientes, modelo, Marca WHERE Vehiculos.id_cliente = Clientes.identificacion 
       AND Vehiculos.id_marca = Marca.idMarca AND  modelo.id_modelo = Vehiculos.id_modelo 
       AND Marca.nombre LIKE '%$valorbuscar%'";
        $ejecutar = mysqli_query($db, $consulta);
        $nr = mysqli_num_rows($ejecutar);
        if ($nr > 0) {
            $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
            $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
            echo $json;
        } else {
            echo 0;
        }
    }
// Buscar Id Cliente
    if ($codigoCrud == 13) {
        $consulta = "SELECT placa, Marca.nombre as marca, modelo.nombre as modelo , anno, id_cliente, Clientes.nombre as nombrecliente, Clientes.Primer_Apeliido, Clientes.segundo_apellid 
        FROM  Vehiculos, Clientes, modelo, Marca WHERE Vehiculos.id_cliente = Clientes.identificacion 
       AND Vehiculos.id_marca = Marca.idMarca AND  modelo.id_modelo = Vehiculos.id_modelo 
       AND Clientes.identificacion LIKE '$valorbuscar'";
        $ejecutar = mysqli_query($db, $consulta);
        $nr = mysqli_num_rows($ejecutar);
        if ($nr > 0) {
            $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
            $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
            echo $json;
        } else {
            echo 0;
        }
        echo die(mysqli_error($db));
    }

