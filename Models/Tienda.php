<?php
    include_once 'Conexion.php';
    class Tienda{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function contar_resenas($id_tienda){
            $sql="SELECT COUNT(*) as  numero_resenas,
                         AVG(calificacion)  as sumatoria
                  FROM tienda t JOIN producto_tienda pt ON t.id = pt.id_tienda
                  JOIN resena r ON pt.id = r.id_producto_tienda
                  WHERE t.id = :id_tienda
                  AND r.estado = 'A'";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_tienda'=>$id_tienda));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }

    }