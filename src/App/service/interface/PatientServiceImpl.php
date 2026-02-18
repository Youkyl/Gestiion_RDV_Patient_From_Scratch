<?php

namespace App\service\interface;

use App\entity\Patient;
use DateTime;

interface PatientServiceImpl
{
    public function addPatient(Patient $patient): void;

    public function addPersonnalInformation(Patient $patient): void;

    public function addMedicalHistory(Patient $patient, string $medicalHistory): void;

    public function generatePatientCode(): string;
    
    public function connexion(string $email, string $password): ?Patient;
    
    public function completePatientInfo(Patient $patient, DateTime $dateNaissance, string $adresse): void;

    public function addAntecedent(Patient $patient, string $antecedent): void;
    
    public function getConnectedPatientInfo(int $patientId): Patient;

    public function getAllPatien(): array;
}