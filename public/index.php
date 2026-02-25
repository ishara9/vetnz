<?php

require __DIR__ . '/../vendor/autoload.php';
// require_once __DIR__ . "/../app/Controllers/PatientController.php";

use DI\Container;
use Slim\Factory\AppFactory;

use VetApp\Controllers\PatientController;
use VetApp\Services\PatientService;
use VetApp\Repositories\PatientRepository;
use VetApp\Config\Database;

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$container->set(Database::class, function () {
    return new Database();
});

$container->set(PatientRepository::class, function ($c) {
    return new PatientRepository($c->get(Database::class));
});

$container->set(PatientService::class, function ($c) {
    return new PatientService(
        $c->get(PatientRepository::class)
    );
});

$container->set(PatientController::class,function ($c){
    return new PatientController($c->get(PatientService::class));
});




// $app->addBodyParsingMiddleware();

// $controller = new PatientController();

// Default landing page
$app->get('/', function ($request, $response) {
    $response->getBody()->write(json_encode([
        "message" => "VetNZ API is running"
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/patients', [PatientController::class, 'getAll']);
$app->get('/api/patients/{id}', [PatientController::class, 'getById']);
$app->post('/api/patients', [PatientController::class, 'create']);
$app->put('/api/patients/{id}', [PatientController::class, 'update']);
$app->patch('/api/patients/{id}', [PatientController::class, 'update']);
$app->delete('/api/patients/{id}', [PatientController::class, 'delete']);

$app->run();
