<?php
require 'includes/funciones.php';
incluirTempleate('header_empleados');
require 'includes/config/database.php';
$db = conectarBD();

?>

<main>
    <div class="contenido_principal_vehiculo">
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
                        <input placeholder="ingrese la placa" class="input-text" type="text" value="" />
                    </div>

                    <div class="campo">
                        <label for="Marca">Marca</label>
                        <select class="input-text" name="Marca" id="Marca" onkeyup="filterSelectOptions(this, this)">
                            <option disabled selected>-- Seleccione --</option>
                            <option> Toyota</option>
                            <option> Nissan</option>
                            <option> Audi</option>
                            <option> Suziki</option>
                            <option> Jeep</option>
                            <option> Ford</option>
                            <option> Kia</option>
                        </select>
                    </div>



                    <div class="campo">
                        <label>Año</label>
                        <input class="input-text" type="text" placeholder="ingrese año" />
                    </div>

                    <div class="campo">
                        <label for="Modelo">Modelo</label>
                        <select class="input-text" name="Modelo" id="Modelo" onkeyup="filterSelectOptions(this, this)">
                            <option disabled selected>-- Seleccione --</option>
                            <option> Versa</option>
                            <option> Senta</option>
                            <option> March</option>
                            <option> Kicks</option>
                            <option> Qashqai</option>
                            <option> X-Trail</option>
                        </select>
                    </div>

                    
                    <div class="campo">
                        <label for="Modelo">Trasmisión</label>
                        <select class="input-text" name="Modelo" id="Modelo" onkeyup="filterSelectOptions(this, this)">
                            <option disabled selected>-- Seleccione --</option>
                            <option> Manual</option>
                            <option> Automático</option>
                        </select>
                    </div>

                    
                    <div class="campo">
                        <label for="Modelo">Combustión</label>
                        <select class="input-text" name="Modelo" id="Modelo" onkeyup="filterSelectOptions(this, this)">
                            <option disabled selected>-- Seleccione --</option>
                            <option> Diésel</option>
                            <option> Gasolina</option>
                            <option> Hibrido</option>
                            <option> Eléctrico</option>
                        </select>
                    </div>



                </div>

            </fieldset>
        </form>


        <div class="botones_formulario">
            <button id="btn_agrega_vehiculo" type="button" class="boton-negro"> Agregar </button>
            <button id="btn_regresar" type="button" class="boton-negro"> Regresar </button>
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

        // Utiliza los valores como desees
        console.log("Valor del parametro1: " + parametro1);
        console.log("Valor del parametro2: " + parametro2)

        let nombre = document.querySelector('#nombre_vehicul');
        let apellido1 = document.querySelector('#apellido_vehicul');
        let apellido2 = document.querySelector('#apellido2_vehicul');
        let id = document.querySelector('#identificaci_vehicul');
        let btnagregar = document.querySelector('#btn_agrega_vehiculo');
        let btregresar = document.querySelector('#btn_regresar');
        nombre.value = parametro2;
        apellido1.value = parametro3;
        apellido2.value = parametro4;
        id.value = parametro1;

        btnagregar.addEventListener('click', () => {
            Swal.fire(
                'Good job!',
                'Vehiculo se agrego con exito!',
                'Aceptar'
            )
            window.location.href = 'clientes.php'

        })


        btregresar.addEventListener('click', () => {

            window.location.href = 'clientes.php'
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
    });
</script>

<!-- <script>
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
</script> -->


<!-- <script>
    // Función para obtener los valores de los parámetros de la URL
    function getURLParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // Obtén los valores de los parámetros de la URL
    var parametro1 = getURLParameter("id");
    var parametro2 = getURLParameter("nombre");

    // Utiliza los valores como desees
    console.log("Valor del parametro1: " + parametro1);
    console.log("Valor del parametro2: " + parametro2)
</script> -->


<!-- Se arma como un rompecabezas el fin del HTML esta en el footer -->
<?php
incluirTempleate('footer');
?>