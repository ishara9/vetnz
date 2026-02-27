<?php

namespace VetApp\Repositories;

use PDO;
use PDOException;
use InvalidArgumentException;
use VetApp\Models\Patient;
use VetApp\Models\MedicalRecord;
use VetApp\Config\Database;

class MedicalRecordRepository
{
    private PDO $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM medical_records");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM medical_records WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function save(MedicalRecord $medicalRecord): int
    {

        // try {
        //     $stmt = $this->db->prepare(
        //         "INSERT INTO medical_records (patient_id, visit_date, diagnosis, treatment)
        //     VALUES ( ?, ?, ?, ?)"
        //     );

        
        //     $stmt->execute([
        //         $medicalRecord->patient_id,
        //         $medicalRecord->visit_date,
        //         $medicalRecord->diagnosis,
        //         $medicalRecord->treatment
        //     ]);
        // } catch (PDOException $e) {
        //     // Handle the exception, e.g., log the error or rethrow it
        //     throw new InvalidArgumentException("Failed to save medical record: " . $e->getMessage());
        // }

        $stmt = $this->db->prepare(
                "INSERT INTO medical_records (patient_id, visit_date, diagnosis, treatment)
            VALUES ( ?, ?, ?, ?)"
            );

        
            $stmt->execute([
                $medicalRecord->patient_id,
                $medicalRecord->visit_date,
                $medicalRecord->diagnosis,
                $medicalRecord->treatment
            ]);

        $stmt->execute([
            $medicalRecord->patient_id,
            $medicalRecord->visit_date,
            $medicalRecord->diagnosis,
            $medicalRecord->treatment
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, MedicalRecord $medicalRecord): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE medical_records
            SET patient_id = ?, visit_date = ?, diagnosis=?, treatment=?
            WHERE id=?"

        );

        return $stmt->execute([
            $medicalRecord->patient_id,
            $medicalRecord->visit_date,
            $medicalRecord->diagnosis,
            $medicalRecord->treatment,
            $id
        ]);
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM medical_records
        WHERE id=?");
        return $stmt->execute([$id]);
    }
}