<?php
include_once '../Models/ProductoTienda.php';
$producto_tienda = new ProductoTienda();
session_start();


if ($_POST['funcion'] == 'llenar_productos') {
    $producto_tienda->llenar_productos();
    var_dump($producto_tienda);
    /*$json = array();
    foreach ($provincia->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id,
            'provincia'=>$objeto->provincia,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
    */
}