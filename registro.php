<?php

// Conexion a base de datos
require 'includes/config/database.php';
include 'funcionesphp/enviarcorreos.php';
$db = conectarBD();

// Arreglo de mensajes de errores

$errores = [];
$nombre = "";
$apellido1 = "";;
$apellido2 = "";
$correo = "";
$id = "";
$contra = "";
$confirmacontra = "";
// Obtener fecha del servidor le pasamos el formato
// y miniscula solo year corto 22 y Y imprime completo 2022
$fecha_actual = getdate();
$fecha_actual_completa = $fecha_actual['year'] . "-" . $fecha_actual['mon'] . "-" . $fecha_actual['mday'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre =  mysqli_real_escape_string($db, $_POST['nombre']);
    $apellido1 = mysqli_real_escape_string($db, $_POST['primer_apellido']);
    $apellido2 = mysqli_real_escape_string($db, $_POST['segundo_apellido']);
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $correo = mysqli_real_escape_string($db, $_POST['correo']);
    $contra = mysqli_real_escape_string($db, $_POST['contra']);
    $confirmacontra = mysqli_real_escape_string($db, $_POST['confirmacontra']);
    $bandera = false;

    // Comenzamos las validaciones si los campos estan vacios
    if (!$nombre) {
        $errores[] = "El nombre es un campo obligatorio";
    }

    if (!$apellido1) {
        $errores[] = "El primer apellido es un campo obligatorio";
    }

    if (!$apellido2) {
        $errores[] = "El segundo apellido es un campo obligatorio";
    }

    if (!$correo) {
        $errores[] = "El correo es obligatorio ";
    }

    if (!$id) {
        $errores[] = "La identificación es obligatoria";
    }

    if (!$contra) {
        $errores[] = "La contraseña es obligatoria";
        $bandera = true;
    }

    if (!$confirmacontra) {
        $errores[] = "La confirmación de la contraseña es obligatoria ";
        $bandera = true;
    }

    if ($bandera == false) {
        // Validamos que la contra sean iguales
        if (!($contra == $confirmacontra)) {
            $errores[] = "La contraseña y su confirmación deben ser iguales";
        }
    }

    // validar correo y id

    $consulta = "SELECT * FROM Usuarios WHERE identificacion = '$id'";
    $ejecutar = mysqli_query($db, $consulta);
    if ($ejecutar->num_rows) {
        $errores[] = "La indentificación ya se encuentra registrada";
    }

    $consulta2 = "SELECT * FROM Usuarios WHERE correo_electronico = '$correo'";
    $ejecutar2 = mysqli_query($db, $consulta2);
    if ($ejecutar2->num_rows) {
        $errores[] = "El correo electronico ya se encuentra registrado";
    }


    if (empty($errores)) {


        // Hashear el password
        $passwordHash = password_hash($contra, PASSWORD_DEFAULT);
        // echo "<pre>";
        // echo  $passwordHash;
        // echo "<pre>";

        $consulta = "SELECT * FROM Usuarios";
        $ejecutar = mysqli_query($db, $consulta);
        $resultado = mysqli_fetch_all($ejecutar);
        // echo "<pre>";
        // var_dump($resultado);
        // echo "<pre>";


        //  Insertamos en la BD
        $query = " INSERT INTO Usuarios (Nombre,Primer_apellido,Segundo_apellido,identificacion,Fecha_registro,id_rol,correo_electronico,estado,contrasena)
            VALUES
            ('$nombre',
            '$apellido1',
            '$apellido2',
            '$id',
            '$fecha_actual_completa',
            1,
            '$correo',
            1,
            '$passwordHash' )";


        if (($resultado = mysqli_query($db, $query))) {
            //   Enviar correos de notificaciones al usuario
            $cuerpocorre = 'Bienvenido al sistema MR Automotriz, su usario esta pendiente de aprobacion por parte del administrador';
            $apellidos = $apellido1 . ' ' . $apellido2;
            $enviarcorreousuario = enviarcorreoUsuarios($correo, $cuerpocorre, $nombre, $apellidos);
            if ($enviarcorreousuario) {
                echo "<script>alert('correo de usuario enviado con exito'); </script>";
            }
            else{
                echo "<script>alert('error correo de usaurio'); </script>";
            }
            // Correo al administrador
            $enviarocorreoadmin = enviarcorreoAdministrador('victor.salgado.martinez@cuc.cr',$nombre,$apellidos,$fecha_actual_completa,$id,'Mecanico');
            if ($enviarocorreoadmin) {
                echo "<script>alert('correo de admin enviado con exito'); </script>";
            }
            else{
                echo "<script>alert('error correo de admin'); </script>";
            }
            echo "<script>alert('El usuario se registro con exito, pendiente aprobación'); </script>";
            echo "<script>window.location = 'index.php' </script>";
            //   header('location: index.php');

        } else {

            die(mysqli_error($db));
        }
    }
}

require 'includes/funciones.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2 YouCitas</title>
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css
" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>


    <main class="contenedorform seccion">


        <!-- <h2>Necesitamos saber un poco más de ti</h2> -->

        <!-- Mostrando arreglo de errores validaciones -->

        <?php foreach ($errores as $error) :  ?>
            <div class="alerta error">

                <?php echo $error  ?>
            </div>


            </div>

        <?php endforeach; ?>

        <form class="formulario" method="POST" action="registro.php" enctype="multipart/form-data">
            <fieldset class="fielsombra">
                <legend>Registro</legend>

                <label for="nombre">Nombre</label>
                <input maxlength="30" require name="nombre" type="text" placeholder="Tu Nombre" id="nombre" value="<?php echo $nombre ?>">

                <label for="apellido1">Primer Apellido</label>
                <input maxlength="45" name="primer_apellido" type="text" placeholder="Primer Apellido" id="apellido1" value="<?php echo $apellido1 ?>">

                <label for="apellido2">Segundo Apellido</label>
                <input maxlength="45" name="segundo_apellido" type="text" placeholder="Segundo Apellido" id="apellido2" value="<?php echo $apellido2 ?>">

                <label for="id">Identificación</label>
                <input maxlength="45" name="id" type="text" placeholder="Identificación" id="id" value="<?php echo $id ?>">

                <label for="correo">Correo Electrónico</label>
                <input name="correo" type="email" placeholder="Correo Electrónico" id="correo" value="<?php echo $correo ?>">

                <label for="contra">Contraseña</label>
                <input name="contra" type="password" placeholder="Contraseña" id="contra">
                <label for="contraconfirma">Confirmar Contraseña</label>
                <input name="confirmacontra" type="password" placeholder="Confirma Contraseña" id="contraconfirma">
                <div class="contiene">
                    <div class="formulario_enviar">
                        <input type="submit" value="REGISTRAR" class="boton-negro">
                    </div>
                </div>
            </fieldset>
        </form>
    </main>






    <!-- Se arma como un rompecabezas el fin del HTML esta en el footer -->
    <?php
    incluirTempleate('footer_externo');
    ?>