<?php

class Patient
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $species,
        public ?string $breed,
        public ?string $owner_name,
        public ?string $created_at = null
    ) {
    }
}