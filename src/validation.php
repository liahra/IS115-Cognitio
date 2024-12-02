<?php
/* class Validation {
    private $errors = [];

    public function validateFormData(array $data): bool {
        // Sjekk for nødvendige felt
        if (!$this->requiredFieldsExist(['username', 'password', 'email'], $data)) {
            $this->errors[] = 'Vennligst fullfør registreringsformen.';
        }

        // Valider e-postformatet
        if (!empty($data['email']) && !$this->isValidEmail($data['email'])) {
            $this->errors[] = 'Ugyldig e-post.';
        }

        // Sjekk at brukernavnet kun inneholder bokstaver og tall
        if (!empty($data['username']) && !$this->isAlphanumeric($data['username'])) {
            $this->errors[] = 'Ugyldig brukernavn.';
        }

        // Sjekk at passordene samsvarer
        if (
            !empty($data['password']) && isset($data['confirm_password']) &&
            !$this->passwordsMatch($data['password'], $data['confirm_password'])
        ) {
            $this->errors[] = 'Passordene samsvarer ikke.';
        }

        // Sjekk at passordet er innenfor de spesifiserte grensene for lengde
        if (!empty($data['password']) && !$this->isPasswordLengthValid($data['password'])) {
            $this->errors[] = 'Passord må være mellom 5 og 20 tegn!';
        }

        // Returner true hvis det ikke er noen feil
        return empty($this->errors);
    }

    private function requiredFieldsExist(array $fields, array $data): bool {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return false;
            }
        }
        return true;
    }

    private function isValidEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isAlphanumeric(string $username): bool {
        return preg_match('/^[a-zA-Z0-9]+$/', $username);
    }

    private function passwordsMatch(string $password, string $confirmPassword): bool {
        return $password === $confirmPassword;
    }

    private function isPasswordLengthValid(string $password, int $min = 5, int $max = 20): bool {
        $length = strlen($password);
        return $length >= $min && $length <= $max;
    }

    public function getErrors(): array {
        return $this->errors;
    }
} */

class Validation {
    private $errors = [];

    public function validateFormData(array $data): bool {
        // Sanitering av data
        $data = $this->sanitizeInput($data);

        // Validering
        $this->validateRequiredFields(['username', 'password', 'email'], $data);
        $this->validateEmail($data['email'] ?? '');
        $this->validateUsername($data['username'] ?? '');
        $this->validatePassword($data['password'] ?? '', $data['confirm_password'] ?? '');

        // Returner true hvis ingen feil
        return empty($this->errors);
    }

    private function sanitizeInput(array $data): array {
        foreach ($data as $key => $value) {
            $data[$key] = trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
        }
        return $data;
    }

    private function validateRequiredFields(array $fields, array $data): void {
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $this->errors[] = ucfirst($field) . ' er et obligatorisk felt.';
            }
        }
    }

    private function validateEmail(string $email): void {
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Ugyldig e-postadresse.';
        }
    }

    private function validateUsername(string $username): void {
        if (!empty($username) && !preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            $this->errors[] = 'Brukernavnet kan kun inneholde bokstaver og tall.';
        }
    }

    private function validatePassword(string $password, string $confirmPassword): void {
        if (!empty($password)) {
            if (strlen($password) < 5 || strlen($password) > 20) {
                $this->errors[] = 'Passord må være mellom 5 og 20 tegn.';
            }
            if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
                $this->errors[] = 'Passord må inneholde minst én stor bokstav, én liten bokstav og ett tall.';
            }
            if ($password !== $confirmPassword) {
                $this->errors[] = 'Passordene samsvarer ikke.';
            }
        }
    }

    public function getErrors(): array {
        return $this->errors;
    }
}
