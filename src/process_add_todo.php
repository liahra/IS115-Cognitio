<?php

session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Inkluder nødvendige filer
require_once 'account.php';
require_once './inc/logger.inc.php';

// Logging
$logger = new Logger();

// Opprett en instans av Account-klassen og sett bruker-ID
$account = unserialize($_SESSION['account']);


// Hent oppgaveinformasjon fra skjema
$value = $_POST['todovalue'];

// Ikke legg til en tom verdi
if ($value === "") {
    header("Location: /../public/home.php?todo=empty");
    exit();
} else {
    // Bruk addTodo-metoden til å legge til oppgaven
    if ($account->addTodo($value)) {
        header('Location: ../public/home.php?todo=success'); // Omdirigerer til hjem-siden ved suksess
        exit();
    } else {
        $logger->logError("Kunne ikke legge til gjøremål.");
        header('Location: ../public/home.php?todo=failed'); // Omdirigerer til hjem-siden ved suksess
        exit();
    }
}
