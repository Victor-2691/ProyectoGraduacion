<?php

require 'includes/funciones.php';
incluirTempleate('header_empleados');
require 'includes/config/database.php';
$db = conectarBD();

// var_dump($json);
?>


<main>
    <div class="contenedor_principal_clientes">
        <div class="buscar_clientes">
            <form id="miFormulario" form class="formulario2" enctype="multipart/form-data">
                <fieldset class="fielsombra">
                    <legend>Clientes</legend>
                    <label id="lableBuscar" for="nombre">Buscar:</label>
                    <input maxlength="30" require name="Buscar" type="text" placeholder="Ingrese el parametro" id="Buscar">
                    <div class="radio-container">

                        <label>Nombre
                            <input type="radio" name="busqueda" value="1" checked />
                        </label>

                        <label>Celular
                            <input type="radio" name="busqueda" value="2" />
                        </label>

                        <label>Cédula
                            <input type="radio" name="busqueda" value="3" />
                        </label>
                    </div>
                    <button id="btn_buscar" class="boton-negro">
                        Buscar
                    </button>
                    <button id="btn_limpiar" class="boton-negro">
                        Limpiar
                    </button>
                    <button id="btn_nuevocliente" class="boton-negro">
                        Nuevo
                    </button>
                </fieldset>
            </form>
        </div>

        <div class="tabla_clientes">
            <table class="table_aprobar_usuarios" id="miTabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th>Cédula</th>
                        <th>Teléfono</th>
                        <th>Provincia</th>
                        <th>Cantón</th>
                        <th colspan="2">Acciones</th>

                    </tr>
                </thead>

                <tbody class="tbody" id="tabladatos">

                </tbody>
            </table>

        </div>



    </div>


</main>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const formulario = document.getElementById("miFormulario");
        consultartodosClientes();
        formulario.addEventListener("submit", function(event) {
            event.preventDefault(); // Evita el comportamiento por defecto del formulario
        });
        let btn_nuevo = document.querySelector('#btn_nuevocliente');
        //Opcion 1 con Function Anonima
        // Opcion 2 con flecha sin funcion anonima
        btn_nuevo.addEventListener('click', () => {
            window.location.href = 'nuevocliente.php';
        });

        //  EVENTO CLICK BUSCAR INICIO
        let btn_buscar = document.querySelector('#btn_buscar');
        let textboxbuscar = document.querySelector('#Buscar');
        btn_buscar.addEventListener('click', () => {
            // Validar que el buscar tenga datos
            if (!validarCamposVacios(textboxbuscar.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar un valor para poder realizar la busqueda',
                })
                return;
            }
            let radioselecciona = document.getElementsByName('busqueda')
            let valueseleccionado;
            for (const radioButton of radioselecciona) {
                if (radioButton.checked) {
                    valueseleccionado = radioButton.value;
                    console.log(`El radio button seleccionado es: ${valueseleccionado}`);
                    break; // Detenemos el bucle una vez que encontramos el seleccionado
                }
            }
            //  Buscar por nombre
            if (valueseleccionado == 1) {
                consultartodosfiltro(11, textboxbuscar.value);
            }
            //   Buscar por telefono
            if (valueseleccionado == 2) {
                consultartodosfiltro(12, textboxbuscar.value)

            }
            // Buscar por cedula
            if (valueseleccionado == 3) {
                consultartodosfiltro(13, textboxbuscar.value)
            }
        });
        //  EVENTO CLICK BUSCAR FINAL
        let btnlimpiar = document.querySelector('#btn_limpiar');
        btnlimpiar.addEventListener('click', () => {
            LimpiarTabla();
            consultartodosClientes();
            textboxbuscar.value = "";

        });
    });
</script>

