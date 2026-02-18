<?php

namespace App\repository\interface;

use App\entity\Patient;

interface PatientRepositoryImp
{
    public function insertPatient(Patient $patient): void;

    public function updatePersonalInformation(Patient $patient): void;

    public function updateSpecificPersonalInformation(Patient $patient, string $info, string $setClause): void;

    public function updateMedicalHistory(Patient $patient, array $medicalHistory): void;

    /**
     * Retourne le patient correspondant à l'email ou null si aucun résultat.
     * Le mot de passe sera vérifié dans la couche service.
     */
    public function findByEmailAndPassword(string $email, string $password): ?Patient;

    public function findAll(): array;

    public function findBy(int $id): Patient;

    public function getNextPatientCodeNumber(): int;
}
