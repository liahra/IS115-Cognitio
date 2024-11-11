<?php
class Validation {
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
}
