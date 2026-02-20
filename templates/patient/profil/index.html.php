<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MédiRendez-vous — Mon Profil</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue: #2563eb;
      --blue-dark: #1d4ed8;
      --blue-bg: #f0f7ff;
      --green: #16a34a;
      --green-light: #dcfce7;
      --orange: #f97316;
      --red: #dc2626;
      --pink-light: #fff5f5;
      --bg: #f6f8fa;
      --card: #ffffff;
      --text-heading: #111827;
      --text-sub: #6b7280;
      --text-muted: #9ca3af;
      --border: #e5e7eb;
      --sidebar-bg: #fafbfc;
      --sidebar-active: #eff6ff;
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
      --shadow: 0 4px 20px rgba(0,0,0,0.06);
      --radius: 12px;
      --radius-lg: 16px;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text-heading);
      display: flex;
      min-height: 100vh;
    }

    /* ── SIDEBAR ── */
    .sidebar {
      width: 260px;
      background: var(--sidebar-bg);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      padding: 24px 0;
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }

    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0 24px 24px;
      border-bottom: 1px solid var(--border);
      margin-bottom: 24px;
    }

    .sidebar-brand-icon {
      width: 44px; height: 44px;
      background: var(--blue);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 4px 12px rgba(37,99,235,0.25);
    }

    .sidebar-brand-icon svg {
      width: 22px; height: 22px;
    }

    .sidebar-brand-text h2 {
      font-family: 'DM Serif Display', serif;
      font-size: 1.1rem;
      color: var(--text-heading);
      margin-bottom: 2px;
      letter-spacing: -0.3px;
    }

    .sidebar-brand-text p {
      font-size: 0.75rem;
      color: var(--text-muted);
      font-weight: 400;
    }

    /* Nav */
    .sidebar-nav {
      flex: 1;
      padding: 0 12px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 14px;
      margin-bottom: 4px;
      border-radius: 10px;
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--text-sub);
      text-decoration: none;
      transition: background 0.2s, color 0.2s;
      position: relative;
    }

    .nav-item svg {
      width: 18px; height: 18px;
      stroke-width: 2;
      flex-shrink: 0;
    }

    .nav-item:hover {
      background: #f3f4f6;
      color: var(--text-heading);
    }

    .nav-item.active {
      background: var(--sidebar-active);
      color: var(--blue);
      font-weight: 600;
    }

    .nav-item.active svg {
      stroke: var(--blue);
    }

    .nav-badge {
      margin-left: auto;
      background: var(--orange);
      color: #fff;
      font-size: 0.7rem;
      font-weight: 700;
      width: 20px; height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }

    .nav-badge.green {
      background: var(--green);
    }

    /* ── MAIN ── */
    .main {
      margin-left: 260px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    /* Header */
    .header {
      background: #fff;
      border-bottom: 1px solid var(--border);
      padding: 20px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 10;
      box-shadow: var(--shadow-sm);
    }

    .header-user {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .header-user-info {
      text-align: right;
    }

    .header-user-info h3 {
      font-size: 0.92rem;
      font-weight: 600;
      color: var(--text-heading);
    }

    .header-user-info p {
      font-size: 0.78rem;
      color: var(--text-muted);
    }

    .btn-disconnect {
      background: var(--red);
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s, transform 0.15s;
      box-shadow: 0 3px 12px rgba(220,38,38,0.25);
    }

    .btn-disconnect:hover {
      background: #b91c1c;
      transform: translateY(-1px);
    }

    .btn-disconnect svg {
      width: 15px; height: 15px;
    }

    /* Content */
    .content {
      flex: 1;
      padding: 36px 40px;
      max-width: 1200px;
      width: 100%;
    }

    .page-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 32px;
      animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
    }

    .page-header h1 {
      font-family: 'DM Serif Display', serif;
      font-size: 2rem;
      color: var(--text-heading);
      letter-spacing: -0.5px;
    }

    .btn-modify {
      background: var(--blue);
      color: #fff;
      border: none;
      padding: 11px 22px;
      border-radius: 8px;
      font-size: 0.88rem;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s, transform 0.15s;
      box-shadow: 0 3px 12px rgba(37,99,235,0.25);
      text-decoration: none;
    }

    .btn-modify:hover {
      background: var(--blue-dark);
      transform: translateY(-1px);
    }

    .btn-modify svg {
      width: 15px; height: 15px;
    }

    /* Section card */
    .section-card {
      background: var(--card);
      border-radius: var(--radius-lg);
      padding: 32px;
      box-shadow: var(--shadow);
      margin-bottom: 24px;
      animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
    }

    .section-card:nth-child(2) { animation-delay: 0.08s; }
    .section-card:nth-child(3) { animation-delay: 0.16s; }

    .section-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 24px;
      padding-bottom: 16px;
      border-bottom: 1px solid var(--border);
    }

    .section-header svg {
      width: 22px; height: 22px;
      stroke: var(--text-heading);
    }

    .section-header h2 {
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--text-heading);
    }

    /* Info grid */
    .info-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
    }

    .info-item {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .info-label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.82rem;
      font-weight: 500;
      color: var(--text-muted);
    }

    .info-label svg {
      width: 16px; height: 16px;
      stroke: var(--text-muted);
    }

    .info-value {
      font-size: 0.95rem;
      font-weight: 500;
      color: var(--text-heading);
      padding-left: 24px;
    }

    /* Medical history */
    .antecedent-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .antecedent-item {
      background: var(--pink-light);
      border: 1px solid #fee2e2;
      border-radius: 10px;
      padding: 16px 20px;
      font-size: 0.92rem;
      color: var(--text-heading);
      font-weight: 500;
      transition: transform 0.15s, box-shadow 0.2s;
    }

    .antecedent-item:hover {
      transform: translateX(4px);
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .empty-state {
      text-align: center;
      padding: 32px 20px;
      color: var(--text-muted);
      font-size: 0.9rem;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Modal */
    .modal {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      backdrop-filter: blur(4px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 100;
      padding: 20px;
    }

    .modal.open {
      display: flex;
      animation: fadeIn 0.25s;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }

    .modal-content {
      background: var(--card);
      border-radius: var(--radius-lg);
      padding: 32px;
      max-width: 600px;
      width: 100%;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      animation: slideUp 0.3s cubic-bezier(0.22,1,0.36,1);
    }

    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to   { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }

    .modal-header h2 {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--text-heading);
    }

    .btn-close {
      background: none;
      border: none;
      cursor: pointer;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      padding: 4px;
      transition: color 0.2s;
    }

    .btn-close:hover {
      color: var(--text-heading);
    }

    .form-group {
      margin-bottom: 18px;
    }

    label {
      display: block;
      font-size: 0.85rem;
      font-weight: 500;
      color: var(--text-heading);
      margin-bottom: 7px;
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="tel"] {
      width: 100%;
      padding: 12px 15px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.93rem;
      color: var(--text-heading);
      background: #fafafa;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
      outline: none;
    }

    input:focus {
      border-color: var(--blue);
      background: #fff;
      box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .btn-row {
      display: flex;
      gap: 12px;
      margin-top: 24px;
    }

    .btn-primary {
      flex: 1;
      padding: 13px;
      background: var(--blue);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s, transform 0.15s;
    }

    .btn-primary:hover {
      background: var(--blue-dark);
      transform: translateY(-1px);
    }

    .btn-secondary {
      flex: 1;
      padding: 13px;
      background: #e9ebee;
      color: #4b5563;
      border: none;
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s, transform 0.15s;
    }

    .btn-secondary:hover {
      background: #dde0e5;
      transform: translateY(-1px);
    }

    /* Toast */
    .toast {
      position: fixed;
      bottom: 28px;
      left: 50%;
      transform: translateX(-50%) translateY(80px);
      background: #111827;
      color: #fff;
      padding: 12px 24px;
      border-radius: 10px;
      font-size: 0.88rem;
      font-weight: 500;
      opacity: 0;
      transition: transform 0.4s cubic-bezier(0.22,1,0.36,1), opacity 0.4s;
      z-index: 200;
      white-space: nowrap;
    }

    .toast.show {
      transform: translateX(-50%) translateY(0);
      opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 80px;
        padding: 20px 0;
      }
      .sidebar-brand-text,
      .nav-item span,
      .nav-badge { display: none; }
      .nav-item { justify-content: center; padding: 12px; }
      .main { margin-left: 80px; }
      .header { padding: 16px 20px; }
      .content { padding: 24px 20px; }
      .info-grid,
      .form-row { grid-template-columns: 1fr; }
      .page-header { flex-direction: column; gap: 16px; align-items: flex-start; }
    }
  </style>
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
      <a href="<?php echo WEB_ROOT . '/'.$patient->getFirstname(); ?>" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        <span>Accueil</span>
      </a>

      <a href="<?php echo WEB_ROOT; ?>/patient/profil" class="nav-item active">
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
        <span class="nav-badge">1</span>
      </a>

      <a href="#" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <span>RDV Validés</span>
        <span class="nav-badge green">1</span>
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
      <button class="btn-disconnect" onclick="window.location.href='<?php echo WEB_ROOT; ?>/login/logout'">
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
      
      <div class="page-header">
        <h1>Mon Profil</h1>
        <button class="btn-modify" id="btn-edit">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
          Modifier
        </button>
      </div>

      <!-- Personal Info -->
      <div class="section-card">
        <div class="section-header">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
          <h2>Informations personnelles</h2>
        </div>

        <div class="info-grid">
          <div class="info-item">
            <div class="info-label">Prénom</div>
            <div class="info-value" id="display-firstname">Jean</div>
          </div>

          <div class="info-item">
            <div class="info-label">Nom</div>
            <div class="info-value" id="display-lastname">Dupont</div>
          </div>

          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
              </svg>
              Email
            </div>
            <div class="info-value" id="display-email">dsaa@s</div>
          </div>

          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
              </svg>
              Téléphone
            </div>
            <div class="info-value" id="display-phone">06 12 34 56 78</div>
          </div>

          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              Date de naissance
            </div>
            <div class="info-value" id="display-birthdate">15/05/1985</div>
          </div>

          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              Adresse
            </div>
            <div class="info-value" id="display-address">123 Rue de la Santé, 75013 Paris</div>
          </div>
        </div>
      </div>

      <!-- Medical History -->
      <div class="section-card">
        <div class="section-header">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
          <h2>Antécédents médicaux</h2>
        </div>

        <div class="antecedent-list" id="antecedent-list">
          <div class="antecedent-item">Hypertension</div>
          <div class="antecedent-item">Allergie aux arachides</div>
        </div>
      </div>

    </div><!-- /content -->
  </main>

  <!-- ── MODAL EDIT ── -->
  <div class="modal" id="modal-edit">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Modifier mon profil</h2>
        <button class="btn-close" id="btn-close-modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <form id="form-edit">
        <div class="form-row">
          <div class="form-group">
            <label for="edit-firstname">Prénom</label>
            <input type="text" id="edit-firstname" value="Jean" />
          </div>
          <div class="form-group">
            <label for="edit-lastname">Nom</label>
            <input type="text" id="edit-lastname" value="Dupont" />
          </div>
        </div>

        <div class="form-group">
          <label for="edit-email">Email</label>
          <input type="email" id="edit-email" value="dsaa@s" />
        </div>

        <div class="form-group">
          <label for="edit-phone">Téléphone</label>
          <input type="tel" id="edit-phone" value="06 12 34 56 78" />
        </div>

        <div class="form-group">
          <label for="edit-birthdate">Date de naissance</label>
          <input type="date" id="edit-birthdate" value="1985-05-15" />
        </div>

        <div class="form-group">
          <label for="edit-address">Adresse</label>
          <input type="text" id="edit-address" value="123 Rue de la Santé, 75013 Paris" />
        </div>

        <div class="btn-row">
          <button type="button" class="btn-secondary" id="btn-cancel">Annuler</button>
          <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>

  <div class="toast" id="toast"></div>

  <script>
    // Modal
    const modal = document.getElementById('modal-edit');
    const btnEdit = document.getElementById('btn-edit');
    const btnClose = document.getElementById('btn-close-modal');
    const btnCancel = document.getElementById('btn-cancel');

    btnEdit.addEventListener('click', () => modal.classList.add('open'));
    btnClose.addEventListener('click', () => modal.classList.remove('open'));
    btnCancel.addEventListener('click', () => modal.classList.remove('open'));
    modal.addEventListener('click', e => {
      if (e.target === modal) modal.classList.remove('open');
    });

    // Toast
    function showToast(msg) {
      const toast = document.getElementById('toast');
      toast.textContent = msg;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // Form submit
    document.getElementById('form-edit').addEventListener('submit', e => {
      e.preventDefault();

      // Get values
      const firstname = document.getElementById('edit-firstname').value;
      const lastname = document.getElementById('edit-lastname').value;
      const email = document.getElementById('edit-email').value;
      const phone = document.getElementById('edit-phone').value;
      const birthdate = document.getElementById('edit-birthdate').value;
      const address = document.getElementById('edit-address').value;

      // Update display
      document.getElementById('display-firstname').textContent = firstname;
      document.getElementById('display-lastname').textContent = lastname;
      document.getElementById('display-email').textContent = email;
      document.getElementById('display-phone').textContent = phone;
      
      // Format birthdate
      const [y, m, d] = birthdate.split('-');
      document.getElementById('display-birthdate').textContent = `${d}/${m}/${y}`;
      
      document.getElementById('display-address').textContent = address;

      // Close & toast
      modal.classList.remove('open');
      showToast('✓ Profil mis à jour avec succès !');
    });
  </script>
</body>
</html>