<?php
require 'includes/config/database.php';
$db = conectarBD();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>


<input type="button" value="saludame" onclick="saludame();">
<div id="mostrar_mensaje"></div>

<script>
	function saludame()
    { 
  
      var parametros = 
      {
        "idenvia" : "1",
        "idrecibe" : "2",
        // La ultima no lleva coma
        "fecha" : "2023-04-07"
      };

      $.ajax({
        data: parametros,
        // Codigo php que se va a ejecutar 
        url: 'insertasuspiro.php',
        type: 'POST',
        
        // Mensajes 
        beforesend: function()
        {
            // Para identificar elementos HTML #ID .CLASS
          $('#mostrar_mensaje').html("Mensaje antes de Enviar");
        },

        // Este mensaje lo recibe desde PHP
        success: function(mensaje)
        {
          $('#mostrar_mensaje').html(mensaje);
        }
      });
    }


</script>
    
</body>
</html>
