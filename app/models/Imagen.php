<?php
    class Imagen{
        public static function Guardar($nombreArchivo,$binario){
            $nombreCarpeta="./media/FotosDeAlta";
            if(!file_exists($nombreCarpeta)){
                mkdir($nombreCarpeta, 0777, true);
            }
            $pathCompleto=$nombreCarpeta."/".$nombreArchivo;

            file_put_contents($pathCompleto, $binario);
            return $pathCompleto;
        }
        public static function MoverUbicacion($rutaArchivo,$nombreCliente,$nombreCripto,$fecha){
            $nombreCarpeta="./media/FotosCripto2023";
            if(!file_exists($nombreCarpeta)){
                mkdir($nombreCarpeta, 0777, true);
            }

            $informacionArchivo = pathinfo($rutaArchivo);
            $extension = $informacionArchivo['extension'];

            $nuevaRuta=$nombreCarpeta."/".$nombreCliente.$nombreCripto.$fecha.".".$extension;
            copy($rutaArchivo,$nuevaRuta);
            return $nuevaRuta;
        }

    }
    
?>