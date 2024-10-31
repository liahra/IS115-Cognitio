<?php
// Inkluderer nødvendige filer
require_once 'inc/db.inc.php';
require_once 'account.php';

$db = new Database();
$pdo = $db->getConnection();

// Sjekk om de nødvendige dataene fra skjemaet eksisterer i POST-forespørselen
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    exit('Vennligst fullfør registreringsformen.'); 
}

// Sjekk om de nødvendige feltene ikke er tomme
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    exit('Vennligst fullfør registreringsformen.'); 
}

// Valider at e-posten har et gyldig format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Ugyldig e-post.');
}

// Sjekk at brukernavnet kun inneholder bokstaver og tall
if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    exit('Ugyldig brukernavn.');
}

// Sjekk at passordene samsvarer
if ($_POST['password'] !== $_POST['confirm_password']) {
    exit('Passordene samsvarer ikke.');
}

// Sjekk at passordet er innenfor de spesifiserte grensene for lengde
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Passord må være mellom 5 og 20 tegn!');
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