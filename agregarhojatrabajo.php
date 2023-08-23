<?php
require 'includes/funciones.php';
incluirTempleate('header_empleados');
require 'includes/config/database.php';
$db = conectarBD();

$idusuario =  $_SESSION['id']

?>
<main>
    <div class="contenido_principal_vehiculo">
        <p hidden id="idusuario"> <?php echo $idusuario ?> </p>
        <form class="formulario3">
            <!--E; fieldset es para configurar el encabezado del formulario-->
            <fieldset>
                <legend>Datos del Cliente</legend>
                <!--Algunas etiquetas como tel estan echas para dispositivos moviles-->
                <!--La regla para agrupar con DIV es que no se use algun otro tipo de agrupacion
            como setion o articule-->

                <div class="Contenedor-Campos">
                    <div class="campo">
                        <label>Nombre</label>
                        <input id="nombre_vehicul" readonly class="input-text" type="text" />
                    </div>

                    <div class="campo">
                        <label>Primer Apellido</label>
                        <input id="apellido_vehicul" readonly class="input-text" type="text" />
                    </div>

                    <div class="campo">
                        <label>Segundo Apellido</label>
                        <input id="apellido2_vehicul" readonly class="input-text" type="text" />
                    </div>

                    <div class="campo">
                        <label>Identificación</label>
                        <input id="identificaci_vehicul" class="input-text" readonly value="505530992" />
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Datos del Vehiculo</legend>
                <!--Algunas etiquetas como tel estan echas para dispositivos moviles-->
                <!--La regla para agrupar con DIV es que no se use algun otro tipo de agrupacion
            como setion o articule-->

                <div class="Contenedor-Campos">
                    <div class="campo">
                        <label>Placa</label>
                        <input id="placa" readonly placeholder="ingrese la placa" class="input-text" type="text" value="" />
                    </div>

                    <div class="campo">
                        <label>Marca</label>
                        <input id="marca" readonly placeholder="ingrese la placa" class="input-text" type="text" value="" />
                    </div>

                    <div class="campo">
                        <label>Modelo</label>
                        <input id="modelo" readonly placeholder="ingrese la placa" class="input-text" type="text" value="" />
                    </div>

                    <div class="campo">
                        <label>Kilometraje</label>
                        <input type="number" id="kiloemetraje" placeholder="ingrese el kilometraje" class="input-text" type="text" value="" />
                    </div>

                    <div class="campo">
                        <label for="Gasolina">Cantidad Combustible</label>
                        <select class="input-text" name="gasolina" id="Gasolina">
                            <option disabled selected>-- Seleccione --</option>
                            <option> 25%</option>
                            <option> 50%</option>
                            <option> 75%</option>
                            <option> 100%</option>
                            <option> No Aplica</option>
                        </select>
                    </div>




                </div>
            </fieldset>

            <fieldset>
                <legend>Datos de la hoja de trabajo</legend>
                <!--Algunas etiquetas como tel estan echas para dispositivos moviles-->
                <!--La regla para agrupar con DIV es que no se use algun otro tipo de agrupacion
            como setion o articule-->

                <div class="Contenedor-Campos">
                    <div class="campo">
                        <label for="fecha_registro">Fecha</label>
                        <input readonly name="fecha_registro" type="date" id="fecha_registro">
                    </div>



                    <div class="campo">
                        <label>Servicios Aplicados:</label>
                        <select multiple name="Servicios" id="Servicios">

                        </select>
                    </div>


                    <div class=" campo double-column">
                        <label for="comentarios">Comentarios</label>
                        <textarea maxlength="300" name="comentarios" id="comentarios"></textarea>
                    </div>

                    <div class="campo double_firma">
                        <label for="Firma">Firma</label>
                        <canvas width="400" height="200" id="signatureCanvas"></canvas>
                    </div>







                    <!-- <div class="campo">
                        <label>Modelo</label>
                        <input id="modelo" readonly placeholder="ingrese la placa" class="input-text" type="text" value="" />
                    </div>
                </div> -->
            </fieldset>



        </form>


        <div class="botones_formulario">
            <button id="btn_agrega_vehiculo" type="button" class="boton-negro"> Agregar </button>
            <button id="btn_regresar" type="button" class="boton-negro"> Regresar </button>
            <button type="button" class="boton-negro" id="clearButton">Borrar Firma</button>
        </div>

    </div>


