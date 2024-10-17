<?php
    include_once 'Conexion.php';
    class UsuarioComuna{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function crear_direccion($id_usuario,$comuna_id,$direccion,$referencia){
            $sql="INSERT INTO usuario_comuna(direccion,referencia,id_comuna,id_usuario)
                  VALUES(:direccion,:referencia,:id_comuna,:id_usuario)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':direccion'=>$direccion,':referencia'=>$referencia,':id_comuna'=>$comuna_id,':id_usuario'=>$id_usuario));
        }
        
        function llenar_direcciones($id_usuario){
            $sql="SELECT * FROM usuario_comuna";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }


    }