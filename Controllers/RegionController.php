<?php
include_once '../Models/Region.php';
$region = new Region();
session_start();


if ($_POST['funcion'] == 'llenar_regiones') {
    $region->llenar_regiones();
    foreach ($region->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id,
            'region'=>$objeto->region,
            'abreviatura'=>$objeto->abreviatura,
            'capital'=>$objeto->capital
            
        );

    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}