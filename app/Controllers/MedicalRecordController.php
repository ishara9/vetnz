<?php

namespace VetApp\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use VetApp\Services\MedicalRecordService;
use InvalidArgumentException;

class MedicalRecordController
{
    private MedicalRecordService $medicalRecordService;

    public function __construct(
        MedicalRecordService $medicalRecordService
    ) {
        $this->medicalRecordService = $medicalRecordService;
    }

    public function getAll(Request $request, Response $response): Response
    {
        $medicalRecords = $this->medicalRecordService->getAllMedicalRecords();

        $response->getBody()->write(json_encode($medicalRecords));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function getById(Request $request, Response $response, array $args): Response
    {
        $medicalRecord = $this->medicalRecordService->getMedicalRecord($args['id']);

        if (!$medicalRecord) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($medicalRecord));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }


    public function create(Request $request, Response $response): Response
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $res = $this->medicalRecordService->createMedicalRecord($data);
        $response->getBody()
            ->write(json_encode(["message" => "Created:  " . $res]));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(201);
    }


    public function update(Request $request, Response $response, array $args): Response
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $res = $this->medicalRecordService->updateMedicalRecord($args['id'], $data);

        if ($res === 0) {
            $response->getBody()->write(json_encode(["message" => "Medical record not found!"]));
            return $response->withStatus(404)->withHeader("Content-Type", "application/json");
        }

        $response->getBody()->write(json_encode(["message" => "Updated:  " . $res]));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200);
    }

    public function patch(Request $request, Response $response, array $args): Response
    {

        $id = $args["id"];

        $data = $request->getParsedBody();

        if (empty($data)) {
            $response->getBody()->write(json_encode(["message" => "No data provided for update."]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        $updatingMedicalRecord = $this->medicalRecordService->getMedicalRecord($id);

        if ($updatingMedicalRecord) {
            $data = array_merge($updatingMedicalRecord, $data);            
        } else {
            $response->getBody()->write(json_encode(["message" => "Medical record not found!"]));
            return $response->withStatus(404)->withHeader("Content-Type", "application/json");
        }

        $res = $this->medicalRecordService->updateMedicalRecord($id, $data);

        $response->getBody()
            ->write(json_encode(["message" => "Updated Medical Record with id:  " . $id . " returned: " . $res]));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->medicalRecordService->deleteMedicalRecord($args['id']);
        $response->getBody()->write(json_encode(["message" => "Deleted medical record with id:  " . $args['id']]));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200);
    }


}