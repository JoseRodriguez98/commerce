<?php
    include_once 'Conexion.php';
    class Resena{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function evaluar_calificaciones($id_producto_tienda){
            $sql="SELECT ROUND(AVG(r.calificacion)) as promedio
                  FROM resena r
                  WHERE r.id_producto_tienda = :id_producto_tienda
                  AND r.estado = 'A'";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_producto_tienda'=>$id_producto_tienda));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }


    }