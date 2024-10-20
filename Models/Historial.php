<?php
    include_once 'Conexion.php';
    class Historial{
        var $objetos;
        var $acceso;

        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }

        function llenar_historial($user){
            $sql="SELECT h.id as id, descripcion, fecha, th.nombre as tipo_historial, 
                  th.icono as th_icono, m.nombre as modulo, m.icono as m_icono 
                  FROM historial h 
                  JOIN tipo_historial th ON h.id_tipo_historial=th.id 
                  JOIN modulo m ON h.id_modulo = m.id 
                  WHERE id_usuario=:user
                  ORDER BY fecha desc;";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':user'=>$user));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }

        
    }