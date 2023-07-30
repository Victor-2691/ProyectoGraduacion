<?php

// Conexion a base de datos
require 'includes/config/database.php';
$db = conectarBD();

require 'includes/funciones.php';
incluirTempleate('header_externo');


$consulta = "select * from imagenes_clientes  where id_cliente = 6 and imagen_perfil =1 ";
$ejecutar = mysqli_query($db, $consulta);
foreach ($ejecutar as $key => $opciones) :
   echo  $opciones['id_imagen'];
   $extension = $opciones['tipo_imagen'];
   $imagen =  $opciones['imagen'];
endforeach;

?>
<!-- <img src="data:<?php echo $extension?>;base64,<?php echo base64_encode($imagen)?>"
alt="img"> -->

<div class="p">


</div>

<style>

div{
    background-image: url("data:image/<?php echo $extension?>;base64,<?php echo base64_encode($imagen)?>");
}

</style>







<div class="grid-block" style="background-image: url('<?php echo base64_encode($imagen)?>'); width: 100%; height: 100vh; ">
<h1>hola</h1>
</div>







<!-- Se arma como un rompecabezas el fin del HTML esta en el footer -->
<?php
incluirTempleate('footer');
?>