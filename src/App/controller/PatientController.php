<?php

namespace App\controller;

use App\core\Controller;
use App\entity\Statut;
use App\service\DemandeRDVService;
use App\service\PatientService;

class PatientController extends Controller
{
    private PatientService $patientService;
    private DemandeRDVService $demandeService;

    public function __construct()
    {
        $this->patientService = PatientService::getInstance();
        $this->demandeService = DemandeRDVService::getInstance();
    }

    /**
     * Afficher le profil du patient connecté
     */
    public function dashboard()
    {
        // Vérifier si un patient est connecté
        if (!isset($_SESSION['patient_id'])) {
            $this->redirect('login/index');
            return;
        }

        // Récupérer l'ID du patient depuis la session
        $patientId = $_SESSION['patient_id'];

        // Récupérer les infos du patient
        $patient = $this->patientService->getConnectedPatientInfo($patientId);

        // Recuperer le nombre total de demandes du patient
        $totalDemand = 0;
        if ($patient->getDemandes() !== null) {
            for ($i=0; $i < count($patient->getDemandes()); $i++) { 
                $totalDemand++;
            }
        }

        $totalApointment = 0;
        $apointment = $this->demandeService->searchApointment($patient);

        if ($apointment !== null) {
            for ($i=0; $i < count($apointment); $i++) { 
                $totalApointment++;
            }
        }

        $totalWaitingApointment = 0;
        $waitingApointment = $this->demandeService->filterDemandByStatus(patient: $patient, statut: Statut::EN_COURS->name);

        if ($waitingApointment !== null) {
            for ($i=0; $i < count($waitingApointment); $i++) { 
                $totalWaitingApointment++;
            }
        }

        if ($patient === null) {
            $this->redirect('login/index');
            return;
        }

        // Afficher la page du profil
        $this->renderHtml('/patient/home/index.html.php', [
            'patient' => $patient,
            'totalDemand' => $totalDemand,
            'totalApointment' => $totalApointment,
            'totalWaitingApointment' => $totalWaitingApointment
        ]);
    }
}
