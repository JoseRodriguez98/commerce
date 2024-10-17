<?php
include_once '../Models/UsuarioComuna.php';
$usuario_comuna = new UsuarioComuna();
session_start();


if ($_POST['funcion'] == 'crear_direccion') {
    $id_usuario = $_SESSION['id'];
    $comuna_id = $_POST['comuna_id'];
    $direccion = $_POST['direccion'];
    $referencia = $_POST['referencia'];
    $usuario_comuna->crear_direccion($id_usuario,$comuna_id,$direccion,$referencia);
    echo 'success';
    
}

if ($_POST['funcion'] == 'llenar_direcciones') {
    $id_usuario = $_SESSION['id'];
    $usuario_comuna->llenar_direcciones($id_usuario);
    $json=array();
    foreach ($usuario_comuna->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id,
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
    $id_direccion = $_POST['id'];
    $usuario_comuna->eliminar_direccion($id_direccion);
    echo 'success';
    
}