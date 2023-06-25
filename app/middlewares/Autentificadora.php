<?php
   use Psr\Http\Message\ServerRequestInterface as Request;
   use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
   use Slim\Psr7\Response as  ResponseMW;

   require_once './models/Criptomoneda.php';
   require_once './models/Usuario.php';
   
   class Verificadora{
      private $patronNombres="/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";
      private $patronEdad='/^(1[8-9]|[2-9][0-9]|100)$/';
      private $patronEmail='/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
      private $patronDni='/^\d{8}$/';
      private $patronTexto= '/^[A-Za-z\s]+$/';
      private $patronNumeros='/^[0-9]+$/';
      private $patronFecha='/^\d{4}-\d{2}-\d{2}$/';
      private $patronFechaHora = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
      private $patronAlfaNumerico='/^[A-Za-z0-9\s]+$/';

      private $usuarioTipo=['admin','cliente'];
      public function VerificarParamCripto(Request $request, RequestHandler $handler):ResponseMW{
         if($request->getMethod()=="POST"){
            $parameters = $request->getParsedBody();
            if(
               isset($parameters["nombre"]) && preg_match($this->patronNombres,$parameters["nombre"]) &&
               isset($parameters["precio"]) && preg_match($this->patronNombres,$parameters["precio"]) &&
               isset($parameters["nacionalidad"]) && preg_match($this->patronTexto,$parameters["nacionalidad"]) &&
               isset($parameters["fotoNombre"]) && preg_match($this->patronTexto,$parameters["fotoNombre"]) &&
               isset($parameters["fotoBase64"]) && preg_match($this->patronTexto,$parameters["fotoBase64"])
               ){
                  return $handler->handle($request);
               }
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto"));
            
         }else{
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"EL verbo de la solicitud no es POST"));
         }
         $response->getBody()->write($payload);
         $response=$response->withStatus(404);
         return $response->withHeader('Content-Type', 'application/json');
      }

      public function VerificarParamUsuario(Request $request, RequestHandler $handler):ResponseMW{
         if($request->getMethod()=="POST" || $request->getMethod()=="PUT"){
            $parameters = $request->getParsedBody();
            if(
               isset($parameters["nombre"]) && preg_match($this->patronNombres,$parameters["nombre"]) &&
               isset($parameters["email"]) && preg_match($this->patronEmail,$parameters["email"]) &&
               isset($parameters["clave"]) && preg_match($this->patronTexto,$parameters["clave"]) &&
               isset($parameters["tipo"]) && in_array($parameters["tipo"],$this->usuarioTipo)
               ){
                  return $handler->handle($request);
               }
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto"));
            
         }else{
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"EL verbo de la solicitud no es POST o  PUT"));
         }
         $response->getBody()->write($payload);
         $response=$response->withStatus(404);
         return $response->withHeader('Content-Type', 'application/json');
      }

      public function VerificarParamVenta(Request $request, RequestHandler $handler):ResponseMW{
         if($request->getMethod()=="POST"){
            $parameters = $request->getParsedBody();
            if(
               isset($parameters["id_Cripto"]) && preg_match($this->patronNumeros,$parameters["id_Cripto"]) &&
               isset($parameters["id_Usuario"]) && preg_match($this->patronNumeros,$parameters["id_Usuario"]) &&
               isset($parameters["fecha"]) && preg_match($this->patronFecha,$parameters["fecha"]) &&
               isset($parameters["cantidad"]) && preg_match($this->patronNumeros,$parameters["cantidad"])
               ){
                  return $handler->handle($request);
               }
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto"));
            
         }else{
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"EL verbo de la solicitud no es POST"));
         }
         $response->getBody()->write($payload);
         $response=$response->withStatus(404);
         return $response->withHeader('Content-Type', 'application/json');
      }
      public function VerificarParamLogin(Request $request, RequestHandler $handler):ResponseMW{
         if($request->getMethod()=="POST"){
            $parameters = $request->getParsedBody();
            if(
               isset($parameters["email"]) && preg_match($this->patronEmail,$parameters["email"]) &&
               isset($parameters["clave"]) && preg_match($this->patronTexto,$parameters["clave"])
               ){
                  return $handler->handle($request);
               }
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"Faltan parametros o no cumplen el formato correcto"));
            
         }else{
            $response = new ResponseMW();
            $payload=json_encode(array("mensaje"=>"EL verbo de la solicitud no es POST"));
         }
         $response->getBody()->write($payload);
         $response=$response->withStatus(404);
         return $response->withHeader('Content-Type', 'application/json');
      }

      
   }
?>