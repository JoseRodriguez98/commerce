<?php
include_once '../Models/ProductoTienda.php';
include_once '../Util/Config/config.php';
include_once '../Models/Pregunta.php';
$producto_tienda = new ProductoTienda();
$pregunta = new Pregunta();
session_start();

if ($_POST['funcion'] == 'realizar_pregunta') {
    if(!empty($_SESSION['id'])){
        $pgt = $_POST['pregunta'];
        $id_usuario = $_SESSION['id'];
        $formateado =  str_replace(' ', '+', $_SESSION['product-verification']);
        $id_producto_tienda = openssl_decrypt($formateado,CODE,KEY);
        $pregunta->create($pgt, $id_producto_tienda, $id_usuario);
        $json = array(
            'mensaje' => 'Pregunta creada',
        );
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    else{
        echo 'error, usuario no está en sesion';
    }
 
}

