<?php
session_start();
// Conexion a base de datos
require 'includes/config/database.php';
$db = conectarBD();
$errores = [];


if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
} else {
    header('location: inicio_sesion.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $imagen = $_FILES['foto_perfil'] ?? NULL;
    $intereses = $_POST['intereses'] ?? null;
    $contador = 0;


    

    if (!$imagen['name']) {
        $errores[] = "La imagen es obligatoria";
        echo "<script>alert('La imagen es obligatoria') </script>";
    }


    $medida = 4000000;

    if ($imagen['size'] > $medida) {
        $errores[] = "El tamaño maximo para las imagenes es de 4 MB";
        echo "<script>alert('El tamaño maximo para las imagenes es de 4 MB') </script>";
    }

    // Puedo usar un contador para saber cuantos selecciono   
    if (isset($_POST['intereses'])) {
        foreach ($_POST['intereses'] as $selected) {
            $contador += 1;
        }
    }
    if ($contador > 5) {
        $errores[] = "La cantidad maxima de intereses es de 5 (sobre ti)";
        echo "<script>alert('La cantidad maxima de intereses es de 5') </script>";
    }

    if ($contador < 2) {
        $errores[] = "La cantidad minima de intereses a seleccionar es de 2 (sobre ti)";
        echo "<script>alert('La cantidad minima de intereses a seleccionar es de 2') </script>";
    }

    if (empty($errores)) {
        foreach ($_POST['intereses'] as $selected) {
            $query3 = " INSERT INTO clientes_externos_x_intereses (id_cliente,
   id_intereses)
    VALUES
    ($sessionid,$selected)";
            $resultadointereses =  mysqli_query($db, $query3);
        }

        if ($resultadointereses) {

            // Insertar imagen
            // Archivo temporal
            $imagen_temporal = $imagen['tmp_name'];
            // Tipo de archivo
            $tipo = $imagen['type'];
            // Leemos el contenido del archivo temporal en binario
            $data = addslashes(file_get_contents($imagen_temporal));
        
            $query5 = " INSERT INTO imagenes_clientes (id_cliente,
                        imagen_perfil,imagen,tipo_imagen)
                        VALUES
                        ($sessionid,1,'$data','$tipo')";
            if (($resultado5 = mysqli_query($db, $query5))) {
            //  Actualiza estado de perfil a completo
       
                $consulta = "UPDATE Usuarios_Clientes_Externo
                SET
                Estado = 0
                WHERE id_cliente = $sessionid" ;
                $ejecutar = mysqli_query($db, $consulta);
                if($ejecutar){
          
                    echo "<script>window.location = 'cargargeolocalizacion.php' </script>";
                }

                else{
                    die(mysqli_error($db));  
                }
             
           
           
            } else {
                die(mysqli_error($db));
            }
        } else {
            die(mysqli_error($db));
        }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <title>Document</title>
</head>

<body onload="capturar()">

    <div class="contenedor_formulario_perfil4">
        <div class="icono_formulario1">
            <a href="formulario3.php">
                <img class="iconos25black" src="https://img.icons8.com/ios-filled/50/null/undo.png" />
            </a>


        </div>
        <div class="cotenedor_barra" id="contenedor-barra">
            <div class="progress">
                <div class="progress-bar" style="width:100%;">
                    <span class="progress-bar-text">100%</span>
                </div>
            </div>
        </div>
        <form class="formulario_interno" method="post" action="formulario4.php" enctype="multipart/form-data">
            <label id="intereses_selecciona">
                Selecciona tus intereses
                <span id="brmaximo"> <br> (2 mínimo - 5 máximo) </span>

            </label>


            <select multiple name="intereses[]" id="inter">
                <?php
                $consulta = "SELECT distinct i.id_categoria, c.nombre  FROM intereses i, categoria_intereses c where
                i.id_categoria = c.id_categoria and i.estado = 1";
                $ejecutar = mysqli_query($db, $consulta) or die(mysqli_error($db));
                //esta  variable es para contar las filas del query
                $nr = mysqli_num_rows($ejecutar);
                // echo "La cantidad de filas es de " . $nr;
                $idcategorias = [];
                $nombrecategoria = [];

                foreach ($ejecutar as $key => $opciones) :
                    array_push($idcategorias, $opciones['id_categoria']);
                    array_push($nombrecategoria, $opciones['nombre']);
                endforeach;

                ?>

                <?php for ($i = 0; $i < count($idcategorias); $i++) :
                    $intereses_categoria = mysqli_query($db, "SELECT i.nombre as interes, c.nombre as categoria, i.id_interes as id FROM intereses i,categoria_intereses c WHERE i.id_categoria = c.id_categoria and i.id_categoria = $idcategorias[$i]") or die(mysqli_error($db)); ?>


                    <optgroup label="<?php echo $nombrecategoria[$i] ?>">

                        <?php foreach ($intereses_categoria  as $key => $opciones) : ?>
                            <option value="<?php echo $opciones['id'] ?>"><?php echo $opciones['interes'] ?></option>
                    </optgroup>
                <?php endforeach ?>
            <?php endfor; ?>
            </select>
            <label for="imagen">Agrega una foto para tu perfil</label>
            <div class="foto_perfil_formu">

                <div class="imgcheck">
                    <label>
                        <input type="radio" name="filter" value="" onclick="capturar()">
                        <img src="./src/img/filtros.jpg" class="" width="150">
                    </label>
                </div>

                <div class="imgcheck">
                    <label>
                        <input type="radio" name="filter" value="gingham" onclick="capturar()">
                        <img src="./src/img/filtros.jpg" class="gingham" width="150">
                    </label>
                </div>
                <div class="imgcheck">
                    <label>

                        <input type="radio" name="filter" value="moon" onclick="capturar()">
                        <img src="./src/img/filtros.jpg" class="moon" width="150">
                    </label>

                </div>

            </div>

            <div class="imagen_resultado">
                <div id="resultado" class=""><img id="imgSalida" width="150" /></div>
            </div>


            <!-- <div class="image-upload">
                <label for="file-input">
                    <img src="https://img.icons8.com/office/40/null/add-image.png" />
                </label>
                <input hidden="" name="foto_perfil" type="file" accept="image/jpeg, img/jpg">
            </div> -->

            <div class="hl-icon">
                <div class="image-upload">
                    <label for="file-input">
                        <img src="https://img.icons8.com/office/40/null/add-image.png" />
                    </label>
                    <input id="file-input" type="file" name="foto_perfil" hidden="" accept="image/jpeg, img/jpg" />
                </div>
            </div>




            <div class="inpunt_boton">
                <input type="submit" value="Finalizar" class="boton-principal">
            </div>
        </form>




    </div>
    <script type="text/javascript">
        function btnperfil() {
            // // window.location = 'perfilusuariodescubrir.php';
            // window.location = 'descubrir.php';
        }
    </script>



    <script src="build/js/bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

    <script>
        new MultiSelectTag('inter', {
            rounded: true,
            shadow: true
        }) // id
    </script>

    <script type="text/javascript">
        $(window).load(function() {
            $(function() {
                $('#file-input').change(function(e) {
                    addImage(e);
                });

                function addImage(e) {
                    var file = e.target.files[0],
                        imageType = /image.*/;

                    if (!file.type.match(imageType))
                        return;

                    var reader = new FileReader();
                    reader.onload = fileOnload;
                    reader.readAsDataURL(file);
                }

                function fileOnload(e) {
                    var result = e.target.result;
                    $('#imgSalida').attr("src", result);
                }
            });
        });
    </script>

    <script>
        function capturar() {
            var resultado = "";

            var porNombre = document.getElementsByName("filter");
            for (var i = 0; i < porNombre.length; i++) {
                if (porNombre[i].checked)
                    resultado = porNombre[i].value;
            }

            var elemento = document.getElementById("resultado");
            if (elemento.className == "") {
                elemento.className = resultado;
                elemento.width = "150";
            } else {
                elemento.className = resultado;
                elemento.width = "150";
            }
        }
    </script>
</body>

</html>