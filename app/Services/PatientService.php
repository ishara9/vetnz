<?php

require_once __DIR__ . "/../Repositories/PatientRepository.php";
require_once __DIR__ . "/../Models/Patient.php";

class PatientService
{


    private PatientRepository $patientRepository;

    public function __construct()
    {
        $this->patientRepository = new PatientRepository();
    }

    public function getAllPatients(): array
    {
        return $this->patientRepository->findAll();
    }

    public function getPatient($id): ?array
    {
        return $this->patientRepository->findById($id);
    }

    public function createPatient(array $data): int
    {
        $patient = new Patient(
            null,
            $data["name"],
            $data["species"],
            $data["breed"],
            $data["owner_name"]
        );

        return $this->patientRepository->save($patient);
    }

    public function updatePatient(int $id, array $data): int
    {
        $patient = new Patient(
            $id,
            $data["name"],
            $data["species"],
            $data["breed"],
            $data["owner_name"]
        );

        return $this->patientRepository->update($id, $patient);
    }

    public function deletePatient($id): bool
    {
        return $this->patientRepository->delete($id);
    }

}