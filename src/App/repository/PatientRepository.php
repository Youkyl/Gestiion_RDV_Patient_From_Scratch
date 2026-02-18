<?php

namespace App\repository;

use App\Core\Database;
use App\entity\Patient;
use App\repository\interface\PatientRepositoryImp;
use PDO;

class PatientRepository implements PatientRepositoryImp
{

    private static PatientRepository | null $instance = null;
    
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
        try {
            $sql = "INSERT INTO patient (patient_code, lastname, firstname, address, phone, medical_history, email, password, birthday) 
            VALUES (:code, :lastn, :firstn, :address, :phone, :madic_hist::jsonb, :email, :password, :bd) RETURNING id, patient_code, created_at";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ":code" => $patient->getPatientCode(),
                ":lastn" => $patient->getLastname(),
                ":firstn" => $patient->getFirstname(),
                ":address" => $patient->getAddress(),
                ":phone" => $patient->getPhone(),
                ":madic_hist" => json_encode($patient->getMedicalHistory()),
                ":email" => $patient->getEmail(),
                ":password" => $patient->getPassword(),
                ":bd" => $patient->getBirthday()->format("Y-m-d"),
            ]);

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $patient->setId($row["id"]);
                $patient->setPatientCode($row["patient_code"]);
                $created = $row["created_at"];
                $patient->setCreatAt($created != null ? new \DateTime($created) : null);
            }

        } catch (\PDOException $e) {
            throw new \Exception("Failed to insert patient: " . $e->getMessage());
        }
    }

    public function updatePersonalInformation(Patient $patient): void
    {
        try {
            $sql = "UPDATE patient 
                    SET lastname= :lastn, firstname= :firstn, address= :address, phone= :phone, birthday= :bd 
                    WHERE id= :id";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ":lastn" => $patient->getLastname(),
                ":firstn" => $patient->getFirstname(),
                ":address" => $patient->getAddress(),
                ":phone" => $patient->getPhone(),
                ":bd" => $patient->getBirthday()->format("Y-m-d"),
                ":id" => $patient->getId(),
            ]);

        } catch (\PDOException $e) {
            throw new \Exception("Failed to update patient information: " . $e->getMessage());
        };
    }

    public function updateSpecificPersonalInformation(Patient $patient, string $info, string $setClause): void
    {
        try {
            $sql = "UPDATE patient 
                    SET $setClause 
                    WHERE id= :id";

            $stmt = $this->db->prepare($sql);

            if ($setClause == "lastname = :lastn") {
                $stmt->bindValue(":lastn", $patient->getLastname());
            } elseif ($setClause == "firstname = :firstn") {
                $stmt->bindValue(":firstn", $patient->getFirstname());
            } elseif ($setClause == "address = :address") {
                $stmt->bindValue(":address", $patient->getAddress());
            } elseif ($setClause == "phone = :phone") {
                $stmt->bindValue(":phone", $patient->getPhone());
            } elseif ($setClause == "birthday = :bd") {
                $stmt->bindValue(":bd", $patient->getBirthday()->format("Y-m-d"));
            }
            
            $stmt->execute();
            
        } catch (\PDOException $e) {
            throw new \Exception("Failed to update patient information: " . $e->getMessage());
        }
    }

    public function updateMedicalHistory(Patient $patient, array $medicalHistory): void
    {
        try {
            $sql ="UPDATE patient 
                   SET medical_history = :medical_hist::jsonb 
                   WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ":medical_hist" => json_encode($medicalHistory),
                ":id" => $patient->getId(),
            ]);

            $patient->setMedicalHistory($medicalHistory);

        } catch (\PDOException $e) {
            throw new \Exception("Failed to update patient medical history: " . $e->getMessage());
        }
    }

    public function findByEmailAndPassword(string $email, string $password): ?Patient
    {
        try {
            $sql = "SELECT id, patient_code, lastname, firstname, address, phone, medical_history, email, password, birthday, created_at 
                    FROM patient 
                    WHERE email = :email --AND password = :password";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ":email" => $email,
                //":password" => $password,
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapRowToPatient($row);
            
        } catch (\PDOException $e) {
            throw new \Exception("Failed to find patient by email and password: " . $e->getMessage());
        }
    }

    public function findAll(): array
    {
        try {
            $sql = "SELECT id, patient_code, lastname, firstname, address, phone, medical_history, email, password, birthday, created_at FROM patient ORDER BY id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $patients[] = $this->mapRowToPatient($row);
            }

            return $patients;

        } catch (\PDOException $e) {
            throw new \Exception("Failed to find all patients: " . $e->getMessage());
        }
    }

    public function findBy(int $id): Patient
    {
        try {
            $sql = "SELECT id, patient_code, lastname, firstname, address, phone, medical_history, email, password, birthday, created_at FROM patient WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ":id" => $id,
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->mapRowToPatient($row);

        } catch (\PDOException $e) {
            throw new \Exception("Failed to find patient by id: " . $e->getMessage());
        }
    }

    public function getNextPatientCodeNumber(): int
    {
        try {
            $sql = "SELECT MAX(CAST(SUBSTRING(patient_code, 5) AS INTEGER)) AS max_num FROM patient WHERE patient_code LIKE 'PAT-%'";

            $stmt = $this->db->prepare($sql);

            $stmt->execute();

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                return $row["max_num"] + 1;
            }

            return 1;

        } catch (\PDOException $e) {
            throw new \Exception("Failed to get next patient code number: " . $e->getMessage());
        }
    }

    private function mapRowToPatient($row) 
    {
        $p = new Patient();
        $p->setId($row["id"]);
        $p->setPatientCode($row["patient_code"]);
        $p->setLastname($row["lastname"]);
        $p->setFirstname($row["firstname"]);
        $p->setAddress($row["address"]);
        $p->setPhone($row["phone"]);
        $json = $row["medical_history"];
        $p->setMedicalHistory(!empty($json) ? json_decode($json, true) : []);
        $p->setEmail($row["email"]);
        $p->setPassword($row["password"]);

        $bd = $row["birthday"];
        $p->setBirthday($bd !== null ? new \DateTime($bd) : null);

        $created = $row["created_at"];
        $p->setCreatAt($created !== null ? new \DateTime($created) : null);
        return $p;
    }
}