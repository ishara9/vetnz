<?php

require '../vendor/autoload.php';
require_once __DIR__ . "/../app/Controllers/PatientController.php";

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$controller = new PatientController();

// Default landing page
$app->get('/', function ($request, $response) {
    $response->getBody()->write(json_encode([
        "message" => "VetNZ API is running"
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/patients', [$controller, 'getAll']);
$app->get('/api/patients/{id}', [$controller, 'getById']);
$app->post('/api/patients', [$controller, 'create']);
$app->put('/api/patients/{id}', [$controller, 'update']);
$app->patch('/api/patients/{id}', [$controller, 'update']);
$app->delete('/api/patients/{id}', [$controller, 'delete']);

$app->run();
