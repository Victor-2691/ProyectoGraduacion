<?php


require 'includes/config/database.php';
$db = conectarBD();


$Usario = "";
$errores = [];
$fecha_actual = getdate();
$fecha_actual_completa = $fecha_actual['year'] . "-" . $fecha_actual['mon'] . "-" . $fecha_actual['mday'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Usario = mysqli_real_escape_string($db, filter_var($_POST['usuario'], FILTER_VALIDATE_EMAIL));
    $contra = mysqli_real_escape_string($db, $_POST['password']);

    if (!$Usario) {
        $errores[] = "El email es obligatorio o no es valido";
        echo "<script>alert('El email es obligatorio o no es valido'); </script>";
    }

    if (!$contra) {
        $errores[] = "La contraseña es un campo obligatorio";
        echo "<script>alert('La contraseña es un campo obligatorio'); </script>";
    }

    if (empty($errores)) {
        // Revisar si el usuario existe
        $query = "SELECT * FROM Usuarios WHERE correo_electronico = '$Usario' ";
        // echo "<pre>";
        // var_dump($query);
        // echo "</pre>";
        $resultado = mysqli_query($db, $query);
        // echo "<pre>";
        // var_dump($resultado);
        // echo "</pre>";


        // Revisamos si hay resultados con el numero de filas
        if ($resultado->num_rows) {
            // Validar Password
            $Usario = mysqli_fetch_assoc($resultado);
            // Verificar password
            $auth = password_verify($contra, $Usario['contrasena']);

            if ($auth) {
                // Password correcto
                // Revisar si el usuario esta aprobado
                if ($Usario['estado'] == 1) {
                    // Definir Roles si empleado o administrador
                    if ($Usario['id_rol'] == 1) {
                        // Administrador
                        session_start();
                        // Es un arreglo de sesion
                        $_SESSION['usuario'] = $Usario['correo_electronico'];
                        $_SESSION['id'] = $Usario['identificacion'];
                        $_SESSION['rol'] = $Usario['id_rol'];
                        $_SESSION['Nombre'] = $Usario['Nombre'];
                        $_SESSION['login'] = true;
                        // echo "<pre>";
                        // var_dump($_SESSION);
                        // echo "</pre>";
                        header('location: principaladministrador.php');
                    }

                    if ($Usario['id_rol'] == 2) {
                        // Empleados Mecanicos
                        session_start();
                        // Es un arreglo de sesion
                        $_SESSION['usuario'] = $Usario['correo_electronico'];
                        $_SESSION['id'] = $Usario['identificacion'];
                        $_SESSION['rol'] = $Usario['id_rol'];
                        $_SESSION['Nombre'] = $Usario['Nombre'];
                        $_SESSION['login'] = true;
                        // echo "<pre>";
                        // var_dump($_SESSION);
                        // echo "</pre>";
                        header('location:principalempleados.php');
                      
                    }
                } else {
                    echo "<script>alert('El usuario se encuentra pendiente de aprobación, por favor consulte con el administrador'); </script>";
                }
            } else {
                echo "<script>alert('La contraseña es incorrecta'); </script>";
            }
        } else {

            echo "<script>alert('El usuario no existe'); </script>";
        }
    }




    // $consulta = "SELECT * FROM SA_Usuarios_Administracion WHERE correo_electronico = '$Usario'";
    // $ejecutar = mysqli_query($db, $consulta);

    // if ($ejecutar->num_rows) {

    //     $consulta = mysqli_fetch_assoc($ejecutar);

    //     if ($Usario == $consulta['correo_electronico'] &&  $contra == $consulta['contrasena']) {

    //         session_start();

    //         $_SESSION['idusuario'] = $consulta['id_cliente'];
    //         $_SESSION['id_rol'] = $consulta['id_rol'];
    //         $_SESSION['nombre'] = $consulta['nombre'];
    //         $_SESSION['apellido'] = $consulta['primer_apellido'];
    //         $_SESSION['login'] = true;

    //         if( $_SESSION['id_rol'] == 1){
    //             header("location: perfiles.php");
    //         }

    //         if( $_SESSION['id_rol'] == 2){
    //             header("location: indicadores.php");
    //         }

    //         if( $_SESSION['id_rol'] == 3){
    //             header("location: administrador.php");
    //         }
    //         // Llenar el arreglo de la sesion
    //     } else {
    //         echo  "<script>alert('Usuario o contra incorrectas');</script>";
    //     }
    // } else {
    //     echo  "<script>alert('Usuario no existe');</script>";
    // }


}

// Revisar si el usuario existe 



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrativo</title>
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="body-index">


    <div id="contenedor">

        <div id="central">
            <div id="login">
                <div class="centrar_icono">
                    <div class="titulo">

                        <img src="build/img/logomr.png">
                    </div>
                </div>

                <form method="POST" id="loginform" action="index.php">
                    <input type="email" name="usuario" placeholder="Usuario" require>

                    <input type="password" placeholder="Contraseña" name="password" require>

                    <button type="submit" title="Ingresar" name="Ingresar">Login</button>
                </form>
                <div class="pie-form">
                    <a href="">¿Perdiste tu contraseña?</a>
                    <a href="registro.php">¿No tienes Cuenta? Registrate</a>
                </div>
            </div>
            <div class="inferior">

            </div>
        </div>
    </div>

</body>

</html>