<?php
include_once '../Models/Provincia.php';
$provincia = new Provincia();
session_start();


if ($_POST['funcion'] == 'llenar_provincias') {
    $region_id = $_POST['region_id'];
    $provincia->llenar_provincias($region_id);
    $json = array();
    foreach ($provincia->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id,
            'provincia'=>$objeto->provincia,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
    
}