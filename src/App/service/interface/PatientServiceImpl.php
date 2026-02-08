<?php

namespace App\service\interface;

use App\entity\Patient;

interface PatientServiceImpl
{
    public function addPatien(Patient $patient): void;
    public function addPersonnalInformation(): void;
    public function addMedicalHistory(): void;
}