<?php

namespace App\repository;

use App\Core\Database;
use App\entity\DemandeRDV;
use App\repository\interface\DemandeRDVRepositortyImpl;
use PDO;

class DemandeRDVRepository implements DemandeRDVRepositortyImpl
{

    private static DemandeRDVRepository $instance;

    private PDO $db;

    private function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function getInstance(): DemandeRDVRepository
    {
        if (self::$instance === null) {
            self::$instance = new DemandeRDVRepository();
        }
        return self::$instance;
    }


    public function insertDemande(DemandeRDV $demande): void
    {
        throw new \Exception('Not implemented');
    }

    public function selectDemande(int $patientId): array
    {
        throw new \Exception('Not implemented');
    }
    
    public function selectDemandeByStaut(string $statut): array
    {
        throw new \Exception('Not implemented');
    }

    public function selectApointment(int $patientId): array
    {
        throw new \Exception('Not implemented');
    }

}