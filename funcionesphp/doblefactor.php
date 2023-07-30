<?php
require '../includes/config/database.php';
$db = conectarBD();
session_start();
$correousuario = $_POST['correo'] ?? null;

$_SESSION['nombredelusuario'] = $correousuario;

$consulta = "select Estado from Usuarios_Clientes_Externo where correo_electronico = '$correousuario' ";
$ejecutar = mysqli_query($db, $consulta);
$arreglo = mysqli_fetch_assoc($ejecutar );

if($arreglo['Estado'] == 1){
    // echo $_SESSION['nombredelusuario'];
echo 1;
}

else{
echo 0;
}
