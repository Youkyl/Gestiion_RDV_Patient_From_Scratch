<?php
namespace App\service;

use App\Core\Database;
use App\entity\Patient;
use App\repository\PatientRepository;
use App\service\interface\PatientServiceImpl;
use App\Utils\PasswordUtil;
use DateTime;
use Exception;
use PDO;

class PatientService implements PatientServiceImpl
{
    
    private static PatientService | null $instance = null;

    private PatientRepository $patientRepo;

    private PasswordUtil $passwordHash;

    private function __construct()
    {
        $this->patientRepo = PatientRepository::getInsatance();
        $this->passwordHash = new PasswordUtil;
    }


    public static function getInstance(): PatientService
    {
        if (self::$instance === null) {
            self::$instance = new PatientService();
        }
        return self::$instance;
    }


    public function createPatient(string $email, string $password, string $firstname, string $lastname, string $phone, string $address, string $birthday, string $medicHist): ?Patient
    {
        $p = new Patient();
        $p->setEmail($email); 
        $p->setPassword($this->passwordHash->hash($password)); 
        $p->setFirstname($firstname); 
        $p->setLastname($lastname); 
        $p->setPhone($phone);  

        if (!empty($birthday)) {
            $date = DateTime::createFromFormat('Y-m-d', $birthday);
            if ($date === false) {
                return null;
            }
            $p->setBirthday($date);  
        }

        $p->setAddress($address); 

        if (!empty($medicHist)) {
            $medicalHistory[] = $medicHist;
            $p->setMedicalHistory($medicalHistory);
        }  

        
        if ($p === null) {
            return null;
        }


        return $p;
    }

    public function addPatient(Patient $patient): void
    {
        if ($patient->getPatientCode() == null || is_null($patient->getPatientCode())) {
            $patient->setPatientCode($this->generatePatientCode());
        }

        if ($patient->getCreatAt() == null) {
            $patient->setCreatAt(new DateTime());
        }

        $this->patientRepo->insertPatient($patient);
    }

    public function addPersonnalInformation(Patient $patient): void
    {
        $this->patientRepo->updatePersonalInformation($patient);
    }

    public function addMedicalHistory(Patient $patient, string $medicalHistory): void
    {
        $history = $patient->getMedicalHistory() != null ? $patient->getMedicalHistory() : [];

        $history[] = $medicalHistory;
        
        $patient->setMedicalHistory($history);

        $this->patientRepo->updateMedicalHistory(patient:$patient, medicalHistory:$history);
    }
    
    public function generatePatientCode(): string
    {
        $nextNumber = $this->patientRepo->getNextPatientCodeNumber(); 
        return sprintf("PAT-%04d", $nextNumber);
    }

    public function connexion(string $email, string $password): ?Patient
    {
        // Récupération du patient par email
        $patient = $this->patientRepo->findByEmailAndPassword(email: $email, password: $password);

        if ($patient === null) {
            return null;
        }

        // Vérification du mot de passe hashé
        if (!PasswordUtil::verify($password, $patient->getPassword())) {
            return null;
        }

        return $patient;
    }
    
    public function completePatientInfo(Patient $patient, DateTime $dateNaissance, string $adresse): void
    {
        $patient->setBirthday($dateNaissance);
        $patient->setAddress($adresse);

        $this->patientRepo->updatePersonalInformation($patient);
    }

    public function addAntecedent(Patient $patient, string $antecedent): void
    {
        throw new Exception('Not implemented');
    }
    
    public function getConnectedPatientInfo(int $patientId): Patient
    {
        return $this->patientRepo->findBy($patientId);
    }

    public function getAllPatien(): array
    {
        return $this->patientRepo->findAll();
    }
}