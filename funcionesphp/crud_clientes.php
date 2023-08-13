<?php
session_start();
$autenticado = $_SESSION['login'];

if (!$autenticado) {
    header('location: index.php');
}

require '../includes/config/database.php';

$db = conectarBD();


//este es un array
// $array_pago_contador = $_post["mi_dato_1"];

//este es una variable normal
// $codigoCrud = $_post["codigoCrud"];

// echo "<pre>";
// var_dump($codigoCrud);
// echo "<pre>";
// $_post = json_decode(file_get_contents('php://input'),true);

// //este es un array
// $array_pago_contador = $_post["mi_dato_1"];

// //este es una variable normal
// $estado_envio_contador = $_post["mi_dato_2"];

// echo "<pre>";
// var_dump($estado_envio_contador);
// echo "<pre>";

// // 1 consulta
// // 2 insert
// // 3 modificar

// $_post = json_decode(file_get_contents('php://input'),true);
// // echo "<pre>";
// // var_dump($datos);
// // echo "<pre>";

// $array_pago_contador = $_post["data2"];

$codigoCrud = $_POST['codigoCrud'] ?? null;

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
