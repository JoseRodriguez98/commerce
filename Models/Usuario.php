<?php
    include_once 'Conexion.php';
    class Usuario{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function loguearse($user,$pass){
            $sql="SELECT * FROM usuario
                  JOIN tipo_usuario ON id_tipo = tipo_usuario.id
                  WHERE user = :user AND pass = :pass";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':user'=>$user,':pass'=>$pass));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    }