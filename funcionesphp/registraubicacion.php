<?php
session_start();
if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
} else {
    header('location: ../../inicio_sesion.php');
}
require '../includes/config/database.php';
$db = conectarBD();
$latidud = $_POST['latidud'];
$longitud = $_POST['longitud'];

$consulta = "SELECT * FROM Geolocalizacion WHERE id_cliente = $sessionid";
$ejecutar = mysqli_query($db, $consulta);

// Insertar 
if (mysqli_num_rows($ejecutar) == 0) {
    $consulta2 = "INSERT INTO  Geolocalizacion
(id_cliente,latitud,longitud)
VALUES
($sessionid,$latidud,$longitud)";
    $ejecutar2 = mysqli_query($db, $consulta2);
    if ($ejecutar2) {
        echo 1;
    } else {
        die(mysqli_error($db));
        echo 0;
    }
}
// Actualizar
else {
    $consulta3 = "UPDATE Geolocalizacion
    SET
    latitud = $latidud,
    longitud = $longitud
    WHERE id_cliente = $sessionid";
    $ejecutar3 = mysqli_query($db, $consulta3);

    if ($ejecutar3) {
        echo 1;
    } else {
        die(mysqli_error($db));
        echo 0;
    }
}
