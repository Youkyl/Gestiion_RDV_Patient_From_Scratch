<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MédiRendez-vous — Connexion</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo CSS_ROOT; ?>/Login.css">
</head>
<body>

  <!-- Background blobs -->
  <div class="bg-blob"></div>
  <div class="bg-blob"></div>
  <div class="bg-blob"></div>

  <div class="wrapper">
    <!-- Brand -->
    <div class="brand">
      <div class="brand-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
      </div>
      <h1>MédiRendez-vous</h1>
      <p>Connexion à votre espace patient</p>
    </div>

    <!-- Card -->
    <div class="card">
      <form id="login-form" method="POST" action="/login/login" novalidate>
        <?php if (!empty($authError)): ?>
          <div class="server-error" style="color: red; text-align: center;">
            <h4><?php echo htmlspecialchars($authError, ENT_QUOTES, 'UTF-8'); ?>
          </div>
          <br>
        <?php endif; ?>
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="votre.email@exemple.com"
            autocomplete="email"
            value="<?php echo isset($old['email']) ? htmlspecialchars($old['email'], ENT_QUOTES, 'UTF-8') : ''; ?>"
            class="<?php echo !empty($errors['email']) ? 'invalid' : ''; ?>"
          />
          <span class="error-msg <?php echo !empty($errors['email']) ? 'visible' : ''; ?>" id="email-error">
            <?php
              if (!empty($errors['email'])) {
                  echo htmlspecialchars($errors['email'][0], ENT_QUOTES, 'UTF-8');
              } else {
                  echo 'Veuillez saisir un email valide.';
              }
            ?>
          </span>
        </div>

        <div class="form-group">
          <label for="password">Mot de passe</label>
          <div class="input-wrap">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="••••••••"
              autocomplete="current-password"
              class="<?php echo !empty($errors['password']) ? 'invalid' : ''; ?>"
            />
            <button class="toggle-pw" id="toggle-pw" type="button" aria-label="Afficher le mot de passe">
              <!-- Eye icon -->
              <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          <span class="error-msg <?php echo !empty($errors['password']) ? 'visible' : ''; ?>" id="password-error">
            <?php
              if (!empty($errors['password'])) {
                  echo htmlspecialchars($errors['password'][0], ENT_QUOTES, 'UTF-8');
              } else {
                  echo 'Le mot de passe doit contenir au moins 6 caractères.';
              }
            ?>
          </span>
          <a href="#" class="forgot">Mot de passe oublié ?</a>
        </div>

        <button class="btn-submit" id="btn-login" type="submit">
          <span class="btn-text">Se connecter</span>
          <span class="spinner"></span>
        </button>

        <div class="divider"><span>ou</span></div>

        <div class="card-footer">
          <p>Pas encore de compte ? <a href="<?php echo WEB_ROOT; ?>/signup/index">Créer un compte</a></p>
        </div>
      </form>
    </div>
  </div>

  <div class="toast" id="toast"></div>

  <script src="<?php echo JS_ROOT; ?>/Login.js"></script>
</body>
</html>