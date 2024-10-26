<?php
    include_once 'Conexion.php';
    class Caracteristica{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function capturar_caracteristicas($id_producto){
            $sql="SELECT *
                  FROM caracteristicas c
                  WHERE c.id_producto = :id_producto
                  AND c.estado = 'A'"
                  ;
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_producto'=>$id_producto));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }

    }