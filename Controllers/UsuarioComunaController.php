<?php
include_once '../Models/UsuarioComuna.php';
include_once '../Models/Historial.php';
include_once '../Util/Config/config.php';
$usuario_comuna = new UsuarioComuna();
$historial = new Historial();
session_start();


if ($_POST['funcion'] == 'crear_direccion') {
    $id_usuario = $_SESSION['id'];
    $comuna_id = $_POST['comuna_id'];
    $direccion = $_POST['direccion'];
    $referencia = $_POST['referencia'];
    $usuario_comuna->crear_direccion($id_usuario,$comuna_id,$direccion,$referencia);
    $descripcion = 'Ha creado una nueva dirección: '.$direccion;
    $historial->crear_historial($descripcion,2,1, $id_usuario);
    echo 'success';
    
}

if ($_POST['funcion'] == 'llenar_direcciones') {
    $id_usuario = $_SESSION['id'];
    $usuario_comuna->llenar_direcciones($id_usuario);
    $json=array();
    foreach ($usuario_comuna->objetos as $objeto){
        $json[]=array(
            'id'=>openssl_encrypt($objeto->id,CODE,KEY) ,
            'direccion'=>$objeto->direccion,
            'referencia'=>$objeto->referencia,
            'region'=>$objeto->region,
            'provincia'=>$objeto->provincia,
            'comuna'=>$objeto->comuna,
            
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'eliminar_direccion') {
    $id_direccion = openssl_decrypt($_POST['id'],CODE,KEY);
    if(is_numeric($id_direccion)){
        $usuario_comuna->recuperar_direccion($id_direccion);
        $direccion_borrada = $usuario_comuna->objetos[0]->direccion.', Comuna: '.$usuario_comuna->objetos[0]->comuna.', Provincia: '.$usuario_comuna->objetos[0]->provincia.', Región: '.$usuario_comuna->objetos[0]->region;
        $usuario_comuna->eliminar_direccion($id_direccion);
        $descripcion = 'Ha eliminado la dirección: '.$direccion_borrada;
        $historial->crear_historial($descripcion,3,1,$_SESSION['id']);
        echo 'success';

    }else{
        echo 'error';
    }
    ;
    
    
}