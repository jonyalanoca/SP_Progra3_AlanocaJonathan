<?php
    require_once './models/Venta.php';
    require_once './models/Imagen.php';
    require_once './models/Criptomoneda.php';
    require_once './models/Usuario.php';
    require_once './interfaces/IApiUsable.php';


    class VentaController extends Venta implements IApiUsable
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();

            $criptomoneda=Criptomoneda::obtenerUno($parametros["id_Cripto"]);
            $usuario=Usuario::obtenerUno($parametros["id_Usuario"]);
            if($criptomoneda!=false && $usuario!=false){
                $nuevo = new Venta();
                $nuevo->id_Cripto=$parametros["id_Cripto"];
                $nuevo->id_Usuario=$parametros["id_Usuario"];
                $nuevo->fecha=$parametros["fecha"];
                $nuevo->cantidad=$parametros["cantidad"];
                $nuevo->imagen=Imagen::MoverUbicacion($criptomoneda->foto,$usuario->nombre,$criptomoneda->nombre,$parametros["fecha"]);
                $nuevo->crearUno();

                $payload = json_encode(array("mensaje" => "Venta creada con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "No se pudo verificar la existencia de los ids. No se aplicaron cambios"));
            }
            
    
            
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        public function TraerUno($request, $response, $args)
        {
            $id = $args['id'];
            $nuevo = Venta::obtenerUno($id);

            $payload = json_encode($nuevo);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerTodos($request, $response, $args)
        {
            $lista = Venta::obtenerTodos();

            $payload = json_encode(array("ListaVentas" => $lista));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function ModificarUno($request, $response, $args)
        {
            $id = $args['id'];
            $parametros = $request->getParsedBody();
            
            $criptomoneda=Criptomoneda::obtenerUno($parametros["id_Cripto"]);
            $usuario=Usuario::obtenerUno($parametros["id_Usuario"]);

            $nuevo= new Venta();
            $nuevo->idVenta=$id;
            $nuevo->id_Cripto=$parametros["id_Cripto"];
            $nuevo->id_Usuario=$parametros["id_Usuario"];
            $nuevo->fecha=$parametros["fecha"];
            $nuevo->cantidad=$parametros["cantidad"];
            $nuevo->imagen=Imagen::MoverUbicacion($criptomoneda->foto,$usuario->nombre,$criptomoneda->nombre,$parametros["fecha"]);
            Venta::modificar($nuevo);

            $payload = json_encode(array("mensaje" => "Venta modificada con exito"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args)
        {
            $id = $args['id'];
            Venta::eliminarUno($id);

            $payload = json_encode(array("mensaje" => "Venta borrada con exito"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerAlemanas($request, $response, $args)
        {
            // $lista = Venta::obtenerTodos();

            // $listaFiltrada=array_filter($lista,function($elemento){
            //     $criptomoneda=Criptomoneda::obtenerUno($elemento->id_Cripto);
            //     return strtolower($criptomoneda->nacionalidad)=="alemania" &&
            //      strtotime($elemento->fecha)>strtotime("2023-06-10") &&
            //      strtotime($elemento->fecha)<strtotime("2023-06-13");
            // });
            $lista=Venta::obtenerAlemanas();
            
            $payload = json_encode(array("ListaVentas" => $lista));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>