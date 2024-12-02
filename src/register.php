<?php
// Inkluderer nødvendige filer
require_once 'inc/db.inc.php';
require_once 'account.php';
require_once 'validation.php';

$db = new Database();
$validator = new Validation();

// Hent inputdata og sanitere
$inputData = [
    'fname' => htmlspecialchars($_POST['fname'], ENT_QUOTES, 'UTF-8'),
    'lname' => htmlspecialchars($_POST['lname'], ENT_QUOTES, 'UTF-8'),
    'username' => htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'),
    'email' => htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'),
    'password' => htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'),
    'confirm_password' => htmlspecialchars($_POST['confirm_password'], ENT_QUOTES, 'UTF-8'),
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
    header('Location: ../public/index.php');
    exit();
} catch (PDOException $e) {
    exit('Noe gikk galt. Prøv igjen senere.');
}
