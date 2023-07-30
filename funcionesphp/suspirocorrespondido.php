<?php
session_start();
if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
} else {
    header('location: ../../inicio_sesion.php');
}
require '../includes/config/database.php';
$db = conectarBD();
$id_historial = $_POST['idhistorial'] ?? null;

$consulta = "UPDATE suspiros
SET
Estado = 4
WHERE id_historial = $id_historial" ;
$ejecutar = mysqli_query($db, $consulta);
if($ejecutar){
    echo 1;
}
else{
    echo 0;
}
