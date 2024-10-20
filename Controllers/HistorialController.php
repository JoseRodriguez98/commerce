<?php
include_once '../Models/Historial.php';

$historial = new Historial();
session_start();

if ($_POST['funcion'] == 'llenar_historial') {
    $id_usuario = $_SESSION['id'];
    $historial->llenar_historial($id_usuario);
    $bandera = '';
    $cont = 0;
    $fechas = array();
    foreach($historial->objetos as $objeto){
        $fecha_hora = date_create($objeto->fecha);
        $hora = $fecha_hora->format('H:i:s');
        $fecha = date_format($fecha_hora, 'd-m-Y');
        if($fecha!=$bandera){
            $cont++;
            $bandera = $fecha;
        }
        //vamos a forzar que solo sean las 3 ultimas fechas
        if($cont==3){
            $fechas[$cont-1][]=array(
                'id'=>$objeto->id,
                'descripcion'=>$objeto->descripcion,
                'fecha'=>$fecha,
                'hora'=>$hora,
                'tipo_historial'=>$objeto->tipo_historial,
                'th_icono'=>$objeto->th_icono,
                'modulo'=>$objeto->modulo,
                'm_icono'=>$objeto->m_icono

            );
        }
        else{
            //aqui se sale del ciclo
            if($cont==4){
                break;
            }else{
                $fechas[$cont-1][]=array(
                    'id'=>$objeto->id,
                    'descripcion'=>$objeto->descripcion,
                    'fecha'=>$fecha,
                    'hora'=>$hora,
                    'tipo_historial'=>$objeto->tipo_historial,
                    'th_icono'=>$objeto->th_icono,
                    'modulo'=>$objeto->modulo,
                    'm_icono'=>$objeto->m_icono

                );
            }
        }
    }
    $jsonstring = json_encode($fechas);
    echo $jsonstring;
}

