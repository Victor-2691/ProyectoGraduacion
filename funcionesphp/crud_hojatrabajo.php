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

// // 1 select servicios

$codigoCrud = $_POST['codigoCrud'] ?? null;

if ($codigoCrud == 1) {
    $consulta = "select * from Servicios";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}

if($codigoCrud == 2){

    
}
