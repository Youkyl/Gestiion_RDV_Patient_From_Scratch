<?php

namespace App\core;


class Validator
{
    private array $data;
    private array $rules = [];
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function getInstance(array $data): Validator
    {
        // NOTE: avoid a global singleton so each validation uses fresh input/errors.
        return new Validator($data);
    }

    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    public function passes(): bool
    {
        foreach ($this->rules as $field => $rules) {

            $value = $this->data[$field] ?? null;

            // nullable: if field is empty and not required, skip other rules
            if (in_array('nullable', $rules, true)
                && !in_array('required', $rules, true)
                && ($value === null || (is_string($value) && trim($value) === ''))) {
                continue;
            }

            foreach ($rules as $rule) {

                $param = null;

                // Callbacks only for closures, not for string rule names like "date"
                if ($rule instanceof \Closure) {
                    $result = $rule($field, $value, $this->data);
                    if ($result !== true) {
                        $this->addError($field, is_string($result) ? $result : "$field is invalid.");
                    }
                    continue;
                }

                if (strpos($rule, ':') !== false) {
                    [$rule, $param] = explode(':', $rule, 2);
                }

                $method = 'validate' . ucfirst($rule);

                if (method_exists($this, $method)) {
                    $this->$method($field, $value, $param);
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    /* ================= RULES ================= */

    private function validateRequired(string $field, $value): void
    {
        if ($value === null || (is_string($value) && trim($value) === '') || (is_array($value) && count($value) === 0)) {
            $this->addError($field, "$field est obligatoire.");
        }
    }

    private function validateEmail(string $field, $value): void
    {
        if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "$field doit être un email valide.");
        }
    }

    private function validateMin(string $field, $value, $param): void
    {
        if ($value === null) {
            return;
        }
        $len = is_string($value) ? mb_strlen($value) : (is_array($value) ? count($value) : null);
        if ($len !== null && $len < (int)$param) {
            $this->addError($field, "$field doit contenir au moins $param caractères.");
        }
    }

    private function validateMax(string $field, $value, $param): void
    {
        if ($value === null) {
            return;
        }
        $len = is_string($value) ? mb_strlen($value) : (is_array($value) ? count($value) : null);
        if ($len !== null && $len > (int)$param) {
            $this->addError($field, "$field doit contenir au maximum $param caractères.");
        }
    }

    private function validateNumeric(string $field, $value): void
    {
        if ($value !== null && $value !== '' && !is_numeric($value)) {
            $this->addError($field, "$field doit être numérique.");
        }
    }

    private function validateInteger(string $field, $value): void
    {
        if ($value !== null && $value !== '' && filter_var($value, FILTER_VALIDATE_INT) === false) {
            $this->addError($field, "$field doit être un entier.");
        }
    }

    private function validatePositive(string $field, $value): void
    {
        if ($value !== null && $value !== '' && is_numeric($value) && (float)$value < 0) {
            $this->addError($field, "$field doit être positif.");
        }
    }

    private function validateIn(string $field, $value, $param): void
    {
        if ($value === null || $value === '') {
            return;
        }
        $allowed = array_map('trim', explode(',', (string)$param));
        if (!in_array((string)$value, $allowed, true)) {
            $this->addError($field, "$field a une valeur invalide.");
        }
    }

    private function validateSame(string $field, $value, $param): void
    {
        if ($param === null || $param === '') {
            return;
        }
        $other = $this->data[$param] ?? null;
        if ($value !== $other) {
            $this->addError($field, "$field doit correspondre à $param.");
        }
    }

    private function validateConfirmed(string $field, $value, $param): void
    {
        $confirmationField = $param ?: ($field . '_confirmation');
        $other = $this->data[$confirmationField] ?? null;
        if ($value !== $other) {
            $this->addError($field, "$field ne correspond pas à la confirmation.");
        }
    }

    private function validateDate(string $field, $value): void
    {
        if ($value === null || $value === '') {
            return;
        }
        $ts = strtotime((string)$value);
        if ($ts === false) {
            $this->addError($field, "$field doit être une date valide.");
        }
    }

    private function validateBeforeToday(string $field, $value): void
    {
        if ($value === null || $value === '') {
            return;
        }
        $ts = strtotime((string)$value);
        if ($ts === false || $ts > time()) {
            $this->addError($field, "$field doit être une date antérieure à aujourd'hui.");
        }
    }

    private function validatePhone(string $field, $value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $raw    = (string)$value;
        $digits = preg_replace('/\D+/', '', $raw);

        if ($digits === null) {
            $this->addError($field, "$field doit être un numéro de téléphone valide.");
            return;
        }

        // Format Sénégal :
        // - national : 9 chiffres, commence par 7 (mobile) ou 3 (fixe)
        // - international : 221 + les 9 chiffres ci‑dessus (total 12 chiffres)
        if (!preg_match('/^(221)?(7[05678]\d{7}|3\d{8})$/', $digits)) {
            $this->addError($field, "$field doit être un numéro de téléphone sénégalais valide.");
            return;
        }

        // On limite aussi les caractères affichés autorisés
        if (!preg_match('/^[0-9+\s().-]+$/', $raw)) {
            $this->addError($field, "$field doit être un numéro de téléphone sénégalais valide.");
        }
    }

    private function validatePassword(string $field, $value, $param): void
    {
        if ($value === null || $value === '') {
            return;
        }
        $min = ($param !== null && $param !== '') ? (int)$param : 6;
        $v = (string)$value;
        if (mb_strlen($v) < $min) {
            $this->addError($field, "$field doit contenir au moins $min caractères.");
            return;
        }
        // Require at least one letter and one digit (simple baseline)
        if (!preg_match('/[A-Za-z]/', $v) || !preg_match('/\d/', $v)) {
            $this->addError($field, "$field doit contenir au moins une lettre et un chiffre.");
        }
    }

    private function validateEnum(string $field, $value, $param): void
    {
        if ($value === null || $value === '') {
            return;
        }
        if ($param === null || $param === '' || !enum_exists($param)) {
            // Misconfigured rule; don't block user input
            return;
        }
        foreach ($param::cases() as $case) {
            if ($case->name === (string)$value) {
                return;
            }
        }
        $this->addError($field, "$field a une valeur invalide.");
    }

    private function validateJson(string $field, $value): void
    {
        if ($value === null || $value === '') {
            return;
        }
        json_decode((string)$value, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->addError($field, "$field doit être un JSON valide.");
        }
    }

    /**
     * Règle legacy (d'un ancien projet). Gardée pour compatibilité si elle est encore utilisée.
     * Conseil: remplace-la par des règles adaptées (email, min, password, etc.).
     */
    private function validateAccType(string $field, $value): void
    {
        // No-op
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}
