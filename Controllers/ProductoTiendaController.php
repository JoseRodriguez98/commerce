<?php
include_once '../Models/ProductoTienda.php';
include_once '../Util/Config/config.php';
include_once '../Models/Resena.php';
include_once '../Models/Imagen.php';
include_once '../Models/Tienda.php';
include_once '../Models/Caracteristica.php';
include_once '../Models/Pregunta.php';
include_once '../Models/Respuesta.php';
include_once '../Models/Notificacion.php';
include_once '../Models/Favorito.php';

$producto_tienda = new ProductoTienda();
$resena = new Resena();
$img = new Imagen();
$tnd = new Tienda();
$caracteristica = new Caracteristica();
$pregunta = new Pregunta();
$respuesta = new Respuesta();
$notificacion = new Notificacion();
$favorito = new Favorito(); 

session_start();


if ($_POST['funcion'] == 'llenar_productos') {
    $producto_tienda->llenar_productos();
    //var_dump($producto_tienda);
    $json = array();
    foreach ($producto_tienda->objetos as $objeto){
        $resena->evaluar_calificaciones($objeto->id);
        //var_dump($producto_tienda);
        $json[]=array(
            'id'=>openssl_encrypt($objeto->id,CODE,KEY),
            'producto'=>$objeto->producto,
            'imagen'=>$objeto->imagen,
            'marca'=>$objeto->marca,
            'calificacion'=>number_format($resena->objetos[0]->promedio),
            'envio'=>$objeto->envio,
            'precio'=>$objeto->precio,
            'descuento'=>$objeto->descuento,
            'precio_descuento'=>$objeto->precio_descuento,
                     

        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
    
}

if ($_POST['funcion'] == 'verificar_producto') {
    $formateado =  str_replace(' ', '+', $_SESSION['product-verification']);
    $id_producto_tienda = openssl_decrypt($formateado,CODE,KEY);
    if(is_numeric($id_producto_tienda)){
        if(!empty($_SESSION['noti'])){
            //cambiar estado de la notificacion
            $noti_formateado =  str_replace(' ', '+', $_SESSION['noti']);
            $id_noti = openssl_decrypt($noti_formateado,CODE,KEY);
            if(is_numeric($id_noti)){
                $notificacion->update_estado_abierto($id_noti);
                unset($_SESSION['noti']);
            }
        };
        $producto_tienda->llenar_productos($id_producto_tienda);
        $id_producto = $producto_tienda->objetos[0]->id_producto;
        $producto = $producto_tienda->objetos[0]->producto;
        $sku = $producto_tienda->objetos[0]->sku;
        $detalles = $producto_tienda->objetos[0]->detalles;
        $imagen = $producto_tienda->objetos[0]->imagen;
        $marca = $producto_tienda->objetos[0]->marca;
        $envio = $producto_tienda->objetos[0]->envio;
        $precio = $producto_tienda->objetos[0]->precio;
        $descuento = $producto_tienda->objetos[0]->descuento;
        $precio_descuento = $producto_tienda->objetos[0]->precio_descuento;
        $id_tienda = $producto_tienda->objetos[0]->id_tienda;
        $direccion_tienda = $producto_tienda->objetos[0]->direccion;
        $tienda = $producto_tienda->objetos[0]->tienda;
        $id_usuario = $producto_tienda->objetos[0]->id_usuario;
        $username = $producto_tienda->objetos[0]->username;
        $avatar = $producto_tienda->objetos[0]->avatar;
        $resena->evaluar_calificaciones($id_producto_tienda);
        $calificacion = $resena->objetos[0]->promedio;
        $img->capturar_imagenes($id_producto);
        $imagenes = array();
        foreach ($img->objetos as $objeto){
            $imagenes[]=array(
                'id'=>$objeto->id,
                'nombre'=>$objeto->nombre,
            );
        }
        $tnd->contar_resenas($id_tienda);
        $numero_resenas = $tnd->objetos[0]->numero_resenas;
        $promedio_calificacion_tienda = $tnd->objetos[0]->sumatoria;
        $caracteristica->capturar_caracteristicas($id_producto);
        $caracteristicas = array();
        foreach ($caracteristica->objetos as $objeto){
            $caracteristicas[]=array(
                'id'=>$objeto->id,
                'titulo'=>$objeto->titulo,
                'descripcion'=>$objeto->descripcion,
            );
        }
        
        $resena->capturar_resenas($id_producto_tienda);
        date_default_timezone_set('America/Santiago');
        $fecha_actual = date("d-m-Y");
        $resenas = array();
        $bandera = '';
        foreach ($resena->objetos as $objeto){
            $fecha_hora = date_create($objeto->fecha_creacion);
            $hora = $fecha_hora->format('H:i:s');
            $fecha= date_format($fecha_hora, 'd-m-Y');
            if($fecha_actual==$fecha){
                $bandera = '1';

            }else{
                $bandera = '0';
            }
            $resenas[]=array(
                'id'=>$objeto->id,
                'calificacion'=>$objeto->calificacion,
                'descripcion'=>$objeto->descripcion,
                'fecha_creacion'=>$objeto->fecha_creacion,
                'fecha'=>$fecha,
                'hora'=>$hora,
                'hoy'=>$bandera,
                'usuario'=>$objeto->user,
                'avatar'=>$objeto->avatar,

            );
        }

        $id_usuario_sesion=0;
        $usuario_sesion='';
        $avatar_sesion='';  
        $bandera = '0';
        if(!empty($_SESSION['id'])){
            $id_usuario_sesion=1;
            $usuario_sesion=$_SESSION['id'];
            $avatar_sesion=$_SESSION['avatar'];
        }
        if($id_usuario_sesion==1){
            if($id_usuario==$_SESSION['id']){
                //el usuario en sesion es dueño de la tienda o producto
                //puedo responder preguntas
                //no puedo hacer preguntas
                $bandera = '1';

            }
            else{
                //el usuario en sesion no es dueño de la tienda o producto
                //puedo hacer preguntas
                //no puedo responder preguntas
                $bandera = '2';

            }
        }
        else{
            //no hay usuario en sesion
            $bandera = '0';
        }

        $pregunta->read($id_producto_tienda);
        $preguntas = array();
        foreach ($pregunta->objetos as $objeto){
            $respuesta->read($objeto->id);
            $rpst = array();
            if(!empty($respuesta)){
                foreach ($respuesta->objetos as $objeto1){
                    $rpst=array(
                        'id'=>$objeto1->id,
                        'contenido'=>$objeto1->contenido,
                        'fecha_creacion'=>$objeto1->fecha_creacion,

                    );
                }
            }
            $preguntas[]=array(
                'id'=>$objeto->id,
                'contenido'=>$objeto->contenido,
                'fecha_creacion'=>$objeto->fecha_creacion,
                'estado_respuesta'=>$objeto->estado_respuesta,
                'username'=>$objeto->username,
                'avatar'=>$objeto->avatar,
                'respuesta'=>$rpst,
                
            );
        }

            $favorito->read_favorito_usuario_protienda($usuario_sesion,$id_producto_tienda);
            $id_favorito='';
            $estado_favorito='';
            if(count($favorito->objetos)>0){
                $id_favorito= openssl_encrypt($favorito->objetos[0]->id,CODE,KEY);
                $estado_favorito=$favorito->objetos[0]->estado;

            }
            $json=array(
                'id'=>$id_producto_tienda,
                'producto'=>$producto,
                'sku'=>$sku,
                'detalles'=>$detalles,
                'imagen'=>$imagen,
                'marca'=>$marca,
                'envio'=>$envio,
                'precio'=>$precio,
                'descuento'=>$descuento,    
                'precio_descuento'=>$precio_descuento,
                'calificacion'=>number_format($calificacion),
                'direccion_tienda'=>$direccion_tienda,
                'numero_resenas'=>$numero_resenas,
                'promedio_calificacion_tienda'=>number_format($promedio_calificacion_tienda),
                'tienda'=>$tienda,
                'bandera'=>$bandera,
                'id_usuario'=>$id_usuario,
                'username'=>$username,
                'avatar'=>$avatar,
                'usuario_sesion'=>$usuario_sesion,
                'avatar_sesion'=>$avatar_sesion,
                'imagenes'=>$imagenes,
                'caracteristicas'=>$caracteristicas,
                'resenas'=>$resenas,
                'preguntas'=>$preguntas,
                'id_favorito'=>$id_favorito,
                'estado_favorito'=>$estado_favorito


                    
            );
        
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }else{
        echo 'error';
    };


    
    
}