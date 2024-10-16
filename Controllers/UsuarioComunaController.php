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