<?php
require 'includes/funciones.php';
incluirTempleate('header_empleados');
require 'includes/config/database.php';
$db = conectarBD();

?>
<!DOCTYPE html>
<html lang="en">
<main class="contenedorform seccion">
    <form id="formularioclientes" class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset class="fielsombra">
            <legend>Nuevo Cliente</legend>

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
                <option disabled selected>-- Seleccione --</option>
            </select>

            <label for="Canton">Cantón:</label>
            <select name="Canton" id="Canton">
                <option disabled selected>-- Seleccione --</option>
            </select>

            <label for="Distrito">Distrito:</label>
            <select name="Distrito" id="Distrito">
                <option disabled selected>-- Seleccione --</option>
            </select>


            <label for="fecha">Fecha de nacimiento</label>
            <input name="fecha_nacimiento" type="date" id="fechaNacimiento" min="1930-01-01" max="2010-01-01">

            <label for="Direccion">Dirección</label>
            <textarea maxlength="150" name="Direccion" id="Direccion"></textarea>

            <div class="contiene">
                <div class="formulario_enviar">
                    <!-- <input id="btn_submint" type="submit" value="REGISTRAR" class="boton-negro"> -->

                    <button id="btn_registro" type="button" class="boton-negro">
                        Registrar
                    </button>
                    <button id="btn_regreso_registro" type="button" class="boton-negro" onclick="btnregresar()">
                        Regresar
                    </button>
                </div>

            </div>

        </fieldset>
    </form>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // #region Cargar Select Provincia
        const Provincia = document.getElementById("Provincia");
        const Canton = document.getElementById("Canton");
        const Distrito = document.getElementById("Distrito");
        //Cargar el Combo de Provincias
        var parametros = {
            "codigoCrud": 4
        };
        $.ajax({
            data: parametros,
            url: 'funcionesphp/crud_clientes.php',
            type: 'POST',
            dataType: 'json',
            success: function(mensaje) {

                mensaje.forEach(item => {
                    const newOption = new Option(item.Nombre_Provincia, item.Codigo_Provincia);
                    Provincia.appendChild(newOption);
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

        Provincia.addEventListener("change", function() {
            const codigoprovincia = Provincia.value;
            Canton.length = 1;
            Distrito.length = 1;
            var parametros = {
                "codigoCrud": 5,
                "codigoProvincia": codigoprovincia
            };
            $.ajax({
                data: parametros,
                url: 'funcionesphp/crud_clientes.php',
                type: 'POST',
                dataType: 'json',
                success: function(mensaje) {
                    // console.log(mensaje);
                    mensaje.forEach(item => {
                        const newOption = new Option(item.Nombre_Canton, item.Codigo_Canton);
                        Canton.appendChild(newOption);
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

        Canton.addEventListener("change", function() {
            const codigocanton = Canton.value;
            // console.log(codigocanton);
            Distrito.length = 1;
            var parametros = {
                "codigoCrud": 6,
                "codigoCanton": codigocanton
            };
            $.ajax({
                data: parametros,
                url: 'funcionesphp/crud_clientes.php',
                type: 'POST',
                dataType: 'json',
                success: function(mensaje) {
                    // console.log(mensaje);
                    mensaje.forEach(item => {
                        const newOption = new Option(item.Nombre, item.Codigo_Distrito);
                        Distrito.appendChild(newOption);
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

        // #endregion
        const formulario = document.querySelector('#formularioclientes');
        const btnsubmit = document.querySelector('#btn_registro');
        const nombreInput = formulario.querySelector('[name="nombre"]');
        const primerapellido = formulario.querySelector('[name="primer_apellido"]');
        const segundoapellido = formulario.querySelector('[name="segundo_apellido"]');
        const id = formulario.querySelector('[name="id"]');
        const correo = formulario.querySelector('[name="correo"]');
        const telefono = formulario.querySelector('[name="telefono"]');
        const fecha_nacimiento = formulario.querySelector('[name="fecha_nacimiento"]');
        const Direccion = formulario.querySelector('[name="Direccion"]');
        btnsubmit.addEventListener("click", function() {
            // event.preventDefault();
            const indiceProvincia = Provincia.selectedIndex;
            const indiceCanton = Canton.selectedIndex;
            const indiceDistrito = Distrito.selectedIndex;
            console.log(indiceProvincia);
            console.log(indiceCanton);
            console.log(indiceDistrito);

            if (!validarCamposVacios(nombreInput.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingrese un nombre valido',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (!validarCamposVacios(primerapellido.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingrese un primer apellido valido',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (!validarCamposVacios(segundoapellido.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingrese un segundo apellido valido',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (!validarCamposVacios(id.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingrese una identificación valida',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }


            if (!validarEmail(correo.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingrese un correo valido',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (!validarNumero(telefono.value)) {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingrese un número válido',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }


            if (indiceProvincia == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar una provincia',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (indiceCanton == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar un cantón',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (indiceDistrito == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar un distrito',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (!validarFecha(fecha_nacimiento.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingrese una fecha valida',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }

            if (!validarComentario(Direccion.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingrese una dirección valida que no sobrepase los 150 caracteres',
                })
                // event.preventDefault(); // Evita el envío del formulario
                return;
            }
     


            // Si pasa todas las validaciones, el formulario se enviará
            var parametros = {
                "codigoCrud": 2,
                "nombreInput": nombreInput.value,
                "primerapellido": primerapellido.value,
                "segundoapellido": segundoapellido.value,
                "id": id.value,
                "correo": correo.value,
                "telefono": telefono.value,
                "fecha_nacimiento": fecha_nacimiento.value,
                "Direccion": Direccion.value,
                "Provincia": Provincia.value,
                "Canton": Canton.value,
                "Distrito": Distrito.value
            };
            $.ajax({
                data: parametros,
                url: 'funcionesphp/crud_clientes.php',
                type: 'POST',
                success: function(mensaje) {
                    switch (mensaje) {
                        case '1':
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'La identificación que intenta ingresar ya se encuentra registrada',
                            })
                            break;
                        case '2':
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'El celular que intenta ingresar ya se encuentra registrado en otro cliente',
                            })
                            break;
                        case '3':
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'El correo electrónico ya se encuentra registrado en otro cliente',
                            })
                            break;

                        case '4':
                            Swal.fire(
                                'El cliente se registro con éxito',
                                'Presione para continuar!',
                                'success'
                            )
                            window.location.href = 'clientes.php';
                            break;
                        default:
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: mensaje,
                            })
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


        });

        function validarCamposVacios(nombre) {
            // Realiza tus validaciones aquí, devuelve true si es válido
            return nombre.trim() !== "";
        }

        function validarEmail(email) {
            // Realiza tus validaciones aquí, devuelve true si es válido
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function validarFecha(fecha) {
            // Verifica si la fecha es nula, vacía o inválida
            return fecha !== null && fecha.trim() !== "";
        }

        function validarNumero(valor) {
            return valor !== "" && /^\d+$/.test(valor);
        }

        function validarComentario(comentario) {
            // Verifica que no haya espacios vacíos y que tenga hasta 150 caracteres
            return comentario.trim() !== "" && comentario.length <= 150;
        }


    });
</script>

<script>
    function btnregresar() {
        window.location.href = 'clientes.php';

    }
</script>




<!-- Se arma como un rompecabezas el fin del HTML esta en el footer -->
<?php
incluirTempleate('footer');
?>