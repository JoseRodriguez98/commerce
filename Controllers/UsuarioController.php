<?php
include_once '../Models/Usuario.php';
$usuario = new Usuario();
session_start();

if ($_POST['funcion'] == 'login') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $usuario->loguearse($user, $pass);
    if ($usuario->objetos != null) {
        foreach ($usuario->objetos as $objeto) {
            $_SESSION['id'] = $objeto->id;
            $_SESSION['user'] = $objeto->user;
            $_SESSION['tipo_usuario'] = $objeto->id_tipo;
            $_SESSION['avatar'] = $objeto->avatar;
        }
        echo 'logueado';
    }
}

if ($_POST['funcion'] == 'verificar_sesion') {
    if (!empty($_SESSION['id'])) {
        $json[] = array(
            'id' => $_SESSION['id'],
            'user' => $_SESSION['user'],
            'tipo_usuario' => $_SESSION['tipo_usuario'],
            'avatar' => isset($_SESSION['avatar']) ? $_SESSION['avatar'] : null // Verificar si 'avatar' está definido
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    } 
    else {
        echo '';
    }
}

if ($_POST['funcion'] == 'verificar_usuario') {
    $username = $_POST['value'];
    $usuario->verificar_usuario($username);
    if ($usuario->objetos != null) {
        echo 'success'; 
    }
}

if ($_POST['funcion'] == 'registrar_usuario') {
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $rut = $_POST['rut'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $usuario->registrar_usuario($username, $pass, $nombres, $apellidos, $rut, $email, $telefono);
}

if ($_POST['funcion'] == 'obtener_datos') {
    $usuario->obtener_datos($_SESSION['id']);
    var_dump($usuario->objetos);
}