<?php

    class Criptomoneda{
        public $idCripto;
        public $nombre;
        public $precio;
        public $foto;
        public $nacionalidad;
        public function  crearUno(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO criptomonedas (nombre, precio, foto, nacionalidad) VALUES (:nombre, :precio, :foto, :nacionalidad)");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
        
            $consulta->execute();
            return  $objAccesoDatos->obtenerUltimoId();
        }
        public static function obtenerUno($id){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM criptomonedas WHERE idCripto=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchObject('Criptomoneda');
        }
        public static function obtenerTodos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM criptomonedas");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Criptomoneda');
        }
        public static function modificar($criptomoneda){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE criptomonedas SET nombre=:nombre, precio=:precio, foto=:foto, nacionalidad=:nacionalidad WHERE idCripto = :id");
            $consulta->bindValue(':nombre', $criptomoneda->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $criptomoneda->precio, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $criptomoneda->foto, PDO::PARAM_STR);
            $consulta->bindValue(':nacionalidad', $criptomoneda->nacionalidad, PDO::PARAM_STR);
            $consulta->bindValue(":id",$criptomoneda->idCripto,PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function eliminarUno($id){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM criptomonedas WHERE idCripto=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
        }

        public static function obtenerTodosNacionalidad($id){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM criptomonedas WHERE nacionalidad=:nacionalidad");
            $consulta->bindValue(':nacionalidad', $id, PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchObject('Criptomoneda');
        }

    }
    

?>