<?php
//dd($patient);
//dd($totalDemand);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MédiRendez-vous — Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo CSS_ROOT; ?>/home.css" />
</head>
<body>

  <!-- ── SIDEBAR ── -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-brand-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
      </div>
      <div class="sidebar-brand-text">
        <h2>MédiRendez-vous</h2>
        <p>Espace Patient</p>
      </div>
    </div>

    <nav class="sidebar-nav">
      <a href="<?php echo WEB_ROOT . '/'.$patient->getFirstname(); ?>" class="nav-item active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        <span>Accueil</span>
      </a>

      <a href="<?php echo WEB_ROOT .  '/' . $_SESSION['patient_firstname']; ?>/patient/profil" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        <span>Mon Profil</span>
      </a>

      <a href="#" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <span>Nouveau RDV</span>
      </a>

      <a href="#" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
        </svg>
        <span>Mes Demandes</span>
        <span class="nav-badge"><?php echo $totalDemand; ?></span>
      </a>

      <a href="#" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <span>RDV Validés</span>
        <span class="nav-badge green"><?php echo $totalApointment; ?></span>
      </a>
    </nav>
  </aside>

  <!-- ── MAIN ── -->
  <main class="main">
    <!-- Header -->
    <header class="header">
      <div class="header-user">
        <div class="header-user-info">
          <h3><?php echo $patient->getFirstname() . " " . strtoupper($patient->getLastname()); ?></h3>
          <p><?php echo $patient->getEmail(); ?></p>
        </div>
      </div>
      <button class="btn-disconnect" onclick="window.location.href='login/logout'">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        Déconnexion
      </button>
    </header>

    <!-- Content -->
    <div class="content">
      <!-- Welcome -->
      <div class="welcome">
        <h1>Bonjour, <?php echo $patient->getFirstname(); ?> !</h1>
        <p>Bienvenue sur votre espace de gestion des rendez-vous médicaux.</p>
      </div>

      <!-- Stats -->
      <div class="stats-grid">
        <div class="stat-card blue">
          <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <div class="stat-card-value"><?php echo $totalDemand; ?></div>
          <div class="stat-card-label">Total demandes</div>
          <div class="stat-card-desc">Toutes vos demandes</div>
        </div>

        <div class="stat-card green">
          <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <div class="stat-card-value"><?php echo $totalApointment; ?></div>
          <div class="stat-card-label">RDV validés</div>
          <div class="stat-card-desc">Confirmés par le médecin</div>
        </div>

        <div class="stat-card orange">
          <div class="stat-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
            </svg>
          </div>
          <div class="stat-card-value"><?php echo $totalWaitingApointment; ?></div>
          <div class="stat-card-label">En attente</div>
          <div class="stat-card-desc">En cours de validation</div>
        </div>
      </div>

      <!-- Actions -->
      <section class="section">
        <h2 class="section-title">Actions rapides</h2>
        <div class="actions-grid">
          <a href="#" class="action-card">
            <div class="action-card-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
            </div>
            <div class="action-card-text">
              <h3>Prendre un RDV</h3>
              <p>Créer une nouvelle demande</p>
            </div>
          </a>

          <a href="#" class="action-card">
            <div class="action-card-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
            </div>
            <div class="action-card-text">
              <h3>Mes RDV validés</h3>
              <p>Consulter vos rendez-vous</p>
            </div>
          </a>
        </div>
      </section>

      <!-- Upcoming appointments -->
      <section class="section">
        <h2 class="section-title">Prochains rendez-vous</h2>
        <div class="appointment-card">
          <div class="appointment-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <div class="appointment-info">
            <h3>Généraliste</h3>
            <p>mardi 10 février 2026 à 10:00</p>
          </div>
        </div>
      </section>

    </div><!-- /content -->
  </main>

</body>
</html>