<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';

//Controllers
require_once './controllers/CriptomonedaController.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/VentaController.php';
require_once './controllers/LoginController.php';
//Middlewares
require_once './middlewares/Autentificadora.php';
require_once './middlewares/AutentificadoraLogin.php';
// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();
$app->setBasePath('/cripto2/app');

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->post('/login',\LoginController::class . ':Logearse')->add(\Verificadora::class . ':VerificarParamLogin');

$app->group('/criptomonedas', function (RouteCollectorProxy $group) {
  $group->post('/', \CriptomonedaController::class . ':CargarUno')
    ->add(\AutentificadoraLogin::class . ':VerificarAdmin')->add(\AutentificadoraLogin::class . ':VerificarLogeo')
    ->add(\Verificadora::class . ':VerificarParamCripto');
  $group->get('/{id}', \CriptomonedaController::class . ':TraerUno')
    ->add(\AutentificadoraLogin::class . ':VerificarAdminCliente')->add(\AutentificadoraLogin::class . ':VerificarLogeo');
  $group->get('[/]', \CriptomonedaController::class . ':TraerTodos');//sin verificacion
  $group->get('/nacionalidad/{nacionalidad}', \CriptomonedaController::class . ':TraerPorNacionalidad');//sin verificacion
  $group->put('/{id}', \CriptomonedaController::class . ':ModificarUno');
  $group->delete('/{id}', \CriptomonedaController::class . ':BorrarUno');
});

$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->post('/', \UsuarioController::class . ':CargarUno')->add(\Verificadora::class . ':VerificarParamUsuario');
  $group->get('/{id}', \UsuarioController::class . ':TraerUno');
  $group->get('[/]', \UsuarioController::class . ':TraerTodos');
  $group->put('/{id}', \UsuarioController::class . ':ModificarUno')->add(\Verificadora::class . ':VerificarParamUsuario');
  $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
});
// ->add(\AutentificadoraLogin::class . ':VerificarAdmin')
//   ->add(\AutentificadoraLogin::class . ':VerificarLogeo');

$app->group('/ventas', function (RouteCollectorProxy $group) {
  $group->post('/', \VentaController::class . ':CargarUno')
    ->add(\AutentificadoraLogin::class . ':VerificarAdminCliente')->add(\AutentificadoraLogin::class . ':VerificarLogeo')
    ->add(\Verificadora::class . ':VerificarParamVenta');
  $group->get('/{id}', \VentaController::class . ':TraerUno');
  $group->get('[/]', \VentaController::class . ':TraerTodos');
  $group->put('/{id}', \VentaController::class . ':ModificarUno');
  $group->delete('/{id}', \VentaController::class . ':BorrarUno');
})->add(\AutentificadoraLogin::class . ':VerificarLogeo');



$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Segundo Parcial - Programacion3"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
