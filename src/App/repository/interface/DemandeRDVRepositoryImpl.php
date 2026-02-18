<?php
namespace App\repository\interface;

use App\entity\DemandeRDV;
use App\entity\Statut;

interface DemandeRDVRepositoryImpl
{
    public function insertDemande(DemandeRDV $demande): void;

    public function selectDemande(int $patientId): array;

    public function selectDemandeByStaut(string $statut, int $patientId): array;

    public function selectApointment(int $patientId): array;

    public function findById(int $patientId): DemandeRDV;

    public function updateStatus(int $demandeId, Statut $statut): void;

    public function findAll(): array;
    
    public function findDemandesByCondition(string $whereClause, int $patientId): array;
}