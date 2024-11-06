<?php
// Inkluderer nødvendige filer
require_once 'inc/db.inc.php'; // Fjern?
require_once 'account.php';
require_once 'validation.php';

$db = new Database();
$pdo = $db->getConnection();
$validator = new Validation();

if (!$validator->validateFormData($_POST)) {
    // Hent og vis alle feilmeldingene hvis noen valideringer feiler
    foreach ($validator->getErrors() as $error) {
        echo $error . '<br>';
    }
    exit();
}

// Opprett en ny instans av Account-klassen
$account = new Account();

try {
    // Sjekk om brukernavnet allerede finnes
    if ($account->usernameExists($_POST['username'])) {
        exit('Brukernavn eksisterer allerede. Velg et annet.');
    } else {
        // Sett brukerdetaljene i Account-instansen
        $account->setFirstName($_POST['fname']);
        $account->setLastName($_POST['lname']);
        $account->setUsername($_POST['username']);
        $account->setEmail($_POST['email']);
        $account->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT)); // Hashet passord
        $account->setRole('student'); // Setter standard rolle som 'student'
        $account->setRegDate(date('Y-m-d'));
        
        $account->createAccount();

        // Bekreft at registreringen var vellykket
        echo 'Du er blitt registrert. Du kan nå logge inn!';
        header('Location: ../public/login.php');
        exit();
    }

} catch (PDOException $e) {
    exit('Noe gikk galt: ' . $e->getMessage());
}