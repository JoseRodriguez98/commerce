<?php
include_once '../Models/Usuario.php';
include_once '../Util/Config/config.php';
$usuario = new Usuario();
session_start();

if ($_POST['funcion'] == 'login') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $usuario->verificar_usuario($user);
    if ($usuario->objetos != null) {
        $pass_bd = openssl_decrypt($usuario->objetos[0]->pass,CODE,KEY);
        if($pass_bd == $pass){
                $_SESSION['id'] = $usuario->objetos[0]->id;
                $_SESSION['user'] = $usuario->objetos[0]->user;
                $_SESSION['tipo_usuario'] = $usuario->objetos[0]->id_tipo;
                $_SESSION['avatar'] = $usuario->objetos[0]->avatar;
                echo 'logueado';
        }  
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
    $pass = openssl_encrypt($_POST['pass'],CODE,KEY);
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $rut = $_POST['rut'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $usuario->registrar_usuario($username, $pass, $nombres, $apellidos, $rut, $email, $telefono);
}

if ($_POST['funcion'] == 'obtener_datos') {
    $usuario->obtener_datos($_SESSION['id']);
    foreach ($usuario->objetos as $objeto){
        $json[]=array(
            'username'=>$objeto->user,
            'nombres'=>$objeto->nombres,
            'apellidos'=>$objeto->apellidos,
            'rut'=>$objeto->rut,
            'email'=>$objeto->email,
            'telefono'=>$objeto->telefono,
            'avatar'=>$objeto->avatar,
            'tipo_usuario'=>$objeto->tipo
        );

    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}

if ($_POST['funcion'] == 'editar_datos') {
    $id_usuario = $_SESSION['id'];
    $nombres = $_POST['nombres_mod'];
    $apellidos = $_POST['apellidos_mod'];
    $rut = $_POST['rut_mod'];
    $email = $_POST['email_mod'];
    $telefono = $_POST['telefono_mod'];
    $avatar = $_FILES['avatar_mod']['name'];
    if($avatar!=''){
        $nombre = uniqid().'-'.$avatar;
        $ruta = '../Util/Img/Users/'.$nombre;
        move_uploaded_file($_FILES['avatar_mod']['tmp_name'],$ruta);
        $usuario->obtener_datos($id_usuario);
        foreach ($usuario->objetos as $objeto){
            $avatar_actual = $objeto->avatar;
            if($avatar_actual!='user_default.png'){
               unlink('../Util/Img/Users/'.$avatar_actual);
            } 
        }
        $_SESSION['avatar'] = $nombre;
    }else{
        $nombre = '';

    }
    
    $usuario->editar_datos($id_usuario, $nombres, $apellidos, $rut, $email, $telefono, $nombre);
    echo 'success';
}


if ($_POST['funcion'] == 'cambiar_contra') {
    $id_usuario = $_SESSION['id'];
    $user = $_SESSION['user'];
    $pass_old = $_POST['pass_old'];
    $pass_new = $_POST['pass_new'];
    $usuario->verificar_usuario($user);
    if(!empty($usuario->objetos)){
        $pass_bd = openssl_decrypt($usuario->objetos[0]->pass,CODE,KEY);
        if($pass_bd==$pass_old){
            $pass_new_encriptada = openssl_encrypt($pass_new,CODE,KEY);
            $usuario->cambiar_contra($id_usuario, $pass_new_encriptada);
            echo 'success';
        }else{
            echo 'error';
        }
    }else{
        echo 'error';
    }
}