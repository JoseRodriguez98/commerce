<?php
include_once '../Models/ProductoTienda.php';
$producto_tienda = new ProductoTienda();
session_start();


if ($_POST['funcion'] == 'llenar_productos') {
    $producto_tienda->llenar_productos();
    //var_dump($producto_tienda);
    $json = array();
    foreach ($producto_tienda->objetos as $objeto){
        $producto_tienda->evaluar_calificaciones($objeto->id);
        //var_dump($producto_tienda);
        $json[]=array(
            'id'=>$objeto->id,
            'producto'=>$objeto->producto,
            'imagen'=>$objeto->imagen,
            'marca'=>$objeto->marca,
            'calificacion'=>number_format($producto_tienda->objetos[0]->promedio),
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
    $id_producto_tienda = $_SESSION['product-verification'];
   
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
    $producto_tienda->evaluar_calificaciones($id_producto_tienda);
    $calificacion = $producto_tienda->objetos[0]->promedio;
    $producto_tienda->capturar_imagenes($id_producto);
    $imagenes = array();
    foreach ($producto_tienda->objetos as $objeto){
        $imagenes[]=array(
            'id'=>$objeto->id,
            'nombre'=>$objeto->nombre,
        );
    }
    $producto_tienda->contar_resenas($id_tienda);
    $numero_resenas = $producto_tienda->objetos[0]->numero_resenas;
    $promedio_calificacion_tienda = $producto_tienda->objetos[0]->sumatoria;
    $producto_tienda->capturar_caracteristicas($id_producto);
    $caracteristicas = array();
    foreach ($producto_tienda->objetos as $objeto){
        $caracteristicas[]=array(
            'id'=>$objeto->id,
            'titulo'=>$objeto->titulo,
            'descripcion'=>$objeto->descripcion,
        );
    }
    
    $producto_tienda->capturar_resenas($id_producto_tienda);
    date_default_timezone_set('America/Santiago');
    $fecha_actual = date("d-m-Y");
    $resenas = array();
    $bandera = '';
    foreach ($producto_tienda->objetos as $objeto){
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
            'imagenes'=>$imagenes,
            'caracteristicas'=>$caracteristicas,
            'resenas'=>$resenas,


                     

        );
    
    $jsonstring = json_encode($json);
    echo $jsonstring;
    
}