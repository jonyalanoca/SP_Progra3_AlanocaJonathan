<?php
    require_once "./middlewares/AutentificadorJWT.php";
    require_once "./models/Usuario.php";
    class LoginController{
        public function Logearse($request, $response, $args){
            $parametros = $request->getParsedBody();
            $email = $parametros['email'];
            $clave= $parametros['clave'];
            
            $usuario=Usuario::ObtenerUsuarioPorEmail($email);
            $datos=null;
            if($usuario!=false && password_verify($clave,$usuario->clave)){
                $datos = array('email' => $email, 'rol' => $usuario->tipo);
            }
            if($datos!=null){
                $token = AutentificadorJWT::CrearToken($datos);
                $payload = json_encode(array('jwt' => $token));
            }else{
                $payload = json_encode(array("mensaje" => "No se pudo verificar "));
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>