<?php
session_start();
if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
} else {
    header('location: ../../inicio_sesion.php');
}
require '../includes/config/database.php';
$db = conectarBD();
$id_suspiro = $_POST['idhistorial'] ?? null;

$consulta = "UPDATE suspiros
SET
Estado = 2
WHERE id_historial = $id_suspiro" ;
$ejecutar = mysqli_query($db, $consulta);

if($ejecutar){
    echo 1;
}
else{
    echo 0;
}




?>