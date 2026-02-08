<?php

namespace App\service\interface;

use App\entity\DemandeRDV;

interface DemandeRDVServiceImpl
{
    public function addDemand(DemandeRDV $demande): void;
    public function searchDemand(int $patientId): array;
    public function filterDemandByStatus(string $statut): array;
    public function searchApointment(int $patientId): array;
}