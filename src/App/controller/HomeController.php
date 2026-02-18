<?php

namespace App\controller;

use App\core\Controller;
use App\core\Validator;
use App\service\PatientService;

class HomeController extends Controller
{
    private PatientService $patienSerc;

    public function __construct()
    {
     $this->patienSerc = PatientService::getInstance();
    }   

    public function index()
    {
        
        $patients =  $this->patienSerc->getConnectedPatientInfo(4);

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
        
        $this->renderHtml('/home/index.html.php', ['patients' => $patients
                                                    // 'totalSolde' => $totalSolde,
                                                    // 'transac' => $transac,
                                                    // 'totalEpargne' => $totalEpargne,
                                                    // 'totalCheque' => $totalCheque,
                                                    // 'comptesBloq' => $comptesBloq
                                                    ]);
    }

}