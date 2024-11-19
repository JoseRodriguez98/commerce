<?php
include_once '../Models/ProductoTienda.php';
include_once '../Util/Config/config.php';
include_once '../Models/Pregunta.php';
include_once '../Models/Respuesta.php';
include_once '../Models/Notificacion.php';
include_once '../Models/Historial.php';
$producto_tienda = new ProductoTienda();
$pregunta = new Pregunta();
$respuesta = new Respuesta();
$notificacion = new Notificacion();
$historial = new Historial();
session_start();

if ($_POST['funcion'] == 'realizar_respuesta') {
    if(!empty($_SESSION['id'])){
        $id_usuario = $_SESSION['id'];
        $resp = $_POST['respuesta'];
        $id_pregunta = $_POST['id_pregunta'];
        $formateado =  str_replace(' ', '+', $_SESSION['product-verification']);
        $id_producto_tienda = openssl_decrypt($formateado,CODE,KEY);
        $respuesta->create($resp, $id_pregunta);
        /////////////////////////////////////////////////////////
        $producto_tienda->llenar_productos($id_producto_tienda);
        $titulo = $producto_tienda->objetos[0]->producto;
        $imagen = $producto_tienda->objetos[0]->imagen;
        $asunto = 'El vendedor te respondió';
        $url = 'Views/descripcion.php?name='.$titulo.'&&id='.$formateado;
        $pregunta->read_propietario_pregunta($id_pregunta);
        $id_propietario_pregunta = $pregunta->objetos[0]->id;
        $notificacion->create($titulo, $asunto, $resp, $imagen, $url, $id_propietario_pregunta);
        $descripcion = 'Ha respondido una pregunta: '.$resp.'. | En el producto: '.$titulo;
        $historial->crear_historial($descripcion,2,3,$id_usuario);

        $json = array(
            'mensaje1' => 'Pregunta creada',
            'mensaje2' => 'Notificacion enviada',
            'mensaje3' => 'Historial creado'
        );
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    else{
        echo 'error, usuario no está en sesion';
    }
 
}

