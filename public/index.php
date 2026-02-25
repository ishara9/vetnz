<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use VetApp\Controllers\PatientController;

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

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
