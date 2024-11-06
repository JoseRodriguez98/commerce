<?php
include_once '../Models/ProductoTienda.php';
include_once '../Util/Config/config.php';
include_once '../Models/Pregunta.php';
include_once '../Models/Respuesta.php';
$producto_tienda = new ProductoTienda();
$pregunta = new Pregunta();
$respuesta = new Respuesta();
session_start();

if ($_POST['funcion'] == 'realizar_respuesta') {
    if(!empty($_SESSION['id'])){
        $resp = $_POST['respuesta'];
        $id_pregunta = $_POST['id_pregunta'];
        
        $respuesta->create($resp, $id_pregunta);
        $json = array(
            'mensaje' => 'respuesta creada',
        );
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    else{
        echo 'error, usuario no está en sesion';
    }
 
}

