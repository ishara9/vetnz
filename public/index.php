<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use VetApp\Controllers\PatientController;
use VetApp\Controllers\MedicalRecordController;
use VetApp\Handler\HttpExceptionHandler;

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Default landing page
$app->get('/', function ($request, $response) {
    $response->getBody()->write(json_encode([
        "message" => "VetNZ API is running"
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

// error handling middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = new HttpExceptionHandler($app->getResponseFactory());
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Patient routes
$app->get('/api/patients', [PatientController::class, 'getAll']);
$app->get('/api/patients/{id}', [PatientController::class, 'getById']);
$app->post('/api/patients', [PatientController::class, 'create']);
$app->put('/api/patients/{id}', [PatientController::class, 'update']);
$app->patch('/api/patients/{id}', [PatientController::class, 'patch']);
$app->delete('/api/patients/{id}', [PatientController::class, 'delete']);

$app->get('/api/patients/{id}/medical-records', [PatientController::class, 'getMedicalRecords']);

// Medical Record routes
$app->get('/api/medical-records', [MedicalRecordController::class, 'getAll']);
$app->get('/api/medical-records/{id}', [MedicalRecordController::class, 'getById']);
$app->post('/api/medical-records', [MedicalRecordController::class, 'create']);
$app->put('/api/medical-records/{id}', [MedicalRecordController::class,
    'update'
]);
$app->patch('/api/medical-records/{id}', [MedicalRecordController::class,
    'patch'
]);
$app->delete('/api/medical-records/{id}', [MedicalRecordController::class,
    'delete'
]);


$app->run();
