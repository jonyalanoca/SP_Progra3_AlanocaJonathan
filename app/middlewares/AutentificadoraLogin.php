<?php
    require_once "./middlewares/AutentificadorJWT.php";

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Response as  ResponseMW;
    
    class AutentificadoraLogin{

        public function VerificarLogeo(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            if(!empty($header)){
                return $handler->handle($request);
            }
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Porfavor logese antes de continuar"));
            $response->getBody()->write($payload);
            $response=$response->withStatus(404);
            return $response->withHeader('Content-Type', 'application/json');
        }
        
        public function VerificarAdmin(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $datos=AutentificadorJWT::ObtenerData($token);
            if($datos->rol=="admin"){
                return $handler->handle($request);
            } 
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"No se tiene tiene autorización. Solo admin"));
           $response->getBody()->write($payload);
           $response=$response->withStatus(404);
           return $response->withHeader('Content-Type', 'application/json');
        }
        public function VerificarCliente(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $datos=AutentificadorJWT::ObtenerData($token);
            if($datos->rol=="cliente"){
                return $handler->handle($request);
            } 
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"No se tiene tiene autorización. Solo cliente"));
           $response->getBody()->write($payload);
           $response=$response->withStatus(404);
           return $response->withHeader('Content-Type', 'application/json');
        }
        public function VerificarAdminCliente(Request $request, RequestHandler $handler):ResponseMW{
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $datos=AutentificadorJWT::ObtenerData($token);
            if($datos->rol=="cliente" || $datos->rol=="admin"){
                return $handler->handle($request);
            } 
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"No se tiene tiene autorización. Solo usarios registrados"));
           $response->getBody()->write($payload);
           $response=$response->withStatus(404);
           return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>