<?php

include_once '../Util/Config/config.php';
include_once '../Models/Notificacion.php';
include_once '../Models/Historial.php';

$notificacion = new Notificacion();
$historial = new Historial();
session_start(); 
date_default_timezone_set('America/Santiago');
$fecha_actual = date("d-m-Y");
if ($_POST['funcion'] == 'read_notificaciones') {
    $bandera = '';
    if(!empty($_SESSION['id'])){
        $id_usuario = $_SESSION['id'];
        $notificacion->read($id_usuario);
        //var_dump($notificacion);
        $json = array();
        foreach ($notificacion->objetos as $objeto) {
            $fecha_hora = date_create($objeto->fecha_creacion);
            $hora = $fecha_hora->format('H:i:s');
            $fecha= date_format($fecha_hora, 'd-m-Y');
            if($fecha_actual==$fecha){
                $bandera = '1';

            }else{
                $bandera = '0';
            }
            $json[] = array(
                'id' => openssl_encrypt($objeto->id, CODE, KEY),
                'titulo' => $objeto->titulo,
                'asunto' => $objeto->asunto,
                'contenido' => $objeto->contenido,
                'imagen' => $objeto->imagen,
                'url_1' => $objeto->url_1,
                'fecha_creacion' => $objeto->fecha_creacion,
                'fecha'=>$fecha,
                'hora'=>$hora,
                'hoy'=>$bandera,
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    else{
        echo 'error, usuario no está en sesion';
    }
 
}

if ($_POST['funcion'] == 'read_all_notificaciones') {
    $bandera = '';  
    if(!empty($_SESSION['id'])){
        $id_usuario = $_SESSION['id'];
        $notificacion->read_all_notificaciones($id_usuario);
        //var_dump($notificacion);
        $json = array();
        foreach ($notificacion->objetos as $objeto) {
            $fecha_hora = date_create($objeto->fecha_creacion);
            $hora = $fecha_hora->format('H:i:s');
            $fecha= date_format($fecha_hora, 'd-m-Y');
            if($fecha_actual==$fecha){
                $bandera = '1';

            }else{
                $bandera = '0';
            }
            $json[] = array(
                'id' => openssl_encrypt($objeto->id, CODE, KEY),
                'titulo' => $objeto->titulo,
                'asunto' => $objeto->asunto,
                'contenido' => $objeto->contenido,
                'imagen' => $objeto->imagen,
                'url_1' => $objeto->url_1,
                'fecha_creacion' => $objeto->fecha_creacion,
                'fecha'=>$fecha,
                'hora'=>$hora,
                'hoy'=>$bandera,
                'estado_abierto' => $objeto->estado_abierto
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    else{
        echo 'error, usuario no está en sesion';
    }
 
}

if ($_POST['funcion'] == 'eliminar_notificacion') {
    if(!empty($_SESSION['id'])){
        $id_usuario = $_SESSION['id'];
        $id_notificacion_encypted = $_POST['id_notificacion'];
        $formateado =  str_replace(' ', '+', $id_notificacion_encypted);
        $id_notificacion = openssl_decrypt($formateado,CODE,KEY);
        $mensaje = '';
        if(is_numeric($id_notificacion)){
            $notificacion->update_remove($id_notificacion);
            $descripcion = 'Eliminaste una notificación';
            $historial->crear_historial($descripcion,3,5,$id_usuario);
            $mensaje = 'Notificacion eliminada';
        }
        else{
            $mensaje = 'Error al eliminar';
        }
        $json = array(
            'mensaje1'=>$mensaje
        );
        $jsonstring = json_encode($json);
        echo $jsonstring;
        
        
    }
    else{
        echo 'error, usuario no está en sesion';
    }
 
}

