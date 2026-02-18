<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MédiRendez-vous — Créer un compte</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo CSS_ROOT; ?>/Signup.css">
</head>
<body>

  <div class="bg-blob"></div>
  <div class="bg-blob"></div>

  <div class="wrapper">

    <!-- Brand -->
    <div class="brand" id="brand-header">
      <div class="brand-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
      </div>
      <h1>Créer un compte</h1>
      <p class="step-label" id="step-label">Étape 1 sur 3</p>
    </div>

    <!-- Progress -->
    <div class="progress-bar" id="progress-bar">
      <div class="progress-segment active" id="seg-1"><div class="fill"></div></div>
      <div class="progress-segment" id="seg-2"><div class="fill"></div></div>
      <div class="progress-segment" id="seg-3"><div class="fill"></div></div>
    </div>

    <!-- Card -->
    <div class="card">
      <form id="signup-form" method="POST" action="/signup/register" novalidate>
        <input type="hidden" name="medicalHistory" id="medicalHistory" />

      <!-- ── STEP 1 : Informations de connexion ── -->
      <div class="step-panel active" id="step-1">
        <h2>Informations de connexion</h2>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="votre.email@exemple.com" autocomplete="email" />
          <span class="error-msg" id="email-error">Veuillez saisir un email valide.</span>
        </div>

        <div class="form-group">
          <label for="password">Mot de passe</label>
          <div class="pw-wrap">
            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password" />
            <button class="pw-toggle" id="toggle-pw1" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          <div class="pw-strength" id="pw-strength" data-level="0">
            <span></span><span></span><span></span><span></span>
          </div>
          <span class="error-msg" id="password-error">Le mot de passe doit contenir au moins 6 caractères.</span>
        </div>

        <div class="form-group">
          <label for="confirm-password">Confirmer le mot de passe</label>
          <div class="pw-wrap">
            <input type="password" id="confirm-password" placeholder="••••••••" autocomplete="new-password" />
            <button class="pw-toggle" id="toggle-pw2" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          <span class="error-msg" id="confirm-error">Les mots de passe ne correspondent pas.</span>
        </div>

        <div class="btn-row">
          <button class="btn btn-primary" id="btn-step1">
            <span class="btn-text">Continuer</span>
            <span class="spinner"></span>
          </button>
        </div>

        <div class="card-footer">
          <p>Déjà un compte ? <a href="<?php echo WEB_ROOT; ?>/login/index">Se connecter</a></p>
        </div>
      </div>

      <!-- ── STEP 2 : Informations personnelles ── -->
      <div class="step-panel" id="step-2">
        <h2>Informations personnelles</h2>

        <div class="form-row">
          <div class="form-group" style="margin-bottom:0">
            <label for="firstname">Prénom</label>
            <input type="text" id="firstname" name="firstname" placeholder="Jean" autocomplete="given-name" />
            <span class="error-msg" id="firstname-error">Champ requis.</span>
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label for="lastname">Nom</label>
            <input type="text" id="lastname" name="lastname" placeholder="Dupont" autocomplete="family-name" />
            <span class="error-msg" id="lastname-error">Champ requis.</span>
          </div>
        </div>

        <div class="form-group" style="margin-top:18px">
          <label for="birthdate">Date de naissance</label>
          <input type="date" id="birthdate" name="birthdate" autocomplete="bday" />
          <span class="error-msg" id="birthdate-error">Veuillez saisir votre date de naissance.</span>
        </div>

        <div class="form-group">
          <label for="phone">Téléphone</label>
          <input type="tel" id="phone" name="phone" placeholder="+33 6 00 00 00 00" autocomplete="tel" />
          <span class="error-msg" id="phone-error">Numéro invalide.</span>
        </div>

        <div class="form-group">
          <label for="address">Adresse</label>
          <input type="text" id="address" name="address" placeholder="12 rue de la Paix, Paris" autocomplete="street-address" />
          <span class="error-msg" id="address-error">Champ requis.</span>
        </div>

        <div class="btn-row">
          <button class="btn btn-secondary" id="btn-back2">Retour</button>
          <button class="btn btn-primary" id="btn-step2">
            <span class="btn-text">Continuer</span>
            <span class="spinner"></span>
          </button>
        </div>
      </div>

      <!-- ── STEP 3 : Antécédents médicaux ── -->
      <div class="step-panel" id="step-3">
        <h2>Antécédents médicaux</h2>

        <label for="antecedent-input" style="margin-bottom:8px; display:block;">Ajouter un antécédent ou condition médicale</label>
        <div class="antecedent-input-row">
          <input type="text" id="antecedent-input" placeholder="Ex: Diabète, Allergie, etc." />
          <button class="btn btn-green" id="btn-add-antecedent">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Ajouter
          </button>
        </div>

        <div class="antecedent-list" id="antecedent-list">
          <div class="empty-state" id="empty-state">
            <p>Aucun antécédent ajouté pour le moment.<br/>Vous pouvez continuer sans ajouter d'antécédents.</p>
          </div>
        </div>

        <div class="btn-row" style="margin-top:28px">
          <button class="btn btn-secondary" id="btn-back3" type="button">Retour</button>
          <button class="btn btn-primary" id="btn-submit" type="submit">
            <span class="btn-text">Créer mon compte</span>
            <span class="spinner"></span>
          </button>
        </div>
      </div>

      <!-- ── SUCCESS ── -->
      <div class="success-screen" id="success-screen">
        <div class="success-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h2>Compte créé !</h2>
        <p>Votre espace patient a été créé avec succès.<br/>Vous pouvez maintenant vous connecter.</p>
        <a href="<?php echo WEB_ROOT; ?>/login/index" class="btn btn-primary">
          <span class="btn-text">Se connecter</span>
        </a>
      </div>

      </form>
    </div><!-- /card -->

  </div><!-- /wrapper -->

  <div class="toast" id="toast"></div>

  <script src="<?php echo JS_ROOT; ?>/Signup.js"></script>

</body>
</html>