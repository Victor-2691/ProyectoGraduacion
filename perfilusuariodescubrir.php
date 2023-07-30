<?php

require 'includes/funciones.php';
incluirTempleate('header_interno');
// Conexion a base de datos
require 'includes/config/database.php';
$db = conectarBD();


$idusario = $_GET['id'];

$consulta = " SELECT DISTINCT CI.nombre, CI.primer_apellido, CI.segundo_apellido,
CI.edad, CI.descripcion,  
sz.nombre_signo, GP.nombre_genero as generopertenece,
categoria_preferencias.nombre_categoria as buscando
 FROM Clientes_Externos CI JOIN signos_zodiaco sz ON
sz.id_signo = CI.id_genero_signozodiaco JOIN generos_pertenece GP 
ON GP.id_genero = CI.id_genero_pertenece JOIN imagenes_clientes img ON
CI.id_cliente = img.id_cliente JOIN clientes_externos_x_preferencias CP ON
CI.id_cliente =  CP.id_cliente 
JOIN categoria_preferencias ON categoria_preferencias.id_preferencia = CP.id_preferencia WHERE CI.id_cliente = $idusario";
$ejecutar = mysqli_query($db, $consulta);
foreach ($ejecutar as $key => $opciones) :

    $nombre =    $opciones['nombre'];
    $descripcion =    $opciones['descripcion'];
    $signo =    $opciones['nombre_signo'];
    $genero =    $opciones['generopertenece'];
    $buscando = $opciones['buscando'];
    $edad = $opciones['edad'];

endforeach;



$consulta = "select * from imagenes_clientes  where id_cliente = $idusario  and imagen_perfil =0 ";
$ejecutar = mysqli_query($db, $consulta);
$contador = 2;
$nr = mysqli_num_rows($ejecutar);

$consulta2 = "SELECT intereses.nombre FROM clientes_externos_x_intereses ci JOIN Clientes_Externos c on
ci.id_cliente = c.id_cliente JOIN  intereses ON intereses.id_interes = ci.id_intereses
WHERE c.id_cliente = $idusario";
$ejecutar2 = mysqli_query($db, $consulta2);

?>


<main class="contenedor_perfil">

    <div class="contenedor_grid">
        <div class="galeria" style="--w: 800px; --h: 700px;">

            <input type="radio" name="navigation1" id="_1" checked>

            <?php for ($i = 1; $i < $nr; $i++) : ?>
                <input type="radio" name="navigation1" id="_<?php echo $contador ?>">

                <?php $contador++ ?>
            <?php endfor; ?>

            <?php foreach ($ejecutar as $key => $opciones) :  ?>

                <img src="data:<?php echo $opciones['tipo_imagen'] ?>;base64,<?php echo base64_encode($opciones['imagen']) ?>" alt="imagenusuario" width="260" height="200">

            <?php endforeach; ?>



            <!-- <input type="radio" name="navigation1" id="_2">
            <input type="radio" name="navigation1" id="_3">
            <input type="radio" name="navigation1" id="_4">

            <img src="https://i0.wp.com/blog.mascotaysalud.com/wp-content/uploads/2019/05/CARA-ROTTWEILER.jpg?fit=865%2C540&ssl=1" alt="Galeria CSS 1" />
            <img src="https://www.placecage.com/c/260/200" width="260" height="200" alt="Galeria CSS 2" />
            <img src="http://placekitten.com/260/200" width="260" height="200" alt="Galeria CSS 3" />
            <img src="http://www.stevensegallery.com/260/200" width="260" height="200" alt="Galeria CSS 4" /> -->
        </div>

        <div class="contenido_perfil_descrip">
      

            <div class="perfil_nombre_distancia">
                <h1 id="margin0"> <?php echo $nombre ?> - <span class="edad"> <?php echo $edad ?> Años</span> </h1>
                <div class="alinear_icono">
                    <img class="iconos" src="https://img.icons8.com/fluency-systems-regular/30/null/user-location.png" />
                    <p>A 22 Kilometros</p>

                </div>

            </div>

            <div class="perfil_descripcion">
                <h1>Descripción</h1>
                <p> <?php echo $descripcion ?>  </p>
            </div>


        </div>

        <div class="contenido_sobremi_busco">
            <div>
                <h1 id="h1_sobremi">Sobre Mi</h1>
                <div class="perfil_sobre_mi">
                    <div class="iconos_flex">
                        <img class="iconos" src="https://img.icons8.com/fluency-systems-regular/48/null/star-crescent.png" />
                        <p> <?php echo $signo ?> </p>
                    </div>
                    <div class="iconos_flex">
                        <img class="iconos" src="https://img.icons8.com/ios/50/null/gender.png" />
                        <p> <?php echo $genero ?> </p>
                    </div>

                </div>
            </div>


            <div>
                <div class="perfil_preferencias">
                    <h1>Que busco</h1>
                    <div class="alinear_icono2">
                        <img class="iconos" src="https://img.icons8.com/ios-glyphs/35/null/search-client.png" />
                        <p> <?php echo $buscando ?> </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="quemegusta">
            <h1>Que me gusta</h1>
            <div class="interereses">

                <?php foreach ($ejecutar2 as $key => $opciones) :  ?>

                    <div class="interes_individual">
                    <p> <?php echo $opciones['nombre']?> </p>
                
                </div>

                <?php endforeach; ?>

               

            </div>

        </div>




    </div>





</main>



<?php
incluirTempleate('footer');
?>