<?php 
    if($_GET):
        $controler = $_GET['arquivo'];
        $metodo = $_GET['metodo'];
        require_once "classes/".$controler.".php";
        $obj = new $controler();
        $obj->$metodo();
    else:
        require_once "classes/controlador.php";
        $obj = new controlador();
        $obj->index();
    endif;
?>