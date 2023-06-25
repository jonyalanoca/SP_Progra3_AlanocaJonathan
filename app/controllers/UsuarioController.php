<?php
    require_once './models/Usuario.php';
    require_once './interfaces/IApiUsable.php';

    class UsuarioController extends Usuario implements IApiUsable
    {
        public function CargarUno($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            $usuario=Usuario::ObtenerUsuarioPorEmail($parametros["email"]);
            if($usuario==false){
                $nuevo = new Usuario();
                $nuevo->nombre=$parametros["nombre"];
                $nuevo->email=$parametros["email"];
                $nuevo->clave=password_hash($parametros["clave"],PASSWORD_DEFAULT);
                $nuevo->tipo=$parametros["tipo"];
                $nuevo->crearUno();
        
                $payload = json_encode(array("mensaje" => "Usuario creado con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "El email ya esta registrado. No se aplicaron cambios."));
            }
            
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        public function TraerUno($request, $response, $args)
        {
            $id = $args['id'];
            $nuevo = Usuario::obtenerUno($id);

            $payload = json_encode($nuevo);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function TraerTodos($request, $response, $args)
        {
            $lista = Usuario::obtenerTodos();

            $payload = json_encode(array("ListaUsuarios" => $lista));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function ModificarUno($request, $response, $args)
        {
            $id = $args['id'];
            $parametros = $request->getParsedBody();

            $usuario=Usuario::ObtenerUsuarioPorEmail($parametros["email"]);
            if($usuario==false){
                $nuevo= new Usuario();
                $nuevo->idUsuario=$id;
                $nuevo->nombre=$parametros["nombre"];
                $nuevo->email=$parametros["email"];
                $nuevo->clave=password_hash($parametros["clave"],PASSWORD_DEFAULT);
                $nuevo->tipo=$parametros["tipo"];
                Usuario::modificar($nuevo);

                $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));
            }else{
                $payload = json_encode(array("mensaje" => "El email ya esta registrado. No se aplicaron cambios."));
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function BorrarUno($request, $response, $args)
        {
            $id = $args['id'];
            Usuario::eliminarUno($id);

            $payload = json_encode(array("mensaje" => "Usiario borrado con exito"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>