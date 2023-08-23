<?php


session_start();
$autenticado = $_SESSION['login'];
$Usario= $_SESSION['rol']; 
if (!$autenticado || $Usario <> 2) {
    header('location: index.php');
}

if (!isset($_SESSION['loaded'])) {
    // Es la primera vez que se carga la página
    $_SESSION['loaded'] = true;
    $mensaje = "Página cargada por primera vez.";
} else {
    // La página ha sido recargada
    $mensaje = "Página recargada.";
}

// Es un arreglo de sesion
 $NombreUsuario = $_SESSION['Nombre'];


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MR Automotriz</title>
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script> -->
<!-- <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css
" rel="stylesheet"> -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

    
</head>

<body>
    <!-- Para solo mostrar el header en la pagina de inicio
So es true mostramos el header inicio que tiene la imagen -->
    <header class="header">
        <div class="contenido-header">
            <div class="barra">
                <a class="animate__animated animate__rubberBand" href="index.php">
                <img  class="imgloco" src="build/img/Inicio.svg" alt="Logotipo 2YouCitas">
                </a>
                <!-- <div class="mobile-menu">
                    <img src="build/img/barras.svg" alt="icono menu responsive">
                </div> -->

                <div class="derecha">
              
                    <nav class="navegacion">
                       
                       <a   href="principalempleados.php" class="opcion_menu" data-target="inicio" >Inicio</a>
                       <a  href="clientes.php" class="opcion_menu" data-target="Clientes">Clientes</a>
                       <a  href="vehiculos.php" class="opcion_menu" data-target="Clientes">Vehiculos</a>

                        <a  href="verhojastrabajo.php" class="opcion_menu" data-target="hojatrabajo">Mis hojas de trabajo</a>
                        <p id="nombre_usuario"> Usuario/ <?php echo $NombreUsuario ?> </p>
                        <a href="salir.php">
                            <img class="iconos35f" src="build/img/cerrar-sesion.png" />
                        </a>
                    </nav>
                </div>

            </div> <!--.barra-->






        </div>
    </header>
