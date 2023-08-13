<?php
require 'includes/funciones.php';
incluirTempleate('header_empleados');
require 'includes/config/database.php';
$db = conectarBD();

?>
<!DOCTYPE html>
<html lang="en">
    <main class="contenedorform seccion">
        <form class="formulario formulario_nuevocliente" method="POST" action="nuevocliente.php" enctype="multipart/form-data">
            <fieldset class="fielsombra">
                <legend>Registro</legend>

                <label for="nombre">Nombre</label>
                <input maxlength="30" require name="nombre" type="text" placeholder="Tu Nombre" id="nombre">

                <label for="apellido1">Primer Apellido</label>
                <input maxlength="45" name="primer_apellido" type="text" placeholder="Primer Apellido" id="apellido1">

                <label for="apellido2">Segundo Apellido</label>
                <input maxlength="45" name="segundo_apellido" type="text" placeholder="Segundo Apellido" id="apellido2">

                <label for="id">Identificación</label>
                <input maxlength="45" name="id" type="text" placeholder="Identificación" id="id">

                <label for="correo">Correo Electrónico</label>
                <input name="correo" type="email" placeholder="Correo Electrónico" id="correo">

                <label for="telefono">Número de télefono</label>
                <input name="telefono" type="number" placeholder="Número de télefono" id="telefono" min="1">

                <label for="Provincia">Provincia:</label>
                <select name="Provincia" id="Provincia">
                    <option value="" disabled selected>-- Seleccione --</option>
                </select>

                <label for="Canton">Cantón:</label>
                <select name="Canton" id="Canton">
                    <option disabled selected>-- Seleccione --</option>
                </select>
                <label for="Distrito">Distrito:</label>
                <select name="Distrito" id="Distrito">
                    <option value="" disabled selected>-- Seleccione --</option>
                    <option value=""> </option>
                </select>


                <label for="fecha">Fecha de nacimiento</label>
                <input name="fecha_nacimiento" type="date" id="fechaNacimiento" value="">

                <label for="descripcion">Dirección</label>
                <textarea maxlength="300" name="descripcion" id="descripcion"></textarea>

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
    incluirTempleate('footer');
    ?>