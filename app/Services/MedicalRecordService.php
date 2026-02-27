<?php

namespace VetApp\Services;

use VetApp\Repositories\MedicalRecordRepository;
use VetApp\Models\MedicalRecord;

class MedicalRecordService
{
    private MedicalRecordRepository $medicalRecordRepository;

    public function __construct(MedicalRecordRepository $medicalRecordRepository)
    {
        $this->medicalRecordRepository = $medicalRecordRepository;
    }

    public function getAllMedicalRecords(): array
    {
        return $this->medicalRecordRepository->findAll();
    }

    public function getMedicalRecord($id): ?array
    {
        return $this->medicalRecordRepository->findById($id);
    }

    public function createMedicalRecord(array $data): int
    {
        $medicalRecord = new MedicalRecord(
            null,
            $data["patient_id"],
            $data["visit_date"],
            $data["diagnosis"],
            $data["treatment"]
        );

        return $this->medicalRecordRepository->save($medicalRecord);
    }

    public function updateMedicalRecord(int $id, array $data): int
    {
        $medicalRecord = new MedicalRecord(
            $id,
            $data["patient_id"],
            $data["visit_date"],
            $data["diagnosis"],
            $data["treatment"]
        );

        return $this->medicalRecordRepository->update($id, $medicalRecord);
    }

    public function deleteMedicalRecord($id): bool
    {
        return $this->medicalRecordRepository->delete($id);
    }

}