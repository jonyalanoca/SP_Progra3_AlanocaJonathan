<?php
    require_once './models/Criptomoneda.php';
    require_once './models/Imagen.php';
    require_once './interfaces/IApiUsable.php';

    class CriptomonedaController extends Criptomoneda implements IApiUsable
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $fotoNombre=$parametros["fotoNombre"];
            $fotoBinaria=base64_decode($parametros["fotoBase64"]);
            $rutaArchivo=Imagen::Guardar($fotoNombre,$fotoBinaria);
            if(file_exists($rutaArchivo)){
                $nuevo = new Criptomoneda();
                $nuevo->nombre=$parametros["nombre"];
                $nuevo->precio=$parametros["precio"];
                $nuevo->foto=$rutaArchivo;
                $nuevo->nacionalidad=$parametros["nacionalidad"];
                $nuevo->crearUno();
                $payload = json_encode(array("mensaje" => "Criptomoneda creada con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "La imagen no se pudo guardar. No se hicieron cambios"));
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        public function TraerUno($request, $response, $args)
        {
            $id = $args['id'];
            $nuevo = Criptomoneda::obtenerUno($id);

            $payload = json_encode($nuevo);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerPorNacionalidad($request, $response, $args)
        {
            $nacionalidad = $args['nacionalidad'];
            $nuevo = Criptomoneda::obtenerTodosNacionalidad($nacionalidad);

            $payload = json_encode($nuevo);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerTodos($request, $response, $args)
        {
            $lista = Criptomoneda::obtenerTodos();

            $payload = json_encode(array("ListaCriptomonedas" => $lista));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function ModificarUno($request, $response, $args)
        {
            $id = $args['id'];
            $parametros = $request->getParsedBody();

            $fotoNombre=$parametros["fotoNombre"];
            $fotoBinaria=base64_decode($parametros["fotoBase64"]);
            $rutaArchivo=Imagen::Guardar($fotoNombre,$fotoBinaria);

            if(file_exists($rutaArchivo)){
                $nuevo = new Criptomoneda();
                $nuevo->idCripto=$id;
                $nuevo->nombre=$parametros["nombre"];
                $nuevo->precio=$parametros["precio"];
                $nuevo->foto=$rutaArchivo;
                $nuevo->nacionalidad=$parametros["nacionalidad"];
                Criptomoneda::modificar($nuevo);
                $payload = json_encode(array("mensaje" => "Criptomoneda modificada con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "La imagen no se pudo guardar. No se hicieron cambios"));
            }
            $payload = json_encode(array("mensaje" => "Criptomoneda modificada con exito"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args)
        {
            $id = $args['id'];
            Criptomoneda::eliminarUno($id);

            $payload = json_encode(array("mensaje" => "Criptomoneda borrada con exito"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>