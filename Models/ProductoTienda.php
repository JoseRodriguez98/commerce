<?php
    include_once 'Conexion.php';
    class ProductoTienda{
        var $objetos;
        var $acceso;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function llenar_productos($id=null){
            if($id){
                $sql="SELECT pt.id as id,
                        p.id as id_producto,
                        p.nombre as producto,
                        p.sku as sku,
                        p.imagen_principal as imagen,
                        p.detalles as detalles,
                        m.nombre as marca,
                        pt.estado_envio as envio,
                        pt.precio as precio,
                        pt.descuento as descuento,
                        ROUND(pt.precio - (pt.precio * (pt.descuento / 100))) as precio_descuento,
                        t.id as id_tienda,
                        t.nombre as tienda,
                        t.direccion as direccion
                    FROM producto_tienda pt
                    JOIN producto p ON pt.id_producto = p.id
                    JOIN marca m ON p.id_marca = m.id
                    JOIN tienda t ON pt.id_tienda = t.id
                    AND pt.estado = 'A' AND pt.id = :id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id));
                $this->objetos = $query->fetchall();
                return $this->objetos;

            }else{

                $sql="SELECT pt.id as id,
                            p.id as id_producto,
                            p.nombre as producto,
                            p.sku as sku,
                            p.imagen_principal as imagen,
                            p.detalles as detalles,
                            m.nombre as marca,
                            pt.estado_envio as envio,
                            pt.precio as precio,
                            pt.descuento as descuento,
                            ROUND(pt.precio - (pt.precio * (pt.descuento / 100))) as precio_descuento,
                            t.id as id_tienda,
                            t.nombre as tienda,
                            t.direccion as direccion
                    FROM producto_tienda pt
                    JOIN producto p ON pt.id_producto = p.id
                    JOIN marca m ON p.id_marca = m.id
                    JOIN tienda t ON pt.id_tienda = t.id
                    AND pt.estado = 'A' ";
                $query = $this->acceso->prepare($sql);
                $query->execute();
                $this->objetos = $query->fetchall();
                return $this->objetos;
            
            }

        }

       
    

       

        

        function capturar_resenas($id_producto_tienda){
            $sql="SELECT r.id as id,
                         calificacion,
                         descripcion,
                         fecha_creacion,
                         u.user as user,
                         u.avatar as avatar
                  FROM resena r JOIN usuario u ON r.id_usuario = u.id
                  WHERE r.id_producto_tienda = :id_producto_tienda
                  AND r.estado = 'A'
                  ORDER BY r.fecha_creacion DESC"
                  ;
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_producto_tienda'=>$id_producto_tienda));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }

    }