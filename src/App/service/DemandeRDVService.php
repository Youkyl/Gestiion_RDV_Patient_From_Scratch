<?php

namespace App\service;

use App\Core\Database;
use App\entity\DemandeRDV;
use App\entity\Patient;
use App\entity\Specialite;
use App\entity\Statut;
use App\repository\DemandeRDVRepository;
use App\service\interface\DemandeRDVServiceImpl;
use DateTime;
use PDO;

class DemandeRDVService implements DemandeRDVServiceImpl
{

    private static ?DemandeRDVService $instance = null;

    private DemandeRDVRepository $demandeRepo;

    private function __construct()
    {
        $this->demandeRepo = DemandeRDVRepository::getInstance();
    }


    public static function getInstance(): DemandeRDVService
    {
        if (self::$instance === null) {
            self::$instance = new DemandeRDVService();
        }
        return self::$instance;
    }


    public function creatDemand(Patient $patient, Specialite $specialite, string $description): DemandeRDV
    {
        $d = new DemandeRDV();
        $d->setPatient($patient);
        $d->getPatient()->setId($patient->getId());
        $d->setSpecialite($specialite);
        $d->setDescriptiion($description);
        $d->setCreateAt(new DateTime());
        $d->setStatut(Statut::EN_COURS);

        return $d;
    }

    public function addDemand(DemandeRDV $demande): void
    {            
        if ($demande->getCreateAt() == null) {
           $demande->setCreateAt(new DateTime());
        }

        if ($demande->getStatut() == null) {
            $demande->setStatut(Statut::EN_COURS);
         }

         $this->demandeRepo->insertDemande($demande);;
    }

    public function searchDemand(Patient $patient): array
    {
        return $this->demandeRepo->selectDemande($patient->getId());
    }

    public function searchApointment(Patient $patient): array
    {
        return $this->demandeRepo->selectApointment($patient->getId());
    }

    public function filterDemandByStatus(Patient $patient, string $statut): array
    {
        return $this->demandeRepo->selectDemandeByStaut(patientId:$patient->getId(), statut:$statut);
    }
    
    public function searchDemandeById(int $id): DemandeRDV
    {
        return $this->demandeRepo->findById($id);
    }

    public function getAllDemandes(): array
    {
        return $this->demandeRepo->findAll();
    }
    
    public function changedeamndeStatus(DemandeRDV $demande, Statut $statut): void
    {
        $this->demandeRepo->updateStatus(demandeId:$demande->getId(), statut:$statut);
    }
}