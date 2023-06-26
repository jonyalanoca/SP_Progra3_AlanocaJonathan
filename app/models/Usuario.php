<?php
    class Usuario{
        public $idUsuario;
        public $nombre;
        public $email;
        public $clave;
        public $tipo;
        public function  crearUno(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (nombre,email, clave, tipo) VALUES (:nombre, :email, :clave, :tipo)");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        
            $consulta->execute();
            return  $objAccesoDatos->obtenerUltimoId();
        }
        public static function obtenerUno($id){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE idUsuario=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchObject('Usuario');
        }
        public static function obtenerTodos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
        }
        public static function modificar($usuario){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET nombre=:nombre, email=:email, clave=:clave, tipo=:tipo WHERE idUsuario = :id");
            $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $usuario->tipo, PDO::PARAM_STR);
            $consulta->bindValue(":id",$usuario->idUsuario,PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function eliminarUno($id){
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM usuarios WHERE idUsuario=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
        }
        public static function ObtenerIds(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idUsuario FROM usuarios");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_COLUMN, 0);
        }
        public static function ObtenerUsuarioPorEmail($email){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE email=:email");
            $consulta->bindValue(':email', $email, PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchObject('Usuario');
        }
        public static function ObtenerUsuariosCompraCripto($cripto){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT usuarios.idUsuario, usuarios.nombre, usuarios.tipo, usuarios.email, usuarios.clave
            FROM ventas
            INNER JOIN criptomonedas ON ventas.id_Cripto = criptomonedas.idCripto
            INNER JOIN usuarios on ventas.id_Usuario=usuarios.idUsuario
            WHERE criptomonedas.nombre=:cripto");
            $consulta->bindValue(':cripto', $cripto, PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
        }

    }
    

?>