<?php

require 'includes/funciones.php';
incluirTempleate('header_administrativo');

// $consulta = "SELECT count(*) FROM suspiros";
// $ejecutar = mysqli_query($db, $consulta);
// $Resultado = mysqli_fetch_assoc($ejecutar);
// $TotalSuspiros = $Resultado['count(*)'];

// $consulta = "SELECT count(*) FROM likes";
// $ejecutar = mysqli_query($db, $consulta);
// $Resultado = mysqli_fetch_assoc($ejecutar);
// $Totalikes = $Resultado['count(*)'];

// $consulta = "
// SELECT count(id_cliente) FROM Clientes_Externos where id_genero_pertenece = 1";
// $ejecutar = mysqli_query($db, $consulta);
// $Resultado = mysqli_fetch_assoc($ejecutar);
// $TotalHombres = $Resultado['count(id_cliente)'];

// $consulta = "
// SELECT count(id_cliente) FROM Clientes_Externos where id_genero_pertenece = 3";
// $ejecutar = mysqli_query($db, $consulta);
// $Resultado = mysqli_fetch_assoc($ejecutar);
// $TotalBinarios = $Resultado['count(id_cliente)'];


// $consulta = "
// SELECT count(id_cliente) FROM Clientes_Externos where id_genero_pertenece = 2";
// $ejecutar = mysqli_query($db, $consulta);
// $Resultado = mysqli_fetch_assoc($ejecutar);
// $TotalMujeres = $Resultado['count(id_cliente)'];

?>
<main>
    <div class="container_perfil">
        <p hidden id="hiddensuspiros"> <?php echo $TotalSuspiros ?> </p>
        <p hidden id="hiddenlikes"> <?php echo $Totalikes  ?> </p>
        <p hidden id="hiddenHombres"> <?php echo $TotalHombres ?> </p>
        <p hidden id="hiddenBinarios"> <?php echo $TotalBinarios ?> </p>
        <p hidden id="hiddenMujeres"> <?php echo $TotalMujeres ?> </p>
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Total Ingresos</h6>
                        <h2 class="text-right"><i class="fa fa-rocket f-left"></i>
                            <span id="suspiros">0</span>
                        </h2>

                        <!-- <p class="m-b-0">Consultado<span class="f-right">04/18/2023</span></p> -->
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Coincidencias</h6>

                        <h2 class="text-right"><i class="fa fa-rocket f-left"></i>
                            <span id="coincidencias">0</span>
                        </h2>


                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-pink order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Usuarios</h6>

                        <h2 class="text-right"><i class="fa fa-credit-card f-left"></i>
                            <span id="masculinos">0</span>
                        </h2>

                    </div>
                </div>
            </div>





        </div>

        <p hidden id="l"> <?php echo $lunes ?> </p>
        <p hidden id="m"> <?php echo $martes ?> </p>
        <p hidden id="k"> <?php echo $miercoles ?> </p>
        <p hidden id="j"> <?php echo $jueves ?> </p>
        <p hidden id="v"> <?php echo $viernes ?> </p>
        <p hidden id="s"> <?php echo $sabado ?> </p>
        <p hidden id="d"> <?php echo $domingo ?> </p>

        <div class="contenedor_graficos">
            <div class="contenidografico">
                <canvas id="registroUsuarios"></canvas>
            </div>
            <!-- <div class="contenidografico">

                <canvas id="graficoPie"></canvas>
            </div> -->
        </div>


    </div>






</main>

<script>
    function onPageLoad() {
        let totalsuspiroshidden = document.getElementById('hiddensuspiros').innerText;
        let totalikeshidden = document.getElementById('hiddenlikes').innerText;
        let totalhombreshidden = document.getElementById('hiddenHombres').innerText;
        let totalbinarios = document.getElementById('hiddenBinarios').innerText;
        let totalfemenino = document.getElementById('hiddenMujeres').innerText;
        // Obtener el elemento del DOM que muestra el total
        var totalElement = document.getElementById('suspiros');
        var totalcoicidencias = document.getElementById('coincidencias');
        var variableLike = document.getElementById('likes');
        var elementomasculino = document.getElementById('masculinos');
        var elementobinario = document.getElementById('nobinarios');
        var elemenFemenino = document.getElementById('femeninos');

        // Valor de inicio y valor objetivo del total
        var startValue = 0;
        startIncrement(startValue, 90, totalElement);
        startIncrement(startValue, 80, totalcoicidencias);
        startIncrement(startValue, totalikeshidden, variableLike);
        startIncrement(startValue, 120, elementomasculino);
        startIncrement(startValue, totalbinarios, elementobinario);
        startIncrement(startValue, totalfemenino, elemenFemenino);


        // Función para iniciar el incremento
        function startIncrement(startValue, totalsuspiros, totalElement) {
            var intervalId = setInterval(function() {
                var valorint = parseInt(totalsuspiros);
                // Incrementar el valor de inicio en 1
                startValue++;

                // Actualizar el valor mostrado en el DOM
                totalElement.textContent = startValue;

                // Detener el incremento cuando se alcance el valor objetivo
                if (startValue === valorint) {

                    clearInterval(intervalId);
                }
            }, 20); // Puedes ajustar el intervalo de tiempo (en milisegundos) para controlar la velocidad de incremento
        }

        //   datos 
        // let l = document.getElementById('l').innerText;
        // let m = document.getElementById('k').innerText;
        // let k = document.getElementById('m').innerText;
        // let j = document.getElementById('j').innerText;
        // let v = document.getElementById('v').innerText;
        // let s = document.getElementById('s').innerText;
        // let d = document.getElementById('d').innerText;
        // 


        const ctx2 = document.getElementById('registroUsuarios');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
                datasets: [{
                    label: 'Ingresos por semana',
                    data: [50, 40, 30, 18, 14, 17, 0],
                    fill: false,
                    backgroundColor: [
                        'rgb(255, 87, 87)',

                    ],
                    tension: 0.1,

                }]
            },
            options: {


            }
        });


        // Datos del gráfico
        var datos = {
            labels: ['18 Años'],
            datasets: [{
                data: [8, 6, 5, 4, 3], // Datos numéricos
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'], // Colores de fondo
                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'] // Colores de fondo al pasar el cursor
            }]
        };

        // Opciones del gráfico
        var opciones = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Distribución de edad'
                }
            }
        };





        // Crear el gráfico de tipo Pie
        var ctx = document.getElementById('graficoPie').getContext('2d');
        var graficoPie = new Chart(ctx, {
            type: 'pie',
            data: datos,
            options: opciones

        });

        // 



    }





    // Asociar la función onPageLoad al evento load de window
    window.addEventListener('load', onPageLoad);
</script>



<?php
incluirTempleate('footer');
?>