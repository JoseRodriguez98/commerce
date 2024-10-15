<?php
    include_once 'Conexion.php';
    class Provincia{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function llenar_provincias($region_id){
            $sql="SELECT * FROM provincias
                WHERE region_id = :idx";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':idx'=>$region_id));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    


    }