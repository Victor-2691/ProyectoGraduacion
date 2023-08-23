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
                        <input placeholder="ingrese la placa" class="input-text" type="text" id="txtplaca" />
                    </div>

                    <div class="campo">
                        <label for="Marca">Marca</label>
                        <select class="input-text" name="Marca" id="Marca" onkeyup="filterSelectOptions(this, this)">
                            <option disabled selected>-- Seleccione --</option>
                        </select>
                    </div>



                    <div class="campo">
                        <label>Año</label>
                        <input id="txtanno" class="input-text" type="number" placeholder="ingrese año" />
                    </div>

                    <div class="campo">
                        <label for="Modelo">Modelo</label>
                        <select class="input-text" name="Modelo" id="Modelo" onkeyup="filterSelectOptions(this, this)">
                            <option disabled selected>-- Seleccione --</option>
                        </select>
                    </div>


                    <div class="campo">
                        <label for="transmision">Trasmisión</label>
                        <select class="input-text" name="transmision" id="transmision" onkeyup="filterSelectOptions(this, this)">
                            <option disabled selected>-- Seleccione --</option>
                            <option> Manual</option>
                            <option> Automático</option>
                        </select>
                    </div>


                    <div class="campo">
                        <label for="combustion">Combustión</label>
                        <select class="input-text" name="combustion" id="combustion" onkeyup="filterSelectOptions(this, this)">
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

 
        let txtplaca = document.querySelector('#txtplaca');
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

        // #region Cargar Select Marcas
        const Marca = document.getElementById("Marca");
        const Modelo = document.getElementById("Modelo");
        //Cargar el Combo de Marcas
        var parametros = {
            "codigoCrud": 3
        };
        $.ajax({
            data: parametros,
            url: 'funcionesphp/crud_vehiculos.php',
            type: 'POST',
            dataType: 'json',
            success: function(mensaje) {

                mensaje.forEach(item => {
                    const newOption = new Option(item.nombre, item.idMarca);
                    Marca.appendChild(newOption);
                });


            },
            Error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: textStatus & errorThrown,

                })
            }

        });

        Marca.addEventListener("change", function() {
            const codigoMarca = Marca.value;
            console.log(codigoMarca);
            Modelo.length = 1;
            var parametros = {
                "codigoCrud": 4,
                "id_marca": codigoMarca
            };
            $.ajax({
                data: parametros,
                url: 'funcionesphp/crud_vehiculos.php',
                type: 'POST',
                dataType: 'json',
                success: function(mensaje) {
                    // console.log(mensaje);
                    mensaje.forEach(item => {
                        const newOption = new Option(item.nombre, item.id_modelo);
                        Modelo.appendChild(newOption);
                    });


                },
                Error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: textStatus & errorThrown,

                    })
                }
            });
        });

        txtplaca.addEventListener("input", function(event) {
            let currentValue = event.target.value;
            event.target.value = currentValue.toUpperCase();
        });

        // Variables
        let combustion = document.querySelector('#combustion');
        let transmision = document.querySelector('#transmision');
        let txtanno = document.querySelector('#txtanno');
       

        btnagregar.addEventListener('click', () => {
            // Validaciones
            if (!validarCamposVacios(txtplaca.value)) {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar un numero de placa valido',
                })
                return;
            }

            if (!validarNumero(txtanno.value)) {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar un año valido',
                })
                return;
            }

            if (combustion.selectedIndex == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar un tipo de combustión',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }


            if (transmision.selectedIndex == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar un tipo transmisión',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }


            if (Marca.selectedIndex == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar una marca',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (Modelo.selectedIndex == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar un modelo',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }



            // Si pasa todas las validaciones, el formulario se enviará
            console.log(txtanno.value);
            console.log(Modelo.value);
            console.log(Marca.value);
            console.log(txtplaca.value);
            console.log(id.value);
            var parametros = {
                "codigoCrud": 5,
                "anno": txtanno.value,
                "id_modelo": Modelo.value,
                "id_marca": Marca.value,
                "placa": txtplaca.value,
                "id_cliente": id.value

            };
            $.ajax({
                data: parametros,
                url: 'funcionesphp/crud_vehiculos.php',
                type: 'POST',
                success: function(mensaje) {
                    switch (mensaje) {
                        case '0':
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'La placa que estas intentando registrar ya se encuentra en la base de datos',
                            })
                            break;
                        case '1':
                            Swal.fire(
                                'El cliente se registro con éxito',
                                'Presione para continuar!',
                                'success'
                            )
                            window.location.href = 'vehiculos.php';
                            break;
                         
                        default:
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: mensaje,
                               
                            })
                            console.log(mensaje);
                            break;
                    }
                },

                Error: function(jqXHR, textStatus, errorThrown) {
                    // console.log(textStatus, errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: textStatus & errorThrown,

                    })
                }

            });





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


    function validarCamposVacios(nombre) {
        // Realiza tus validaciones aquí, devuelve true si es válido
        return nombre.trim() !== "";
    }

    function validarNumero(valor) {
        return valor !== "" && /^\d+$/.test(valor);
    }
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