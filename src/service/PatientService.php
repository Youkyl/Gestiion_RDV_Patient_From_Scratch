<?php
namespace App\service;

use App\Core\Database;
use App\entity\Patient;
use App\service\interface\PatientServiceImpl;
use PDO;

class PatientService implements PatientServiceImpl
{
    
    private static PatientService $instance;

    private PDO $db;

    private function __construct()
    {
        $this->db = Database::getInstance();
    }


    public static function getInstance(): PatientService
    {
        if (self::$instance === null) {
            self::$instance = new PatientService();
        }
        return self::$instance;
    }


    public function addPatien(Patient $patient): void
    {
        throw new \Exception('Not implemented');
    }

    public function addPersonnalInformation(): void
    {
        throw new \Exception('Not implemented');
    }

    public function addMedicalHistory(): void
    {
        throw new \Exception('Not implemented');
    }
}