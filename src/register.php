<?php
// Inkluderer nødvendige filer
require_once 'inc/db.inc.php';
require_once 'account.php';
require_once 'validation.php';

$db = new Database();
$validator = new Validation();

// Hent inputdata og sanitere
$inputData = [
    'fname' => filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING),
    'lname' => filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING),
    'username' => filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING),
    'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
    'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING),
    'confirm_password' => filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING),
];

// Validering
if (!$validator->validateFormData($inputData)) {
    foreach ($validator->getErrors() as $error) {
        echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '<br>';
    }
    exit();
}

// Opprett en ny instans av Account-klassen
$account = new Student();

try {
    // Sjekk om brukernavn eller e-post allerede finnes
    if ($db->usernameExists($inputData['username'])) {
        exit('Brukernavn eksisterer allerede. Velg et annet.');
    }

    if ($db->emailExists($inputData['email'])) {
        exit('E-post eksisterer allerede. Velg en annen.');
    }

    // Sett brukerdetaljene i Account-instansen
    $account->setFirstName($inputData['fname']);
    $account->setLastName($inputData['lname']);
    $account->setUsername($inputData['username']);
    $account->setEmail($inputData['email']);
    $account->setPassword(password_hash($inputData['password'], PASSWORD_DEFAULT)); // Hashet passord
    $account->setRegDate(date('Y-m-d'));

    // Opprett konto i databasen
    $db->createAccount($account);

    // Bekreft registrering
    header('Location: ../public/login.php');
    exit();
} catch (PDOException $e) {
    exit('Noe gikk galt. Prøv igjen senere.');
}