</main>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        function getURLParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }




        // Obtén los valores de los parámetros de la URL
        var parametro1 = getURLParameter("id");
        var parametro2 = getURLParameter("nombre");
        var parametro3 = getURLParameter("apellido1");
        var parametro4 = getURLParameter("apellido2");
        var parametro5 = getURLParameter("placa");
        var parametro6 = getURLParameter("marca");
        var parametro7 = getURLParameter("modelo");

        var fechaActual = new Date();
        var year = fechaActual.getFullYear();
        var month = ("0" + (fechaActual.getMonth() + 1)).slice(-2);
        var day = ("0" + fechaActual.getDate()).slice(-2);
        var fechacompleta = year + "-" + month + "-" + day;

        let nombre = document.querySelector('#nombre_vehicul');
        let apellido1 = document.querySelector('#apellido_vehicul');
        let apellido2 = document.querySelector('#apellido2_vehicul');
        let id = document.querySelector('#identificaci_vehicul');
        let placa = document.querySelector('#placa');
        let marca = document.querySelector('#marca');
        let modelo = document.querySelector('#modelo');
        let btnagregar = document.querySelector('#btn_agrega_vehiculo');
        let btregresar = document.querySelector('#btn_regresar');
        nombre.value = parametro2;
        apellido1.value = parametro3;
        apellido2.value = parametro4;
        id.value = parametro1;
        placa.value = parametro5;
        marca.value = parametro6;
        modelo.value = parametro7;
        let fecharegistro = document.querySelector('#fecha_registro');
        console.log(fecharegistro);
        console.log(fechacompleta);
        fecharegistro.value = fechacompleta;
        let servicios = document.querySelector('#Servicios');
        console.log(servicios);
        // Cargar combo de servicios 
        //Cargar el Combo de Provincias
        var parametros = {
            "codigoCrud": 1
        };
        $.ajax({
            data: parametros,
            url: 'funcionesphp/crud_hojatrabajo.php',
            type: 'POST',
            dataType: 'json',
            success: function(mensaje) {

                mensaje.forEach(item => {
                    const newOption = new Option(item.Nombre, item.Id_servicio);
                    servicios.appendChild(newOption);
                });

                new MultiSelectTag('Servicios', {
                    rounded: true, // default true
                    shadow: true, // default false
                    placeholder: 'Search', // default Search...
                    onChange: function(values) {
                        console.log(values)
                    }
                })


            },
            Error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: textStatus & errorThrown,

                })
            }

        });

        var canvas = document.getElementById('signatureCanvas');
        var signaturePad = new SignaturePad(canvas);
        let firma = document.querySelector('#signatureCanvas');
        let comentarios = document.querySelector('#comentarios');
        let Gasolina = document.querySelector('#Gasolina');
        let kiloemetraje = document.querySelector('#kiloemetraje');
        let usuario = document.querySelector('#idusuario');
        console.log(canvas);



        btnagregar.addEventListener('click', () => {


            if (Gasolina.selectedIndex == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar la cantidad de combustible',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (!validarNumero(kiloemetraje.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar el kilometraje',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (servicios.selectedIndex == -1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar minimo un servicio',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (!validarCamposVacios(comentarios.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar algun comentario relevante',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            let resultado = signaturePad.isEmpty();
            console.log(resultado);

            if (resultado) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El cliente debe firmar la boleta de ingreso',
                })
                return;
            }

            Swal.fire(
                'Good job!',
                'Hoja de trabajo se agrego con exito!',
                'Aceptar'
            )
            // window.location.href = 'vehiculos.php'





        })


        btregresar.addEventListener('click', () => {

            window.location.href = 'vehiculos.php'
        })


        function filterSelectOptions(inputElement, selectElement) {
            const filterValue = inputElement.value.toLowerCase();
            const options = selectElement.options;

            for (let i = 0; i < options.length; i++) {
                const optionText = options[i].textContent || options[i].innerText;
                if (optionText.toLowerCase().indexOf(filterValue) > -1) {
                    options[i].style.display = '';
                } else {
                    options[i].style.display = 'none';
                }
            }
        }





        var clearButton = document.getElementById('clearButton');
        clearButton.addEventListener('click', function() {
            signaturePad.clear();
        });

    });

    function validarCamposVacios(nombre) {
        // Realiza tus validaciones aquí, devuelve true si es válido
        return nombre.trim() !== "";
    }

    function validarNumero(valor) {
        return valor !== "" && /^\d+$/.test(valor);
    }
</script>





<?php
incluirTempleate('footer');
?>