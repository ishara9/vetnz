<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Patient.php';

class PatientRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM patients");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM patients WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function save(Patient $patient): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO patients (name, species, breed, owner_name)
        VALUES ( ?, ?, ?, ?)"
        );

        $stmt->execute([
            $patient->name,
            $patient->species,
            $patient->breed,
            $patient->owner_name
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, Patient $patient): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE patients
            SET name = ?, species = ?, breed=?, owner_name=?
            WHERE id=?"

        );

        return $stmt->execute([
            $patient->name,
            $patient->species,
            $patient->breed,
            $patient->owner_name,
            $id
        ]);
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM patients
        WHERE id=?");
        return $stmt->execute([$id]);
    }
}