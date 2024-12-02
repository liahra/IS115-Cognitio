<?php
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
            /* echo $data[$field] . "<br> "; */
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
