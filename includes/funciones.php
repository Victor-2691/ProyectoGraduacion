<?php

require'app.php';

function incluirTempleate(string $nombre){

  include TEMPLATES_URL. "/{$nombre}.php";
     
}