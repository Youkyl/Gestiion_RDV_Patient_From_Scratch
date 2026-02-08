<?php

namespace App\repository;

use App\Core\Database;
use App\entity\Patient;
use App\repository\interface\PatientRepositoryImp;
use PDO;

class PatientRepository implements PatientRepositoryImp
{

    private static PatientRepository $instance;
    
    private PDO $db;

    private function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function getInsatance(): PatientRepository
    {
        if (self::$instance === null) {
            self::$instance = new PatientRepository();
        }
        return self::$instance;
    }


    public function insertPatient(Patient $patient): void
    {
        throw new \Exception('Not implemented');
    }

    public function updatePersonalInformation(): void
    {
        throw new \Exception('Not implemented');
    }

    public function updateMedicalHistory(): void
    {
        throw new \Exception('Not implemented');
    }
}