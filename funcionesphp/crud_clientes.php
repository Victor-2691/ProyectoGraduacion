<?php
session_start();
$autenticado = $_SESSION['login'];

if (!$autenticado) {
    header('location: index.php');
}

require '../includes/config/database.php';

$db = conectarBD();

// // 1 consulta todos los clientes
// // 2 insert
// // 3 modificar
//  4 consulta provincias

$codigoCrud = $_POST['codigoCrud'] ?? null;
$codigoProvincia = $_POST['codigoProvincia'] ?? null;

if ($codigoCrud == 1) {
    $consulta = "SELECT Clientes.nombre, Clientes.Primer_Apeliido, Clientes.segundo_apellid,
    Clientes.identificacion, Clientes.celular, Provincias.Nombre_Provincia, Cantones.Nombre_Canton
     FROM Clientes JOIN Provincias
    ON Clientes.id_provincia = Codigo_Provincia JOIN Cantones ON Cantones.Codigo_Canton = Clientes.id_canton";
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


if ($codigoCrud == 4) {
    $consulta = "SELECT * FROM Provincias";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}


if ($codigoCrud == 5) {
    $consulta = "SELECT * FROM Cantones WHERE Cantones.Codigo_Provincia = $codigoProvincia";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}