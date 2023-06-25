<?php
    
    class Venta{
        public $idVenta;
        public $id_Cripto;
        public $id_Usuario;
        public $fecha;
        public $cantidad;
        public $imagen;
        public function  crearUno(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ventas (id_Cripto, id_Usuario, fecha, cantidad, imagen) VALUES (:id_Cripto, :id_Usuario, :fecha, :cantidad, :imagen)");
            $consulta->bindValue(':id_Cripto', $this->id_Cripto, PDO::PARAM_INT);
            $consulta->bindValue(':id_Usuario', $this->id_Usuario, PDO::PARAM_INT);
            $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
            $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
            $consulta->bindValue(':imagen', $this->imagen, PDO::PARAM_STR);
        
            $consulta->execute();
            return  $objAccesoDatos->obtenerUltimoId();
        }
        public static function obtenerUno($id){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventas WHERE idVenta=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchObject('Venta');
        }
        public static function obtenerTodos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventas");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
        }
        public static function modificar($venta){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE ventas SET id_Cripto=:id_Cripto, id_Usuario=:id_Usuario, fecha=:fecha, cantidad=:cantidad, imagen=:imagen WHERE idVenta = :id");
            $consulta->bindValue(':id_Cripto', $venta->id_Cripto, PDO::PARAM_INT);
            $consulta->bindValue(':id_Usuario', $venta->id_Usuario, PDO::PARAM_INT);
            $consulta->bindValue(':fecha', $venta->fecha, PDO::PARAM_STR);
            $consulta->bindValue(':cantidad', $venta->cantidad, PDO::PARAM_INT);
            $consulta->bindValue(':imagen', $venta->imagen, PDO::PARAM_STR);
            $consulta->bindValue(':id', $venta->idVenta, PDO::PARAM_INT);

            $consulta->execute();
        }
        public static function eliminarUno($id){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM ventas WHERE idVenta=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
        }

    }
    

?>