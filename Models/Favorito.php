<?php
    include_once 'Conexion.php';
    class Favorito{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function read_favorito_usuario_protienda($usuario_sesion,$id_producto_tienda){
            $sql="SELECT *
                  FROM favorito
                  WHERE id_usuario=:id_usuario
                  AND id_producto_tienda=:id_producto_tienda";
            $query = $this->acceso->prepare($sql);
            $variables = array(
                ':id_usuario'=>$usuario_sesion,
                ':id_producto_tienda'=>$id_producto_tienda
            );
            $query->execute($variables);
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    


    }