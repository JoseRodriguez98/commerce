<?php
include_once '../Models/Comuna.php';
$comuna = new Comuna();
session_start();


if ($_POST['funcion'] == 'llenar_comunas') {
    $provincia_id = $_POST['provincia_id'];
    $comuna->llenar_comunas($provincia_id);
    $json = array();
    foreach ($comuna->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id,
            'comuna'=>$objeto->comuna,
            'provincia_id'=>$objeto->provincia_id
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
    
}