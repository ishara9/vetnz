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


// require_once __DIR__ . "/../app/Controllers/PatientController.php";

// $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
// $method = $_SERVER["REQUEST_METHOD"];

// $controller = new PatientController();

// // switch ($uri) {
// //     case "/api/patients":
// //         echo "Hello, World!";
// //         break;
// //     default:
// //         http_response_code(404);
// //         echo "Not Found";
// //         break;
// // }

// $parts = explode("/", trim($uri,'/'));

// // Patient apis
// if($parts[0] == 'api' && $parts[1] === 'patients'){
//     if($method === 'GET'){
//         $controller->getAll();
//     }
//     elseif 
// }


// if ($uri === "/api/patients" && $method === "GET") {
//     $controller->getAll();
// }
// elseif($uri === "#^/api/patients/(\d+)$#" && $method === "GET") {
//     $controller->getById((int) $matches[1]);
// }
// elseif()