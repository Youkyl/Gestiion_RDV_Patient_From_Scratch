<?php

namespace App\repository\interface;

use App\entity\Patient;

interface PatientRepositoryImp
{
    public function insertPatient(Patient $patient ): void;
    public function updatePersonalInformation(): void;
    public function updateMedicalHistory(): void;
}