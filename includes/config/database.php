<?php
   
 function conectarBD() : mysqli{
    $db = mysqli_connect('89.117.169.154', 'u823370353_vic2691', '!hc&r>5Ka', 'u823370353_MRAutomotriz');
    $db ->set_charset("utf8");
    
    if(!$db){
        echo "Error en la conexion";
        exit;
    }
    else{
        // echo "Conexion exitosa"; 
    }
    return $db;
 }


