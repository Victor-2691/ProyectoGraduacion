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

// // 1 consulta todos los vehiculos
// // 2 insert
// // 3 consulta marcas
//  4 consulta modelos
//  5 insertar vehiculo

$codigoCrud = $_POST['codigoCrud'] ?? null;
$valorbuscar = $_POST['valorbuscar'] ?? null;
$id_cliente = $_POST['id_cliente'] ?? null;
$placa = $_POST['placa'] ?? null;
$id_marca = $_POST['id_marca'] ?? null;
$id_modelo = $_POST['id_modelo'] ?? null;
$anno = $_POST['anno'] ?? null;
$fecha_actual = getdate();
$fecha_actual_completa = $fecha_actual['year'] . "-" . $fecha_actual['mon'] . "-" . $fecha_actual['mday'];



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

// Insertar vehiculo en BD codigo 2 insertar

if ($codigoCrud == 2) {
    //Validar que la placa no este repita
    $consulta = "SELECT * FROM Vehiculos WHERE placa = '$placa' ";
    $ejecutar = mysqli_query($db, $consulta);
    $nr = mysqli_num_rows($ejecutar);
    if ($ejecutar) {
        if ($nr > 0) {
            echo 0;
        } else {

            $consulta2 = "INSERT INTO Vehiculos
            (`id_cliente`,
            `placa`,
            `id_marca`,
            `id_modelo`,
            `anno`,
            `fecha_registro`)
            VALUES
            ($id_cliente,
            $placa,
            $id_marca,
            $id_modelo,
            $anno,
            $fecha_actual_completa)";
            $ejecutar2 = mysqli_query($db, $consulta2);

            if ($ejecutar2) {
                echo 1;
            } else {
                echo (mysqli_error($db));
            }
        }
    } else {

        echo die(mysqli_error($db));
    }
}


if ($codigoCrud == 3) {
    $consulta = "SELECT * FROM Marca";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}

if ($codigoCrud == 4) {
    $consulta = "SELECT * FROM modelo WHERE id_marca = '$id_marca'";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}

if ($codigoCrud == 5) {
    //    Validar placa llave
    $consulta = "SELECT * FROM Vehiculos WHERE placa = '$placa'";
    $ejecutar = mysqli_query($db, $consulta);
    if ($ejecutar) {
        $nr = mysqli_num_rows($ejecutar);
        if ($nr > 0) {
            echo 0;
            exit;
        }
    } else {
        echo die(mysqli_error($db));
        exit;
    }

    $consulta2 = "INSERT INTO Vehiculos
    (`id_cliente`,
    `placa`,
    `id_marca`,
    `id_modelo`,
    `anno`,
    `fecha_registro`)
    VALUES
    ('$id_cliente',
    '$placa',
    '$id_marca',
    '$id_modelo',
    '$anno',
    '$fecha_actual_completa')";
    $ejecutar2 = mysqli_query($db, $consulta2);
    if ($ejecutar2) {
        echo 1;
        exit;
    } else {
        echo die(mysqli_error($db));
        exit;
    }
}
