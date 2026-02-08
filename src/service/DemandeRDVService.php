<?php

namespace App\service;

use App\Core\Database;
use App\entity\DemandeRDV;
use App\service\interface\DemandeRDVServiceImpl;
use PDO;

class DemandeRDVService implements DemandeRDVServiceImpl
{

    private static DemandeRDVService $instance;

    private PDO $db;

    private function __construct()
    {
        $this->db = Database::getInstance();
    }


    public static function getInstance(): DemandeRDVService
    {
        if (self::$instance === null) {
            self::$instance = new DemandeRDVService();
        }
        return self::$instance;
    }


    public function addDemand(DemandeRDV $demande): void
    {
        throw new \Exception('Not implemented');
    }

    public function searchDemand(int $patientId): array
    {
        throw new \Exception('Not implemented');
    }

    public function searchApointment(int $patientId): array
    {
        throw new \Exception('Not implemented');
    }

    public function filterDemandByStatus(string $statut): array
    {
        throw new \Exception('Not implemented');
    }
}