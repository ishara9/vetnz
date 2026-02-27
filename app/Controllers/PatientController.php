<?php

namespace VetApp\Controllers;

// require_once __DIR__ . "/../Services/PatientService.php";
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use VetApp\Services\PatientService;

class PatientController
{
    private PatientService $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function getAll(Request $request, Response $response): Response
    {
        $patients = $this->patientService->getAllPatients();

        $response->getBody()->write(json_encode($patients));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function getById(Request $request, Response $response, array $args)
    {

        $id = $args['id'];

        $patient = $this->patientService->getPatient($id);
        if (!$patient) {

            $response->getBody()->write(json_encode("Patient not found!"));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }

        $response->getBody()->write(json_encode($patient));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $res = $this->patientService->createPatient($data);

        $response->getBody()
            ->write(json_encode(["message" => "Created:  " . $res]));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {

        $id = $args["id"];

        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data)) {
            $response->getBody()->write(json_encode(["message" => "No data provided for update."]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        $updatingPatient = $this->patientService->getPatient($id);

        if (!$updatingPatient) {
            $response->getBody()->write(json_encode(["message" => "Patient not found!"]));
            return $response->withStatus(404)->withHeader("Content-Type", "application/json");
        }

        $res = $this->patientService->updatePatient($id, $data);

        $response->getBody()
            ->write(json_encode(["message" => "Updated Patient with id:  " . $id . " returned: " . $res]));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(201);
    }

    public function patch(Request $request, Response $response, array $args)
    {

        $id = $args["id"];

        $data = $request->getParsedBody();

        if (empty($data)) {
            $response->getBody()->write(json_encode(["message" => "No data provided for update."]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        $updatingPatient = $this->patientService->getPatient($id);

        if (!$updatingPatient) {
            $response->getBody()->write(json_encode(["message" => "Patient not found!"]));
            return $response->withStatus(404)->withHeader("Content-Type", "application/json");
        } else {
            $data = array_merge($updatingPatient, $data);
        }

        $res = $this->patientService->updatePatient($id, $data);

        $response->getBody()
            ->write(json_encode(["message" => "Updated Patient with id:  " . $id . " returned: " . $res]));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200);
    }


    public function delete(Request $request, Response $response, array $args)
    {
        $this->patientService->deletePatient($args["id"]);
        return $response->withStatus(204);
    }


    // Get medical records for a patient
    public function getMedicalRecords(Request $request, Response $response, array $args)
    {
        $id = $args["id"];
        $medicalRecords = $this->patientService->getPatientMedicalRecords($id);

        if ($medicalRecords === null) {
            $response->getBody()->write(json_encode(["message" => "Patient not found!"]));
            return $response->withStatus(404)->withHeader("Content-Type", "application/json");
        }

        $response->getBody()->write(json_encode($medicalRecords));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200);
    }
}
