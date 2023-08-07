<?php

require 'includes/funciones.php';
incluirTempleate('header_administrativo');
require 'includes/config/database.php';
$db = conectarBD();
$consulta = "SELECT Usuarios.Nombre, Usuarios.Primer_apellido, Usuarios.Segundo_apellido,
Usuarios.Fecha_registro, Roles.Nombre_rol,Usuarios.identificacion
 FROM Usuarios, Roles WHERE Usuarios.id_rol = Roles.id_rol
AND Usuarios.estado = 0 
order by Usuarios.Fecha_registro ASC";
$ejecutar = mysqli_query($db, $consulta) ?? null;

?>

<main>
    <div class="contenedor_usuarios_aprobar">
        <div class="wrap">
            <ul class="tabs">
                <li><a href="#tab1"></span><span class="tab-text">Aprobar Usuarios</span> </a></li>
                <li><a href="#tab2"></span><span class="tab-text"> Usuarios Activos</span></a></li>
                <li><a href="#tab3"></span><span class="tab-text">Usuarios Rechazados</span></a></li>
                <!-- <li><a href="#tab4"><span class="fa fa-bookmark"></span><span class="tab-text">Coincidencias</span></a></li> -->
            </ul>
            <div class="secciones secciones_estilos">

                <article id="tab1" class="tab1_suspiros tabsuspiros_enviados">

                    <table class="table_aprobar_usuarios" id="miTabla">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Fecha Registro</th>
                                <th>Perfil</th>
                                <th colspan="2">Acciones</th>

                            </tr>
                        </thead>

                        <tbody class="tbody">
                            <?php foreach ($ejecutar as $key => $opciones) : ?>

                                <tr>
                                    <td class="hiden"><?php echo $opciones['identificacion'] ?> </td>
                                    <td><?php echo $opciones['Nombre'] ?> </td>
                                    <td><?php echo $opciones['Primer_apellido'] ?></td>
                                    <td><?php echo $opciones['Segundo_apellido'] ?></td>
                                    <td><?php echo $opciones['Fecha_registro'] ?></td>
                                    <td><?php echo $opciones['Nombre_rol'] ?></td>
                                    <td>
                                        <button class="boton-verde btn_aprobar accion">Aprobar</button>
                                    </td>
                                    <td>
                                        <button class="boton-rojo btn_denegar accion">Denegar</button>
                                    </td>



                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </article>

                <article id="tab3" class="tab1_suspiros">
                </article>

                <article id="tab2" class="tab1_suspiros tab_suspiros_recibidos">
                </article>

                <article id="tab4">

                </article>
            </div>
        </div>










    </div>
</main>



<script>
    // Obtener la referencia a la tabla
    const tabla = document.getElementById('miTabla');

    // Agregar un evento de clic a cada botón con clase "accion" dentro de la tabla
    const botones = tabla.getElementsByClassName('accion');
    for (let i = 0; i < botones.length; i++) {
        botones[i].addEventListener('click', function(event) {
            // Obtener la celda padre (td) que contiene el botón
            const celdaSeleccionada = event.target.closest('td');

            // Obtener el valor de la celda seleccionada
            const valorCelda = celdaSeleccionada.textContent.trim();
            console.log('Valor de la celda seleccionada:', valorCelda);

            // Obtener la fila (tr) a la que pertenece la celda seleccionada
            const filaSeleccionada = celdaSeleccionada.closest('tr');

            // Obtener el número de fila (índice de fila) de la celda seleccionada
            const numeroFila = filaSeleccionada.rowIndex;
            console.log('Número de fila:', numeroFila);

            // Obtener la fila deseada
            const filaDeseada = tabla.rows[numeroFila];

            // Obtener el valor de la celda en la columna 2 (tercera columna)
            const numeroColumnaDeseada = 0; // Si quieres obtener otra columna, cambia el índice aquí
            const id_usuario = filaDeseada.cells[numeroColumnaDeseada];
            const valor_id_usuario = id_usuario.textContent.trim();
            console.log('Valor de la celda deseada:', valor_id_usuario);

            const nombre = filaDeseada.cells[1];
            const valor_nombre = nombre.textContent.trim();
            console.log('Valor de la celda deseada:', valor_nombre);

            const apellido = filaDeseada.cells[2];
            const valor_apellido = apellido.textContent.trim();
            console.log('Valor de la celda deseada:', valor_apellido);

            if (valorCelda === 'Aprobar') {
                Swal.fire({
                    title: "Confirmar",
                    text: `¿Estas seguro que desea aprobar al usuario ${valor_nombre} ${valor_apellido} ?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let timerInterval
                        Swal.fire({
                            title: 'Procesando...',
                            html: '... <b></b> milliseconds.',
                            timer: 6000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                console.log('I was closed by the timer')
                            }
                        })

                        var parametros = {
                            "idusuario": valor_id_usuario,
                            "codigoCrud": 1
                        };
                        $.ajax({
                            data: parametros,
                            url: 'funcionesphp/crud_usuarios.php',
                            type: 'POST',

                            success: function(mensaje) {

                                if (mensaje == 1) {
                                    Swal.fire({
                                        position: 'top',
                                        icon: 'success',
                                        title: 'Acutalizado con exito',
                                        showConfirmButton: false,
                                        timer: 2000
                                    })

                                    location.reload();

                                }

                                if (mensaje == 0) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'error no se pudo actualizar el usuario!',

                                    })

                                    setInterval("location.reload()", 4000);

                                }


                            },

                            Error: function(jqXHR, textStatus, errorThrown) {
                                hideLoadingIndicator();
                                console.log(textStatus, errorThrown);
                            }

                        });

                    }
                })
            }


            if (valorCelda === 'Denegar') {
                Swal.fire({
                    title: "Confirmar",
                    text: `¿Estas seguro que desea denegar el acceso al usuario ${valor_nombre} ${valor_apellido} ?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let timerInterval
                        Swal.fire({
                            title: 'Procesando...',
                            html: '... <b></b> milliseconds.',
                            timer: 6000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                console.log('I was closed by the timer')
                            }
                        })
                        var parametros = {
                            "idusuario": valor_id_usuario,
                            "codigoCrud": 2
                        };
                        $.ajax({
                            data: parametros,
                            url: 'funcionesphp/crud_usuarios.php',
                            type: 'POST',

                            success: function(mensaje) {

                                if (mensaje == 1) {
                                    Swal.fire({
                                        position: 'top',
                                        icon: 'success',
                                        title: 'El acceso a este usuario fue denegado',
                                        showConfirmButton: false,
                                        timer: 4000
                                    })
                                    location.reload();

                                }

                                if (mensaje == 0) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'error no se pudo actualizar el usuario!',

                                    })
                                    setInterval("location.reload()", 2000);
                                }

                            },

                            Error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }

                        });

                    }
                })
            }


        });
    }
</script>





<?php
incluirTempleate('footer');
?>