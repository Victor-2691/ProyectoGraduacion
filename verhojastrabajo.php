<?php

require 'includes/funciones.php';
incluirTempleate('header_empleados');
require 'includes/config/database.php';
$db = conectarBD();

// var_dump($json);
?>


<main>
    <div class="contenedor_principal_clientes">
        <div class="tabla_clientes">
            <table class="table_aprobar_usuarios" id="miTabla">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Fecha creación</th>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody class="tbody" id="tabladatos">
                    <tr>
                        <td>34787834</td>
                        <td>21/08/2023</td>
                        <td>KJ45</td>
                        <td>Audi</td>
                        <td>A3</td>
                        <td>Carlos Mora</td>
                        <td>Enviada</td>
                        <td>   <button class="boton-principal accion-actualizar">Detalles</button> </td>
                    </tr>
                    </tr>
                    <tr>
                        <td>1245</td>
                        <td>23/08/2023</td>
                        <td>RFS-325</td>
                        <td>Ford</td>
                        <td>Focus</td>
                        <td>Pedro Lopez</td>
                        <td>Enviada</td>
                        <td>   <button class="boton-principal accion-actualizar">Detalles</button> </td>
                    </tr>
     
 

                </tbody>
            </table>

        </div>



    </div>


</main>


<script>
   


<?php
incluirTempleate('footer');
?>