<?php

session_start();
if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
} else {
    header('location: ../../inicio_sesion.php');
}
require '../includes/config/database.php';
$db = conectarBD();
$fecha_actual = getdate();
$fecha_actual_completa = $fecha_actual['year'] . "-" . $fecha_actual['mon'] . "-" . $fecha_actual['mday'];
$id_usuario_perfil = $_POST['idusuario'] ?? null;

// Validar suspiro 
$consulta = "SELECT * FROM suspiros where id_usuario_envia = $sessionid and
id_usuario_recibe = $id_usuario_perfil AND Estado = 1" ;
$ejecutar = mysqli_query($db, $consulta);
$filasafectadas = mysqli_num_rows($ejecutar);

if($filasafectadas > 0){
echo 0;

}
else{
    // Si no lo insertamos en la BD
    $consulta = "INSERT INTO suspiros
(
id_usuario_envia,
id_usuario_recibe,
fecha,
Estado)
VALUES
( $sessionid,
$id_usuario_perfil,
'$fecha_actual_completa',
1)";
$ejecutar = mysqli_query($db, $consulta);

if($ejecutar){
echo 1;
}
else{
    echo 2;
    die(mysqli_error($db));

}

}






