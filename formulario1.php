<?php
session_start();
// Conexion a base de datos
require 'includes/config/database.php';
$db = conectarBD();
$correousuarioautenticado = $_SESSION['nombredelusuario'];

$query = mysqli_query($db, "SELECT u.id_cliente, c.nombre, c.primer_apellido FROM Usuarios_Clientes_Externo u join Clientes_Externos c
on u.id_cliente = c.id_cliente WHERE u.correo_electronico = '$correousuarioautenticado'");

//esta  variable es para contar las filas del query
foreach ($query  as $key => $opciones) :
    $idcliente = $opciones['id_cliente'];
    $nombre = $opciones['nombre'];
endforeach;

$_SESSION['idcliente'] = $idcliente;
$_SESSION['nombre'] = $nombre;
$nombreusuario = $_SESSION['nombre'];
$sessionid = $_SESSION['idcliente'];
//  echo "<pre>";
// echo $sessionid;
//    echo "<pre>";
if (isset($_SESSION['nombredelusuario'])) {
    $usuarioingresado = $_SESSION['nombredelusuario'];
    //echo "<h1>Bienvanido: $usuarioingresado </h1>";
} else {
    header('location: inicio_sesion.php');
}
$nombre = "";
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $generopertenece = $_POST['genero_pertenece'] ?? null;

    if (!$nombre) {
        $errores[] = "El nombre es un campo obligatorio (datos generales)";
        echo "<script>alert('El nombre es obligatorio') </script>";
    }

    if (!$generopertenece) {
        $errores[] = "El nombre es un campo obligatorio (datos generales)";
        echo "<script>alert('Se  debe seleccionar un genero'); </script>";
    }

    if (empty($errores)) {

          $consulta = "UPDATE Clientes_Externos
          SET
          nombre = '$nombre',
          id_genero_pertenece = $generopertenece
          WHERE id_cliente = $sessionid";
          $ejecutar = mysqli_query($db, $consulta);

          if($ejecutar){
            
            echo "<script>window.location = 'formulario2.php' </script>";
          }
          else{
            die(mysqli_error($db));
          }
          

        // header('Location: formulario2.php?id='.$sessionid. '&nombre='.$nombre. '&genero='.$generopertenece);
        // header("Location:perfilusuariodescubrir.php?mensaje=estaesunaprueba&mensaje2=estaotromensaje");

        // $mensaje = $_GET['mensaje'];
        // <?php header("Location:perfilusuariodescubrir.php?id=$idCliente"

    }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="build/css/app.css">
    <title>Document</title>
</head>

<body >


   
    <div class="contenedor_formulario_perfil">
    <div class="icono_formulario1">
        <a href="cargargeolocalizacion.php">
            <img class="iconos25black" src="https://img.icons8.com/ios-filled/50/null/delete-sign--v1.png" />
        </a>

    </div>
        <div class="cotenedor_barra">
            <div class="progress">
                <div class="progress-bar" style="width:25%;">
                    <span class="progress-bar-text">25%</span>
                </div>
            </div>
        </div>
        <form class="formulario_interno" method="post" action="formulario1.php">
            <label for="nombre">Mi nombre es</label>
            <input maxlength="30" require name="nombre" type="text" placeholder="Tu Nombre" id="nombre" value="<?php echo $nombre ?>">
            <input id="hidden" hidden type="text" name="id_usuario" value="<?php echo $sessionid ?>">

            <div class="genero_pertenece">
                <label>Soy</label>
                <div class="forma-contacto">
                    <?php
                    $consulta = "SELECT * FROM generos_pertenece";
                    $ejecutar = mysqli_query($db, $consulta) or die(mysqli_error($db));

                    ?>
                    <?php foreach ($ejecutar as $key => $opciones) : ?>

                        <label class="label_opciones" for="<?php echo $opciones['nombre_genero'] ?>"><?php echo $opciones['nombre_genero'] ?></label>
                        <input name="genero_pertenece" type="radio" value="<?php echo $opciones['id_genero'] ?>" id="<?php echo $opciones['nombre_genero'] ?>">

                    <?php endforeach ?>
                </div>



            </div>


            <div class="inpunt_boton">
                <input type="submit" value="Siguiente" class="boton-principal">
            </div>
        </form>




    </div>



    <script src="build/js/bundle.min.js"></script>
</body>

</html>