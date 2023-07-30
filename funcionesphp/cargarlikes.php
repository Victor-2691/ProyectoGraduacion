<?php
session_start();
if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
} else {
    header('location: ../../inicio_sesion.php');
}
require '../includes/config/database.php';
$db = conectarBD();
$consulta = "SELECT C.nombre, C.edad, S.fecha, IM.tipo_imagen,IM.imagen, S.id_historial  FROM likes S JOIN Clientes_Externos C ON S.id_usuario_recibe = C.id_cliente
JOIN imagenes_clientes IM ON S.id_usuario_recibe = IM.id_cliente
where id_usuario_envia = $sessionid and Estado = 1 AND IM.imagen_perfil = 1
order by S.id_historial desc";
$ejecutar = mysqli_query($db, $consulta);

$arreglo = mysqli_fetch_all($ejecutar,MYSQLI_ASSOC);
$tipoimage= $arreglo['tipo_imagen'];
$image= $arreglo['imagen'];
// echo "<pre>";
// var_dump($arreglo);
// echo "<pre>";
 $rutaimage = "data:.$tipoimage;base64, base64_enconde($image)";
 echo "<pre>";
var_dump( $rutaimage);
echo "<pre>";

// $Jsonresponse = json_encode($arreglo);
// header('Content-Type: application/json');
// //  echo "<pre>";
// //     var_dump($Jsonresponse);
// //     echo "<pre>";
// echo $Jsonresponse;

// $resultado = $stmt->get_result();
// $miArreglo = $resultado->fetch_all(MYSQLI_ASSOC);

// // Convertir el arreglo a JSON
// $jsonResponse = json_encode($miArreglo);

// // Enviar la respuesta JSON al cliente
// header('Content-Type: application/json');
// echo $jsonResponse;

?>
<!-- // archivo.js

$.ajax({
  url: 'archivo.php',
  type: 'GET',
  dataType: 'json',
  success: function(response) {
    // Acceder a los datos JSON en la respuesta
    console.log(response);

    // Recorrer el arreglo asociativo
    $.each(response, function(key, value) {
      console.log(key + ': ' + value);
    });
  },
  error: function(xhr, status, error) {
    console.error(error);
  }
}); -->