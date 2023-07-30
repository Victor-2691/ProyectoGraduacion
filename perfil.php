<?php

require 'includes/funciones.php';
incluirTempleate('header_interno');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
</head>
<body>
    <h1>Pedro Riveiro, 35</h1>

    <div class="card">
        <div class="content">
            <h2>Mi Perfil</h2>
            <a href="#">Editar Intereses</a>
            <a href="#">Editar Preferencias</a>
            <a href="subir.php">Editar Fotos</a>
            <a href="#">Editar Configuración</a>
        </div>
    </div>
</body>

<?php
incluirTempleate('footer');
?>
</html>