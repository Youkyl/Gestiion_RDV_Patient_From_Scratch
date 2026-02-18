<?php
/**
 * @var object $patient - L'objet patient connecté
 */
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>Profil Patient</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Prénom</h5>
                            <p><?php echo htmlspecialchars($patient->getFirstname()); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Nom</h5>
                            <p><?php echo htmlspecialchars($patient->getLastname()); ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Email</h5>
                            <p><?php echo htmlspecialchars($patient->getEmail()); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Téléphone</h5>
                            <p><?php echo htmlspecialchars($patient->getPhone()); ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Date de Naissance</h5>
                            <p><?php echo $patient->getBirthday()->format('d/m/Y'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Adresse</h5>
                            <p><?php echo htmlspecialchars($patient->getAddress()); ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>Code Patient</h5>
                            <p><?php echo htmlspecialchars($patient->getPatientCode()); ?></p>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?php echo WEB_ROOT; ?>/login/logout" class="btn btn-danger">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
