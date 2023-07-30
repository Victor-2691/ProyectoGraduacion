<?php

require 'includes/funciones.php';
incluirTempleate('header_externo');
require 'includes/config/database.php';
$db = conectarBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagen = $_FILES['foto_perfil'];
    $id = $_POST['id'];

    // Insertar imagen
    // Archivo temporal
    $imagen_temporal = $imagen['tmp_name'];
    // // Tipo de archivo
    $tipo = $imagen['type'];
    // // Leemos el contenido del archivo temporal en binario
    $data = addslashes(file_get_contents($imagen_temporal));

    // For Loop



    $query5 = " INSERT INTO imagenes_clientes (id_cliente,
                            imagen_perfil,imagen,tipo_imagen)
                            VALUES
                            ($id,1,'$data','$tipo')";

    if (($resultado5 = mysqli_query($db, $query5))) {
        echo "Se inserto imagen de forma correcta";
    } else {
        die(mysqli_error($db));
    }
}




?>

<main>

    <form class="formulario" method="POST" action="cargarfotostemporal.php" enctype="multipart/form-data">
        <label for="telefono">ID</label>
        <input name="id" type="number" placeholder="id cliente" id="id" min="0">
        <input name="foto_perfil" id="imagen" type="file" accept="image/jpeg, img/jpg">
        <input type="submit" value="REGISTRAR" class="boton-negro">
    </form>


</main>


<!-- Se arma como un rompecabezas el fin del HTML esta en el footer -->
<?php
incluirTempleate('footer');
?>