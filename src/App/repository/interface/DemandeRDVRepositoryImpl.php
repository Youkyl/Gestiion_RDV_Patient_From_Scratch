<?php
namespace App\repository\interface;

use App\entity\DemandeRDV;

interface DemandeRDVRepositortyImpl
{
    public function insertDemande(DemandeRDV $demande): void;
    public function selectDemande(int $patientId): array;
    public function selectDemandeByStaut(string $statut): array;
    public function selectApointment(int $patientId): array;
}