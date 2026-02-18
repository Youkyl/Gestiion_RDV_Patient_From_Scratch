
const form          = document.getElementById('login-form');
const emailInput    = document.getElementById('email');
const passwordInput = document.getElementById('password');
const emailError    = document.getElementById('email-error');
const passwordError = document.getElementById('password-error');
const btnLogin      = document.getElementById('btn-login');
const togglePw      = document.getElementById('toggle-pw');
const toast         = document.getElementById('toast');

// Toggle password visibility
togglePw.addEventListener('click', () => {
  const isHidden = passwordInput.type === 'password';
  passwordInput.type = isHidden ? 'text' : 'password';
  togglePw.innerHTML = isHidden
    ? `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
         <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
         <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
         <line x1="1" y1="1" x2="23" y2="23"/>
       </svg>`
    : `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
         <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
         <circle cx="12" cy="12" r="3"/>
       </svg>`;
});

// Validation helpers
const isValidEmail = v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);

function clearError(input, errorEl) {
  input.classList.remove('invalid');
  errorEl.classList.remove('visible');
}

emailInput.addEventListener('input', () => clearError(emailInput, emailError));
passwordInput.addEventListener('input', () => clearError(passwordInput, passwordError));

// Show toast
function showToast(msg, duration = 3000) {
  toast.textContent = msg;
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), duration);
}

// Validation + submit
form.addEventListener('submit', (e) => {
  let valid = true;

  if (!isValidEmail(emailInput.value.trim())) {
    emailInput.classList.add('invalid');
    emailError.classList.add('visible');
    valid = false;
  }

//   if (passwordInput.value.length < 6) {
//     passwordInput.classList.add('invalid');
//     passwordError.classList.add('visible');
//     valid = false;
//   }

  if (!valid) {
    e.preventDefault();
    return;
  }

  // Optionnel: petite animation de chargement
  btnLogin.classList.add('loading');
  btnLogin.disabled = true;
});