
// ── STATE ──
let currentStep = 1;
const antecedents = [];

// ── ELEMENTS ──
const stepLabel   = document.getElementById('step-label');
const progressBar = document.getElementById('progress-bar');
const brandHeader = document.getElementById('brand-header');

// ── TOAST ──
function showToast(msg, duration = 3000) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), duration);
}

// ── PROGRESS ──
function updateProgress(step) {
  for (let i = 1; i <= 3; i++) {
    const seg = document.getElementById(`seg-${i}`);
    seg.classList.remove('active', 'done');
    if (i < step) seg.classList.add('done', 'active');
    else if (i === step) seg.classList.add('active');
  }
  stepLabel.textContent = `Étape ${step} sur 3`;
}

// ── NAVIGATE ──
function goToStep(next, direction = 'forward') {
  const current = document.getElementById(`step-${currentStep}`);
  const target  = document.getElementById(`step-${next}`);
  if (!target) return;
  current.classList.remove('active');
  target.classList.add('active');
  if (direction === 'back') {
    target.style.animationName = 'slideInBack';
  } else {
    target.style.animationName = 'slideIn';
  }
  currentStep = next;
  updateProgress(currentStep);
}

// ── VALIDATION HELPERS ──
const isEmail  = v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim());
const notEmpty = v => v.trim().length > 0;

function setError(inputEl, errorEl, msg) {
  inputEl.classList.add('invalid');
  inputEl.classList.remove('valid');
  if (errorEl) { errorEl.textContent = msg; errorEl.classList.add('visible'); }
}

function clearError(inputEl, errorEl) {
  inputEl.classList.remove('invalid');
  errorEl && errorEl.classList.remove('visible');
}

function setValid(inputEl) {
  inputEl.classList.remove('invalid');
  inputEl.classList.add('valid');
}

// ── LIVE CLEAR ──
['email','password','confirm-password','firstname','lastname','birthdate','phone','address']
  .forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', () => {
      el.classList.remove('invalid');
      const errEl = document.getElementById(`${id}-error`);
      if (errEl) errEl.classList.remove('visible');
    });
  });

// ── PASSWORD STRENGTH ──
const pwInput = document.getElementById('password');
pwInput.addEventListener('input', () => {
  const v = pwInput.value;
  let level = 0;
  if (v.length >= 6)  level = 1;
  if (v.length >= 8 && /[A-Z]/.test(v))  level = 2;
  if (level === 2 && /[0-9]/.test(v))     level = 3;
  if (level === 3 && /[^A-Za-z0-9]/.test(v)) level = 4;
  document.getElementById('pw-strength').setAttribute('data-level', level);
});

// ── TOGGLE PASSWORD ──
function makeToggle(btnId, inputId) {
  document.getElementById(btnId).addEventListener('click', () => {
    const inp = document.getElementById(inputId);
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    document.getElementById(btnId).innerHTML = show
      ? `<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
      : `<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
  });
}
makeToggle('toggle-pw1', 'password');
makeToggle('toggle-pw2', 'confirm-password');

// ── STEP 1 ──
document.getElementById('btn-step1').addEventListener('click', () => {
  const email = document.getElementById('email');
  const pass  = document.getElementById('password');
  const conf  = document.getElementById('confirm-password');
  let valid = true;

  if (!isEmail(email.value)) { setError(email, document.getElementById('email-error'), 'Veuillez saisir un email valide.'); valid = false; }
  else setValid(email);

  if (pass.value.length < 6) { setError(pass, document.getElementById('password-error'), 'Le mot de passe doit contenir au moins 6 caractères.'); valid = false; }
  else setValid(pass);

  if (conf.value !== pass.value || conf.value === '') { setError(conf, document.getElementById('confirm-error'), 'Les mots de passe ne correspondent pas.'); valid = false; }
  else setValid(conf);

  if (!valid) return;

  const btn = document.getElementById('btn-step1');
  btn.classList.add('loading');
  btn.disabled = true;
  setTimeout(() => {
    btn.classList.remove('loading');
    btn.disabled = false;
    goToStep(2);
  }, 600);
});

