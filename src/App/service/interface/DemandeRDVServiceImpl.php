<?php

namespace App\service\interface;

use App\entity\DemandeRDV;
use App\entity\Patient;
use App\entity\Statut;

interface DemandeRDVServiceImpl
{
    public function addDemand(DemandeRDV $demande): void;

    public function searchDemand(Patient $patient): array;
    
    public function filterDemandByStatus(Patient $patient, string $statut): array;

    public function searchApointment(Patient $patient): array;

    public function searchDemandeById(int $id): DemandeRDV;

    public function getAllDemandes(): array;
    
    public function changedeamndeStatus(DemandeRDV $demande, Statut $statut): void;
}