<?php
include_once '../Models/ProductoTienda.php';
include_once '../Util/Config/config.php';
include_once '../Models/Favorito.php';
include_once '../Models/Historial.php';
$producto_tienda = new ProductoTienda();
$favorito = new Favorito();
$historial = new Historial();
session_start();


if ($_POST['funcion'] == 'cambiar_estado_favorito') {
    $id_favorito_encrypted = $_POST['id_favorito'];
    $formateado =  str_replace(' ', '+', $id_favorito_encrypted);
    $id_favorito = openssl_decrypt($formateado,CODE,KEY);
    $formateado =  str_replace(' ', '+', $_SESSION['product-verification']);
    $id_producto_tienda = openssl_decrypt($formateado,CODE,KEY);
    $estado_favorito = $_POST['estado_favorito'];
    $id_usuario = $_SESSION['id'];
    $mensaje='';
    if( $id_favorito_encrypted!=""){
        if(is_numeric($id_favorito)){
            if(is_numeric($id_producto_tienda)){
                $producto_tienda->llenar_productos($id_producto_tienda);
                $titulo = $producto_tienda->objetos[0]->producto;
                $url = 'Views/descripcion.php?name='.$titulo.'&&id='.$formateado;
                $favorito->read_favorito_usuario_protienda($id_usuario ,$id_producto_tienda);
                $estado_favorito=$favorito->objetos[0]->estado;
                if($estado_favorito=='A'){
                    // remover de favoritos actualizar el estado de A a I
                    $favorito->update_remove($id_favorito);
                    $descripcion = 'Se removió de favoritos el producto: '.$titulo;
                    $historial->crear_historial($descripcion,3,6,$id_usuario);
                    $mensaje = 'remove';
                }
                else{
                    // actualizar el estado de I a A favorito
                    $favorito->update_add($id_usuario,$id_producto_tienda, $id_favorito, $url);
                    $descripcion = 'Se agregó a favoritos el producto: '.$titulo;
                    $historial->crear_historial($descripcion,2,6,$id_usuario);
                    $mensaje = 'add';
                }
            }
            else{
                //error al eliminar
                $mensaje = 'error al eliminar';
            }

        }
        else{
            //error al eliminar
            $mensaje = 'error al eliminar';
        }


    }
    else{
        //creamos nuevo registro
        //verificar que usuario no borre id_favorito para hacer que se cree un nuevo registro
        //volver a consultar con el id_usuario y el id_producto_tienda para verificar si es que existe un registro
        if(is_numeric($id_producto_tienda)){
            $favorito->read_favorito_usuario_protienda($id_usuario ,$id_producto_tienda);
            $id_favorito='';
            $estado_favorito='';
            if(count($favorito->objetos)>0){
                $id_favorito= $favorito->objetos[0]->id;
                $estado_favorito=$favorito->objetos[0]->estado;
            }
            $producto_tienda->llenar_productos($id_producto_tienda);
            $titulo = $producto_tienda->objetos[0]->producto;
            $url = 'Views/descripcion.php?name='.$titulo.'&&id='.$formateado;
            if($estado_favorito=='A'){
                // remover de favoritos actualizar el estado de A a I
                $favorito->update_remove($id_favorito);
                $descripcion = 'Se removió de favoritos el producto: '.$titulo;
                $historial->crear_historial($descripcion,3,6,$id_usuario);
                $mensaje = 'remove';
            }
            else{
                // actualizar el estado de I a A favorito
                $favorito->update_add($id_usuario,$id_producto_tienda, $id_favorito, $url);
                $descripcion = 'Se agregó a favoritos el producto: '.$titulo;
                $historial->crear_historial($descripcion,2,6,$id_usuario);
                $mensaje = 'add';
            }
        }
        else{
            //error al eliminar
            $mensaje = 'error al eliminar';
        }
    }

    $json = array(
        'mensaje' => $mensaje
    );
    $jsonstring = json_encode($json);
    echo $jsonstring;
    
}

if ($_POST['funcion'] == 'read_favoritos') {
  if(!empty($_SESSION['id'])){
    $id_usuario = $_SESSION['id'];
    $favorito->read($id_usuario);
    $json = array();
    foreach ($favorito->objetos as $objeto) {
        $json[] = array(
            'id' => openssl_encrypt($objeto->id, CODE, KEY),
            'titulo' => $objeto->titulo,
            'precio' => $objeto->precio,
            'imagen' => $objeto->imagen,
            'url' => $objeto->url,
            'fecha_creacion' => $objeto->fecha_creacion,

        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
  }
  else{
    echo 'error, usuario no está en sesion';
  }

}

if ($_POST['funcion'] == 'read_all_favoritos') {
    if(!empty($_SESSION['id'])){
      $id_usuario = $_SESSION['id'];
      $favorito->read_all_favoritos($id_usuario);
      $json = array();
      foreach ($favorito->objetos as $objeto) {
          $json[] = array(
              'id' => openssl_encrypt($objeto->id, CODE, KEY),
              'titulo' => $objeto->titulo,
              'precio' => $objeto->precio,
              'imagen' => $objeto->imagen,
              'url' => $objeto->url,
              'fecha_creacion' => $objeto->fecha_creacion,
  
          );
      }
      $jsonstring = json_encode($json);
      echo $jsonstring;
    }
    else{
      echo 'error, usuario no está en sesion';
    }
  
  }

  if ($_POST['funcion'] == 'eliminar_favorito') {
    if(!empty($_SESSION['id'])){
        $id_usuario = $_SESSION['id'];
        $id_favorito_encrypted = $_POST['id_favorito'];
        $formateado =  str_replace(' ', '+', $id_favorito_encrypted);
        $id_favorito = openssl_decrypt($formateado,CODE,KEY);
        $formateado =  str_replace(' ', '+', $_SESSION['product-verification']);
        $id_producto_tienda = openssl_decrypt($formateado,CODE,KEY);
        $mensaje='';
        if(is_numeric($id_favorito)){
            $favorito->update_remove($id_favorito);
            $producto_tienda->llenar_productos($id_producto_tienda);
            $titulo = $producto_tienda->objetos[0]->producto;
            $descripcion = 'Se removió de favoritos el producto: '.$titulo;
            $historial->crear_historial($descripcion,3,6,$id_usuario);
            $mensaje = 'favorito eliminado';
        }
        else{
            $mensaje = 'error al eliminar';
        }
        $json = array(
            'mensaje' => $mensaje
        );
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    else{
      echo 'error, usuario no está en sesion';
    }
  
  }