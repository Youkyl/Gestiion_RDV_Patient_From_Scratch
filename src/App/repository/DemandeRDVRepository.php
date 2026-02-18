<?php

namespace App\repository;

use App\Core\Database;
use App\entity\DemandeRDV;
use App\entity\Patient;
use App\entity\Statut;
use App\repository\interface\DemandeRDVRepositoryImpl;
use DateTime;
use PDO;

class DemandeRDVRepository implements DemandeRDVRepositoryImpl
{

    private static ?DemandeRDVRepository $instance = null;

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
        
        try {
            $sql = "
                INSERT INTO demande_rdv (description, patient_id, specialite, statut) 
                VALUES (:descrip, :patient_id, :spe::specialite_enum, :stat::statut_enum) RETURNING id, created_at";

            $stmt = $this->db->prepare($sql); 

            $stmt->execute([
                ':descrip' => $demande->getDescriptiion(),
                ':patient_id' => $demande->getPatient()->getId(),
                ':spe' => $demande->getSpecialite(),
                ':stat' => $demande->getStatut()
            ]);

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $demande->setId($row["id"]);
                $created = $row["created_at"];
                $demande->setCreateAt($created != null ? new DateTime($created) : null);
            }

        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de l'insertion de la demande de rendez-vous: " . $e->getMessage());
        }
    }

    public function selectDemande(int $patientId): array
    {
        return $this->findDemandesByCondition("WHERE patient_id = ?", $patientId);
    }
    
    public function selectDemandeByStaut(string $statut, int $patientId): array
    {
        try {
            $sql = ($patientId == 0)
                ? "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv WHERE statut = :stat::statut_enum ORDER BY created_at DESC"
                : "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv WHERE statut = :stat::statut_enum AND patient_id = :pat_id ORDER BY created_at DESC";

                $stmt = $this->db->prepare($sql); 

                if ($patientId != 0) {
                    $stmt->execute([
                        ':pat_id' => $patientId,
                        ':stat' => $statut
                    ]);
                } else {
                    $stmt->execute([
                        ':stat' => $statut
                    ]);
                }
                
                $list = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $list[] = $this->mapRowToDemande($row);
                }
                
        } catch (\PDOException $e) {
            throw new \Exception("Error selecting demandes by statut: " . $e->getMessage());
        }

        return $list;
    }

    public function selectApointment(int $patientId): array
    {
        return $this->selectDemandeByStaut(Statut::ACCEPTE->name, $patientId);
    }

    public function findById(int $patientId): DemandeRDV
    {
        try {
            $sql = "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv WHERE id = :pat_id";

            $stmt = $this->db->prepare($sql); 

            $stmt->execute([
                ':pat_id' => $patientId
            ]);

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                return $this->mapRowToDemande($row);
            }

        } catch (\PDOException $e) {
            throw new \Exception("Error finding demande by ID: " . $e->getMessage());
        }

        throw new \Exception("Demande with ID {$patientId} not found.");
    }

    public function updateStatus(int $demandeId, Statut $statut): void
    {
        try {
            $sql = "UPDATE demande_rdv SET statut = :stat::statut_enum WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':id' => $demandeId,
                ':stat' => $statut
            ]);

        } catch (\PDOException $e) {
            throw new \Exception("Error updating demande statut: " . $e->getMessage());
        }
    }

    public function findAll(): array
    {
        return $this->findDemandesByCondition("", 0);
    }

    public function findDemandesByCondition(string $whereClause, int $patientId): array
    {
        try {
            $sql = (is_null($whereClause) || empty($whereClause))
                ? "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv ORDER BY created_at DESC"
                : "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv " . $whereClause . " ORDER BY created_at DESC";

             
            // if (is_null($whereClause) || empty($whereClause)) {
            //     $sql = "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv ORDER BY created_at DESC";
            // } else {
            //     $sql = "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv " . $whereClause . " ORDER BY created_at DESC";
            // }

            // $sql = empty($whereClause) 
            //     ? "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv ORDER BY created_at DESC"
            //     : "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv " . $whereClause . " ORDER BY created_at DESC";

            $stmt = $this->db->prepare($sql);

            if ($patientId != 0) {

                $stmt->execute([
                    ':patient_id' => $patientId,
                ]);
            }

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $list[] = $this->mapRowToDemande($row);
            }
            
        } catch (\PDOException $e) {
            throw new \Exception("Error selecting demandes: " . $e->getMessage());
        }
        return $list;
    }

    private function mapRowToDemande($row) 
    {
        $d = new DemandeRDV();
        $d->setId($row["id"]);
        $d->setDescriptiion($row["description"]);
        
        $created = $row["created_at"];
        $d->setCreateAt($created != null ? new DateTime($created) : null);

        if ($d->getPatient() == null) {
            $d->setPatient(new Patient());
        }

        $d->getPatient()->setId($row["patient_id"]);
        
        $spec = $row["specialite"];
        $d->setSpecialite($spec != null ? constant("Specialite::" . $spec) : null);
        
        $st = $row["statut"];
        $d->setStatut($st != null ? constant("Statut::" . $st) : null);
        
        return $d;
    }

}