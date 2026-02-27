<?php

namespace VetApp\Tests\Services;

use PHPUnit\Framework\TestCase;
use VetApp\Models\Patient;
use VetApp\Repositories\PatientRepository;
use VetApp\Services\PatientService;

class PatientServiceTest extends TestCase
{
    public function testGetAllPatientsReturnsRepositoryResults(): void
    {
        $patients = [
            [
                'id' => 1,
                'name' => 'Milo',
                'species' => 'Cat',
                'breed' => 'Tabby',
                'owner_name' => 'Alex'
            ]
        ];

        $repository = $this->createMock(PatientRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($patients);

        $service = new PatientService($repository);

        $result = $service->getAllPatients();

        $this->assertSame($patients, $result);
    }

    public function testGetPatientReturnsRepositoryPatientById(): void
    {
        $patient = [
            'id' => 2,
            'name' => 'Buddy',
            'species' => 'Dog',
            'breed' => 'Labrador',
            'owner_name' => 'Jamie'
        ];

        $repository = $this->createMock(PatientRepository::class);
        $repository->expects($this->once())
            ->method('findById')
            ->with(2)
            ->willReturn($patient);

        $service = new PatientService($repository);

        $result = $service->getPatient(2);

        $this->assertSame($patient, $result);
    }

    public function testCreatePatientBuildsModelAndReturnsCreatedId(): void
    {
        $input = [
            'name' => 'Luna',
            'species' => 'Cat',
            'breed' => 'Siamese',
            'owner_name' => 'Taylor'
        ];

        $repository = $this->createMock(PatientRepository::class);
        $repository->expects($this->once())
            ->method('save')
            ->with($this->callback(function ($patient) use ($input): bool {
                return $patient instanceof Patient
                    && $patient->id === null
                    && $patient->name === $input['name']
                    && $patient->species === $input['species']
                    && $patient->breed === $input['breed']
                    && $patient->owner_name === $input['owner_name'];
            }))
            ->willReturn(15);

        $service = new PatientService($repository);

        $result = $service->createPatient($input);

        $this->assertSame(15, $result);
    }

    public function testUpdatePatientBuildsModelWithIdAndReturnsResultAsInt(): void
    {
        $id = 7;
        $input = [
            'name' => 'Rocky',
            'species' => 'Dog',
            'breed' => 'Beagle',
            'owner_name' => 'Morgan'
        ];

        $repository = $this->createMock(PatientRepository::class);
        $repository->expects($this->once())
            ->method('update')
            ->with(
                $id,
                $this->callback(function ($patient) use ($id, $input): bool {
                    return $patient instanceof Patient
                        && $patient->id === $id
                        && $patient->name === $input['name']
                        && $patient->species === $input['species']
                        && $patient->breed === $input['breed']
                        && $patient->owner_name === $input['owner_name'];
                })
            )
            ->willReturn(true);

        $service = new PatientService($repository);

        $result = $service->updatePatient($id, $input);

        $this->assertSame(1, $result);
    }

    public function testDeletePatientDelegatesToRepository(): void
    {
        $repository = $this->createMock(PatientRepository::class);
        $repository->expects($this->once())
            ->method('delete')
            ->with(3)
            ->willReturn(true);

        $service = new PatientService($repository);

        $result = $service->deletePatient(3);

        $this->assertTrue($result);
    }
}
