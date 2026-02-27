<?php

namespace VetApp\Models;

class MedicalRecord
{
    public function __construct(
        public ?int $id,
        public int $patient_id,
        public ?string $visit_date,
        public ?string $diagnosis,
        public ?string $treatment,
        public ?string $created_at = null
    ) {
    }
}