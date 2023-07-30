<?php
require 'includes/funciones.php';
incluirTempleate('header_interno');
// Conexion a base de datos
require 'includes/config/database.php';
$db = conectarBD();
if (isset($_SESSION['idcliente'])) {
    $sessionid = $_SESSION['idcliente'];
} else {
    header('location: inicio_sesion.php');
}

?>
<main>
    <div class="contenedor_histosupiros">
        <div class="wrap">
            <ul class="tabs">
                <li><a href="#tab1"><span class="fa fa-home"></span><span class="tab-text">Enviados</span></a></li>
                <li><a href="#tab2"><span class="fa fa-group"></span><span class="tab-text">Recibidos</span></a></li>
                <li><a href="#tab3"><span class="fa fa-briefcase"></span><span class="tab-text">Correspondidos</span></a></li>
                <!-- <li><a href="#tab4"><span class="fa fa-bookmark"></span><span class="tab-text">Coincidencias</span></a></li> -->
            </ul>
            <div class="secciones secciones_estilos">
                <!-- Suspiros Enviados -->
                <article id="tab1" class="tab1_suspiros tabsuspiros_enviados">

                    <div class="card_suspiros">
                        <img class="img_histo_perfil" src="" alt="img">

                        <div class="content_suspiros">

                            <h2> <span class="edad"> </span> </h2>
                            <p> </p>
                            <div class="btn_contenedor_suspiro">
                                <button class="btn_hover btn_suspiro_cancelar">
                                </button>
                                <h2 hidden class="nombre_enviado"> </h2>
                                <p hidden class="id_historial_enviados"> </p>
                            </div>
                        </div>
                    </div>

                </article>
                <!-- Fin suspiros Enviados -->

                <!-- Suspiros Recibidos -->
                <article id="tab2" class="tab1_suspiros">

                </article>
                <!-- Fin suspiros Recibidos -->


                <!-- ARTICULO YA NO ME GUSTA -->
                <article id="tab3">
                    <h1>Ya No Me gusta</h1>
                    <h1>Le gusta</h1>
                </article>
                <!-- ARTICULO COINCIDENCIAS -->
                <article id="tab4">
                    <h1>Coincidencias</h1>
                    <h1>Le gusta</h1>
                </article>
            </div>
        </div>


    </div>

</main>

<!-- Funcion para insertar Suspiros -->
<script>
    const tabsuspirosenviados = document.querySelector('.tabsuspiros_enviados');
    tabsuspirosenviados.addEventListener('click', e => {
        const hero = e.target.parentElement;
        let nombre = (hero.querySelector('.nombre_enviado').textContent);
        let id = (hero.querySelector('.id_historial_enviados').textContent);
        console.log(nombre);
        console.log(id);
        if (e.target.classList.contains('btn_suspiro_cancelar')) {
            Swal.fire({
                title: "Confirmar",
                text: `¿Estas seguro que deseas cancelar el suspiro enviado ha ${nombre} ?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar !'
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelarsuspiro(id);
                    // window.location = `formulario.html?nombr=${nombre}&urlimg=${urlrecortado}`;
                }
            })
        }
    });
</script>

<script>
    function cancelarsuspiro(idhistorial) {

        var id = idhistorial;

        var parametros = {
            "idhistorial": id
        };

        $.ajax({
            data: parametros,
            url: 'funcionesphp/cancelasuspiro.php',
            type: 'POST',

            success: function(mensaje) {

                if (mensaje == 1) {
                    location.reload();

                }

                if (mensaje == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'error!',

                    })
                    setInterval("location.reload()", 2000);
                }
            },

            Error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    }
</script>


<?php
incluirTempleate('footer');
?>