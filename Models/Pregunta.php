
    <?php
    include_once 'Conexion.php';
    class Pregunta{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function read($id_producto_tienda){
            $sql = "SELECT  p.id as id,
                            contenido,
                            p.fecha_creacion as fecha_creacion,
                            p.respuesta as estado_respuesta,
                            us.id as id_usuario,
                            us.user as username,
                            us.avatar as avatar
                    FROM pregunta p
                    JOIN producto_tienda pt ON p.id_producto_tienda = pt.id
                    JOIN usuario us ON p.id_usuario = us.id
                    WHERE pt.id = :id_producto_tienda
                    AND  p.estado = 'A' ORDER BY p.fecha_creacion DESC";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id_producto_tienda'=>$id_producto_tienda));
                $this->objetos = $query->fetchall();
                return $this->objetos;

        }
        function create($pgt, $id_producto_tienda, $id_usuario){
            $sql="INSERT INTO pregunta(contenido, id_producto_tienda, id_usuario)
                  VALUES(:pgt,:id_producto_tienda,:id_usuario) ";
            $query = $this->acceso->prepare($sql);
            $variables=array(
                ':pgt'=>$pgt,
                ':id_producto_tienda'=>$id_producto_tienda,
                ':id_usuario'=>$id_usuario
            );
            $query->execute($variables);
        }

       


    }