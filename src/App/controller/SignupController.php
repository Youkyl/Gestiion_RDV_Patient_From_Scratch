<?php

namespace App\controller;

use App\core\Controller;
use App\core\Validator;
use App\service\PatientService;

class SignupController extends Controller
{
    private PatientService $patienSerc;

    public function __construct()
    {
     $this->patienSerc = PatientService::getInstance();
    }   

    public function index()
    {

        // $totalEpargne = 0;
        // $totalCheque =0;
        // $totalSolde = 0;
        // $comptesBloq = 0;
        // foreach ($comptes as $compte) {
        //     $totalSolde += $compte->getSolde();
        //     if ($compte->getType()===TypeDeCompte::EPARGNE) {
        //         $totalEpargne ++;
        //     }
        //     else {
        //         $totalCheque ++;
        //     }

        //     if ($compte->getDureeDeblocage() != null) {
        //         $comptesBloq = $compte->getDureeDeblocage();
        //     }
        // }       
        
        $this->renderHtml('/signup/index.html.php', [
                                                    //'patients' => $patients
                                                    // 'totalSolde' => $totalSolde,
                                                    // 'transac' => $transac,
                                                    // 'totalEpargne' => $totalEpargne,
                                                    // 'totalCheque' => $totalCheque,
                                                    // 'comptesBloq' => $comptesBloq
                                                    ]);
    }

    public function register()
    {
        // Données du formulaire
        $data = $_POST;

        $validator = Validator::getInstance($data);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Règles de validation côté serveur
            $validator->setRules([
                'email'     => ['required', 'email'],
                'password'  => ['required', 'password'],
                'firstname' => ['required'],
                'lastname'  => ['required'],
                'phone'     => ['required', 'phone'],
                'address'   => ['required'],
                'birthdate' => ['required', 'date', 'beforeToday']
            ]);

            // Si la validation échoue, on renvoie sur le formulaire avec les erreurs
            if (!$validator->passes()) {
                $errors = $validator->errors();

                $this->renderHtml('/signup/index.html.php', [
                    'errors' => $errors,
                    'old'    => $data,
                ]);
                return;
            }

            // Données valides

            $email    = $data['email'];
            $password = $data['password'];
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $phone = $data['phone'];
            $address = $data['address'];
            $birthdate = $data['birthdate'];
            $mediclHistory = $data['medicalHistory'] ?? '';

            $patient = $this->patienSerc->createPatient(
                email: $email,
                password: $password,
                firstname: $firstname,
                lastname: $lastname,
                phone: $phone,
                address: $address,
                birthday: $birthdate,
                medicHist: $mediclHistory
            );

            // Creation incorrects
            if ($patient === null) {
                $this->renderHtml('/signup/index.html.php', [
                    'authError' => "Une erreur c'est produite llors de la creation de votre compte.",
                    'old'       => $data,
                ]);
                return;
            }

            $this->patienSerc->addPatient($patient);

            // TODO: ici tu pourras stocker le patient en session
            // $_SESSION['patient_id'] = $patient->getId();

            // Connexion réussie, redirection
            $this->redirect('login/index');
        }
    }
}