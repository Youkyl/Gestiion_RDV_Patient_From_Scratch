<?php

namespace App\controller;

use App\core\Controller;
use App\core\Validator;
use App\service\PatientService;

class LoginController extends Controller
{
    private PatientService $patienSerc;

    public function __construct()
    {
     $this->patienSerc = PatientService::getInstance();
    }   

    public function index()
    {
        
        $patients =  $this->patienSerc->getAllPatien();

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
        
        $this->renderHtml('/login/index.html.php', ['patients' => $patients
                                                    // 'totalSolde' => $totalSolde,
                                                    // 'transac' => $transac,
                                                    // 'totalEpargne' => $totalEpargne,
                                                    // 'totalCheque' => $totalCheque,
                                                    // 'comptesBloq' => $comptesBloq
                                                    ]);
    }

    public function login()
    {
        // Données du formulaire
        $data = $_POST;

        $validator = Validator::getInstance($data);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Règles de validation côté serveur
            $validator->setRules([
                'email'    => ['required', 'email'],
                //'password' => ['required', 'password'],
            ]);

            // Si la validation échoue, on renvoie sur le formulaire avec les erreurs
            if (!$validator->passes()) {
                $errors = $validator->errors();

                $this->renderHtml('/login/index.html.php', [
                    'errors' => $errors,
                    'old'    => $data,
                ]);
                return;
            }

            // Données valides, tentative de connexion
            $email    = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            $patient = $this->patienSerc->connexion(email: $email, password: $password);

            // Identifiants incorrects
            if ($patient === null) {
                $this->renderHtml('/login/index.html.php', [
                    'authError' => "Email ou mot de passe incorrect.",
                    'old'       => $data,
                ]);
                return;
            }

            // TODO: ici tu pourras stocker le patient en session
            session_regenerate_id(true);
            $_SESSION['patient_id'] = $patient->getId();
            $_SESSION['patient_firstname'] = $patient->getFirstname();

            // Connexion réussie, redirection vers le profil du patient
            $this->redirect($patient->getFirstname());
        }
    }

    public function logout()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();

        $this->redirect('login/index');
    }
}