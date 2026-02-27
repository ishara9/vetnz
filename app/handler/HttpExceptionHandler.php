<?php

namespace VetApp\Handler;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

class HttpExceptionHandler {

 private $responseFactory;

 public function __construct($responseFactory) {
    $this->responseFactory = $responseFactory;
 }

    public function __invoke(Request $request, Throwable $exception, bool $displayErrorDetails) : Response 
    {
        $response = $this->responseFactory->createResponse();

        $statusCode = 500; // Default to 500 Internal Server Error
        $message = $exception->getMessage(); // Set message to exception message by default, not a best practice for production but useful for development

        if ($exception instanceof InvalidArgumentException) {
            $statusCode = 400; // Bad Request
            $message = $exception->getMessage();
        }   

        if ($exception instanceof RuntimeException) {
            $statusCode = 404; // Not Found
            $message = $exception->getMessage();
        }

        $response->getBody()->write(json_encode([
            "error" => $message
        ]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }
}