<script>
    function consultartodosClientes() {
        var parametros = {
            "codigoCrud": 1
        };
        $.ajax({
            data: parametros,
            url: 'funcionesphp/crud_clientes.php',
            type: 'POST',
            dataType: 'json',
            success: function(mensaje) {

                CargarTabla(mensaje);

                // Agrega el evento click a los botones en la tabla
                $('#miTabla').on('click', '.accion-actualizar', function() {
                    // Manejar el clic del botón "Actualizar"
                    var fila = $(this).closest("tr");
                    var idfila = fila.find("td:eq(3)").text();
                    var nombrefila = fila.find("td:eq(0)").text();
                    var apellido1fila = fila.find("td:eq(1)").text();
                    var apellido2fila = fila.find("td:eq(2)").text();
                    var id = "";
                    var nombre = "";
                    var apellido1 = "";
                    var apellido2 = "";
                    var nuevaURL = "";
                    Swal.fire({
                        title: "Confirmar",
                        text: `¿Estas seguro que desea agregar actualizar al cliente ${nombrefila}${apellido1fila} ${apellido2}  ?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirmar !'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                id = idfila,
                                nombre = nombrefila,
                                apellido1 = apellido1fila,
                                apellido2 = apellido2fila,

                                // Construye la URL con las variables
                                nuevaURL = "nueva_pagina.html" + "?id=" + encodeURIComponent(id) + "&nombre=" + encodeURIComponent(nombre) + "&apellido1=" + encodeURIComponent(apellido1) +
                                "&apellido2=" + encodeURIComponent(apellido2),

                                // Redirige a la nueva URL
                                window.location.href = nuevaURL,

                            )
                        }
                    })

                });

                $('#miTabla').on('click', '.accion-vehiculos', function() {
                    // Manejar el clic del botón "Vehiculos"
                    // Manejar el clic del botón "Actualizar"
                    var fila = $(this).closest("tr");
                    var idfila = fila.find("td:eq(3)").text();
                    var nombrefila = fila.find("td:eq(0)").text();
                    var apellido1fila = fila.find("td:eq(1)").text();
                    var apellido2fila = fila.find("td:eq(2)").text();
                    var id = "";
                    var nombre = "";
                    var apellido1 = "";
                    var apellido2 = "";
                    var nuevaURL = "";

                    Swal.fire({
                        title: "Confirmar",
                        text: `¿Estas seguro que desea agregar un vehiculo al cliente ${nombrefila} ${apellido1fila} ${apellido2}  ?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirmar !'
                    }).then((result) => {
                        if (result.isConfirmed) {
                                id = idfila,
                                nombre = nombrefila,
                                apellido1 = apellido1fila,
                                apellido2 = apellido2fila,
                                // Construye la URL con las variables
                              // Construye la URL con las variables
                              nuevaURL = "agregarvehiculo.php" + "?id=" + encodeURIComponent(id) + "&nombre=" + encodeURIComponent(nombre) + "&apellido1=" + encodeURIComponent(apellido1) +
                                "&apellido2=" + encodeURIComponent(apellido2),

                                // Redirige a la nueva URL
                                window.location.href = nuevaURL

                        }
                    })



                });
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
    }
</script>

<script>
    function CargarTabla(data) {
        let body = ''

        for (let i = 0; i < data.length; i++) {
            console.log(data[i].Id);
            body +=
                `<tr>
    <td>${data[i].nombre}</td>
    <td>${data[i].Primer_Apeliido}</td>
    <td>${data[i].segundo_apellid}</td>
    <td>${data[i].identificacion}</td>
    <td>${data[i].celular}</td>
    <td>${data[i].Nombre_Provincia}</td>
    <td>${data[i].Nombre_Canton}</td>
    <td>   <button class="boton-principal accion-actualizar">Actualizar</button> </td>
    <td>   <button class="boton-principal accion-vehiculos">+Vehiculo</button> </td>
 
    </tr>`
        }

        document.getElementById('tabladatos').innerHTML = body;

    }
</script>


<script>
    function consultartodosfiltro(codigobuscar, valorbuscar) {
        var parametros = {
            "codigoCrud": codigobuscar,
            "valorbuscar": valorbuscar
        };
        $.ajax({
            data: parametros,
            url: 'funcionesphp/crud_clientes.php',
            type: 'POST',
            dataType: 'json',
            success: function(mensaje) {

                if (mensaje == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No se encontraron clientes con los parametros indicados!',

                    })
                    return;

                } else {
                    LimpiarTabla();
                    CargarTabla(mensaje);
                    return;
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
    }

    function LimpiarTabla() {
        const tabla = document.getElementById("miTabla");
        const filas = tabla.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
        // Empezamos desde la segunda fila, ya que queremos mantener los encabezados (primera fila)
        for (let i = filas.length; i > 0; i--) {
            tabla.deleteRow(i);
        }

    }
</script>

<script>
    function validarCamposVacios(nombre) {
        // Realiza tus validaciones aquí, devuelve true si es válido
        return nombre.trim() !== "";
    }
</script>


<?php
incluirTempleate('footer');
?>