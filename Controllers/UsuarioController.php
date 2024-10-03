<?php
include_once '../Models/Usuario.php';
$usuario = new Usuario();
session_start();
if($_POST['funcion']=='login'){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $usuario->loguearse($user,$pass);
    if($usuario->objetos!=null){
        foreach ($usuario->objetos as $objeto) {
            $_SESSION['id']=$objeto->id;
            $_SESSION['user']=$objeto->user;
            $_SESSION['tipo_usuario']=$objeto->id_tipo;
            $_SESSION['avatrar']=$objeto->avatar;
        }
        echo 'logueado';
    }
    
}

if($_POST['funcion']=='verificar_sesion'){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $usuario->loguearse($user,$pass);
    if($usuario->objetos!=null){
        foreach ($usuario->objetos as $objeto) {
            $_SESSION['id']=$objeto->id;
            $_SESSION['user']=$objeto->user;
            $_SESSION['tipo_usuario']=$objeto->id_tipo;
            $_SESSION['avatrar']=$objeto->avatar;
        }
        echo 'logueado';
    }
    
}