// ── STEP 2 ──
document.getElementById('btn-back2').addEventListener('click', () => goToStep(1, 'back'));

document.getElementById('btn-step2').addEventListener('click', () => {
  const fn = document.getElementById('firstname');
  const ln = document.getElementById('lastname');
  const bd = document.getElementById('birthdate');
  const ph = document.getElementById('phone');
  const ad = document.getElementById('address');
  let valid = true;

  if (!notEmpty(fn.value)) { setError(fn, document.getElementById('firstname-error'), 'Champ requis.'); valid = false; } else setValid(fn);
  if (!notEmpty(ln.value)) { setError(ln, document.getElementById('lastname-error'), 'Champ requis.'); valid = false; } else setValid(ln);
  if (!bd.value)           { setError(bd, document.getElementById('birthdate-error'), 'Veuillez saisir votre date de naissance.'); valid = false; } else setValid(bd);
  if (!notEmpty(ph.value)) { setError(ph, document.getElementById('phone-error'), 'Numéro invalide.'); valid = false; } else setValid(ph);
  if (!notEmpty(ad.value)) { setError(ad, document.getElementById('address-error'), 'Champ requis.'); valid = false; } else setValid(ad);

  if (!valid) return;

  const btn = document.getElementById('btn-step2');
  btn.classList.add('loading'); btn.disabled = true;
  setTimeout(() => {
    btn.classList.remove('loading'); btn.disabled = false;
    goToStep(3);
  }, 600);
});

// ── STEP 3 : antécédents ──
document.getElementById('btn-back3').addEventListener('click', () => goToStep(2, 'back'));

function renderAntecedents() {
  const list = document.getElementById('antecedent-list');
  const empty = document.getElementById('empty-state');
  list.innerHTML = '';
  if (antecedents.length === 0) {
    list.appendChild(empty);
    empty.style.display = '';
  } else {
    antecedents.forEach((item, i) => {
      const tag = document.createElement('span');
      tag.className = 'antecedent-tag';
      tag.innerHTML = `${item} <button aria-label="Supprimer ${item}">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>`;
      tag.querySelector('button').addEventListener('click', () => {
        antecedents.splice(i, 1);
        renderAntecedents();
      });
      list.appendChild(tag);
    });
  }
}
renderAntecedents();

function addAntecedent() {
  const inp = document.getElementById('antecedent-input');
  const val = inp.value.trim();
  if (!val) { inp.classList.add('invalid'); setTimeout(() => inp.classList.remove('invalid'), 1000); return; }
  if (antecedents.includes(val)) { showToast('Cet antécédent est déjà ajouté.'); return; }
  antecedents.push(val);
  inp.value = '';
  renderAntecedents();
}

document.getElementById('btn-add-antecedent').addEventListener('click', addAntecedent);
document.getElementById('antecedent-input').addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); addAntecedent(); } });

// ── SUBMIT (POST vers /signup/register) ──
const signupForm = document.getElementById('signup-form');
const medicalHistoryInput = document.getElementById('medicalHistory');

document.getElementById('btn-submit').addEventListener('click', (e) => {
  // On laisse la validation JS des étapes faire son travail.
  // Ici, on prépare juste les données pour le backend.
  e.preventDefault();

  // Met les antécédents dans le champ caché (simple chaîne jointe)
  if (medicalHistoryInput) {
    medicalHistoryInput.value = antecedents.join(', ');
  }

  const btn = document.getElementById('btn-submit');
  btn.classList.add('loading');
  btn.disabled = true;

  // Soumission réelle du formulaire vers signupController::register
  if (signupForm) {
    signupForm.submit();
  }
});

// ── ENTER KEY ──
document.addEventListener('keydown', e => {
  if (e.key !== 'Enter') return;
  const activeInput = document.activeElement;
  if (!activeInput || activeInput.tagName !== 'INPUT') return;
  if (currentStep === 1) document.getElementById('btn-step1').click();
  else if (currentStep === 2) document.getElementById('btn-step2').click();
});