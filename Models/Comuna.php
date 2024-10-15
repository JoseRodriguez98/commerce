<?php
    include_once 'Conexion.php';
    class Comuna{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function llenar_comunas($provincia_id){
            $sql="SELECT * FROM comunas
                WHERE provincia_id = :idn";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':idn'=>$provincia_id));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    


    }