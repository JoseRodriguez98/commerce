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
            $sql="SELECT AVG(calificacion) as promedio
                  FROM resena
                  WHERE id_producto_tienda = :id_producto_tienda
                  AND estado = 'A'";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_producto_tienda'=>$id_producto_tienda));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
        function capturar_resenas($id_producto_tienda){
            $sql="SELECT r.id as id,
                         calificacion,
                         descripcion,
                         fecha_creacion,
                         u.user as user,
                         u.avatar as avatar
                  FROM resena r 
                  JOIN usuario u ON r.id_usuario = u.id
                  WHERE r.id_producto_tienda = :id_producto_tienda
                  AND r.estado = 'A'
                  ORDER BY r.fecha_creacion DESC"
                  ;
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_producto_tienda'=>$id_producto_tienda));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }

       

    }