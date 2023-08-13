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
                    <legend>Buscar</legend>
                    <label id="lableBuscar" for="nombre">Buscar:</label>
                    <input maxlength="30" require name="Buscar" type="text" placeholder="Ingrese el parametro" id="Buscar" value="">
                    <div class="radio-container">

                        <label>Nombre
                            <input type="radio" name="busqueda" value="Nombre" checked />
                        </label>

                        <label>Celular
                            <input type="radio" name="busqueda" value="Ceular" />
                        </label>

                        <label>Cedula
                            <input type="radio" name="busqueda" value="Cedula" />
                        </label>
                    </div>
                    <button id="btn_buscar" class="boton-negro">
                        Buscar
                    </button>
                    <button id="btn_nuevocliente" class="boton-negro">
                        Nuevo Cliente
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

        formulario.addEventListener("submit", function(event) {
            event.preventDefault(); // Evita el comportamiento por defecto del formulario

            let btn_nuevo = document.querySelector('#btn_nuevocliente');
            //Opcion 1 con Function Anonima
            // Opcion 2 con flecha sin funcion anonima
            btn_nuevo.addEventListener('click', () => {

                window.location.href = 'nuevocliente.php';
            });

            // btn_nuevo.addEventListener('click', function() {

            // });





        });
        var parametros = {
            "codigoCrud": 1
        };
        $.ajax({
            data: parametros,
            url: 'funcionesphp/crud_clientes.php',
            type: 'POST',
            dataType: 'json',

            success: function(mensaje) {
                // mostrarData(mensaje);
                // for (let i = 0; i < mensaje.length; i++) {
                //     console.log(mensaje[i].nombre);
                // }
                mensaje.forEach(item => {
                    console.log(`Nombre: ${item.nombre}, Apellido: ${item.Primer_Apeliido}`);
                });
                CargarTabla(mensaje);

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

    });
</script>


<script>
    function CargarTabla(data) {
        // Fuerzo artificialmente a que dure más para que se pueda observar el Spinner

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
    <td>   <button class="boton-principal">Actualizar</button> </td>
    <td>   <button class="boton-principal">Vehiculos</button> </td>
 
    </tr>`
        }

        document.getElementById('tabladatos').innerHTML = body;

    }
</script>





<?php
incluirTempleate('footer');
?>