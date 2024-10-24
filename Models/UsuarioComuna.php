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
            $sql="SELECT uc.id as id, direccion, referencia , c.comuna as comuna , p.provincia as provincia , r.region as region
                FROM usuario_comuna uc
                JOIN comunas c ON c.id = uc.id_comuna
                JOIN provincias p ON p.id = c.provincia_id
                JOIN regiones r ON r.id = p.region_id
                WHERE uc.id_usuario =:id AND estado = 'A' ";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_usuario));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }

        function eliminar_direccion($id_direccion){
            $sql="UPDATE usuario_comuna SET estado = 'I' WHERE id =:id_direccion";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_direccion'=>$id_direccion));
        }
        
        function recuperar_direccion($id_direccion){
            $sql="SELECT uc.id as id, direccion, referencia , c.comuna as comuna , p.provincia as provincia , r.region as region
                FROM usuario_comuna uc
                JOIN comunas c ON c.id = uc.id_comuna
                JOIN provincias p ON p.id = c.provincia_id
                JOIN regiones r ON r.id = p.region_id
                WHERE uc.id =:id AND estado = 'A' ";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_direccion));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }


    }