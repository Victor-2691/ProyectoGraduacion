<?php


session_start();
$autenticado = $_SESSION['login'];
$Usario= $_SESSION['rol']; 


if (!$autenticado || $Usario <> 1) {
    header('location: index.php');
}

// if(){
//     header('location: index.php');
// }



// Es un arreglo de sesion
 $NombreUsuario = $_SESSION['Nombre'];


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrativo</title>
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body>
    <!-- Para solo mostrar el header en la pagina de inicio
So es true mostramos el header inicio que tiene la imagen -->
    <header class="header">
        <div class="contenido-header">
            <div class="barra">
                <a class="" href="">
                    <img  class="imgloco" src="build/img/Inicio.svg" alt="Logotipo 2YouCitas">
                </a>
                <!-- <div class="mobile-menu">
                <img  class="imgloco IMGLogo" src="build/img/Logo2Youcitas_Sinfondo.svg" alt="Logotipo 2YouCitas">
                </div> -->

                <div class="derecha">
                
                    <nav class="navegacion">
                        <a href="principaladministrador.php">Inicio</a>
                        <a href="aprobarUsuarios.php">Aprobar Usuarios</a>
                        <a href="#">Servicios</a>
                        <a href="#">Clientes</a>
                        <a href="#">Hojas de trabajo</a>
                        <p id="nombre_usuario"> Admin/ <?php echo $NombreUsuario ?> </p>
                        <a href="salir.php">
                            <img class="iconos35f" src="build/img/cerrar-sesion.png" />
                        </a>
                       
                    </nav>
                </div>
            </div> <!--.barra-->
        </div>
    </header>
