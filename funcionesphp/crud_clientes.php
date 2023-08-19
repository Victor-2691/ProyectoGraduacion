<?php
session_start();
$autenticado = $_SESSION['login'];

if (!$autenticado) {
    header('location: index.php');
}

require '../includes/config/database.php';

$fecha_actual = getdate();
$fecha_actual_completa = $fecha_actual['year'] . "-" . $fecha_actual['mon'] . "-" . $fecha_actual['mday'];

$db = conectarBD();

// // 1 consulta todos los clientes
// // 2 insert
// // 3 modificar
//  4 consulta provincias

$codigoCrud = $_POST['codigoCrud'] ?? null;
$codigoProvincia = $_POST['codigoProvincia'] ?? null;
$codigoCanton = $_POST['codigoCanton'] ?? null;
$nombreInput = $_POST['nombreInput'] ?? null;
$primerapellido = $_POST['primerapellido'] ?? null;
$segundoapellido = $_POST['segundoapellido'] ?? null;
$id = $_POST['id'] ?? null;
$correo = $_POST['correo'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
$Direccion = $_POST['Direccion'] ?? null;
$Provincia = $_POST['Provincia'] ?? null;
$Canton = $_POST['Canton'] ?? null;
$Distrito = $_POST['Distrito'] ?? null;
$valorbuscar = $_POST['valorbuscar'] ?? null;



if ($codigoCrud == 1) {
    $consulta = "SELECT Clientes.nombre, Clientes.Primer_Apeliido, Clientes.segundo_apellid,
    Clientes.identificacion, Clientes.celular, Provincias.Nombre_Provincia, Cantones.Nombre_Canton
     FROM Clientes JOIN Provincias
    ON Clientes.id_provincia = Codigo_Provincia JOIN Cantones ON Cantones.Codigo_Canton = Clientes.id_canton order by Clientes.fecha_registro DESC";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);

    // echo "<pre>";
    // var_dump($arreglo);
    // echo "<pre>";

    //  Covierte un arreglo a Json
    // Para indicar el formato de conversion en este caso para leer aceptos
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}


if ($codigoCrud == 4) {
    $consulta = "SELECT * FROM Provincias";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}


if ($codigoCrud == 5) {
    $consulta = "SELECT * FROM Cantones WHERE Cantones.Codigo_Provincia = $codigoProvincia";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}


if ($codigoCrud == 6) {
    $consulta = "SELECT * FROM Distritos WHERE Codigo_Canton = $codigoCanton";
    $ejecutar = mysqli_query($db, $consulta);
    $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
    $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    echo $json;
}

if ($codigoCrud == 2) {
    // Validar Llaves
    $consulta1 = "SELECT * FROM Clientes WHERE identificacion = '$id' ";
    $ejecutar1 = mysqli_query($db, $consulta1);
    $nr = mysqli_num_rows($ejecutar1);
    if ($nr > 0) {
        echo 1;
        exit;
    }

    $consulta2 = "SELECT * FROM Clientes WHERE celular = $telefono";
    $ejecutar2 = mysqli_query($db, $consulta2);
    $nr2 = mysqli_num_rows($ejecutar2);
    if ($nr2 > 0) {
        echo 2;
        exit;
    }

    $consulta3 = "SELECT * FROM Clientes WHERE correo_electronico = '$correo' ";
    $ejecutar3 = mysqli_query($db, $consulta3);
    $nr3 = mysqli_num_rows($ejecutar3);
    if ($nr3 > 0) {
        echo 3;
        exit;
    }

    $consulta = "INSERT INTO Clientes
    (`nombre`,
    `Primer_Apeliido`,
    `segundo_apellid`,
    `identificacion`,
    `fecha_registro`,
    `celular`,
    `correo_electronico`,
    `estado`,
    `id_provincia`,
    `id_canton`,
    `id_distrito`,
    `direccion`,
    `fechanacimiento`)
    VALUES
    ('$nombreInput',
    '$primerapellido',
    '$segundoapellido',
    '$id',
    '$fecha_actual_completa',
    '$telefono',
   '$correo',
    1,
   '$Provincia',
    '$Canton',
 '$Distrito',
    '$Direccion',
    '$fecha_nacimiento')";
    $ejecutar = mysqli_query($db, $consulta);
    if ($ejecutar) {
        echo 4;
    } else {
        echo die(mysqli_error($db));
    }
}


    // Buscar valores especificos
    if ($codigoCrud == 11) {
        $consulta = "SELECT Clientes.nombre, Clientes.Primer_Apeliido, Clientes.segundo_apellid,
        Clientes.identificacion, Clientes.celular, Provincias.Nombre_Provincia, Cantones.Nombre_Canton
         FROM Clientes JOIN Provincias
        ON Clientes.id_provincia = Codigo_Provincia JOIN Cantones ON Cantones.Codigo_Canton = Clientes.id_canton
         WHERE Clientes.nombre LIKE '%$valorbuscar%'";
        $ejecutar = mysqli_query($db, $consulta);
        $nr = mysqli_num_rows($ejecutar);
        if ($nr > 0) {
            $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
            $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
            echo $json;
        } else {
            echo 0;
        }
        
    }

    if ($codigoCrud == 12) {
        $consulta = "SELECT Clientes.nombre, Clientes.Primer_Apeliido, Clientes.segundo_apellid,
        Clientes.identificacion, Clientes.celular, Provincias.Nombre_Provincia, Cantones.Nombre_Canton
         FROM Clientes JOIN Provincias
        ON Clientes.id_provincia = Codigo_Provincia JOIN Cantones ON Cantones.Codigo_Canton = Clientes.id_canton
        WHERE Clientes.celular LIKE '%$valorbuscar%'";
        $ejecutar = mysqli_query($db, $consulta);
        $nr = mysqli_num_rows($ejecutar);
        if ($nr > 0) {
            $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
            $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
            echo $json;
        } else {
            echo 0;
        }
    }

    if ($codigoCrud == 13) {
        $consulta = "SELECT Clientes.nombre, Clientes.Primer_Apeliido, Clientes.segundo_apellid,
        Clientes.identificacion, Clientes.celular, Provincias.Nombre_Provincia, Cantones.Nombre_Canton
         FROM Clientes JOIN Provincias
        ON Clientes.id_provincia = Codigo_Provincia JOIN Cantones ON Cantones.Codigo_Canton = Clientes.id_canton
        WHERE Clientes.identificacion LIKE '%$valorbuscar%'";
        $ejecutar = mysqli_query($db, $consulta);
        $nr = mysqli_num_rows($ejecutar);
        if ($nr > 0) {
            $arreglo = mysqli_fetch_all($ejecutar, MYSQLI_ASSOC);
            $json = json_encode($arreglo, JSON_UNESCAPED_UNICODE);
            echo $json;
        } else {
            echo 0;
        }
        echo die(mysqli_error($db));
    }

