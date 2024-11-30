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

$logger = new Logger();

// Sjekk at bruker-ID er satt
if (!isset($_SESSION['user_id'])) {
    die("Bruker-ID mangler. Logg inn på nytt.");
}

// Forsøk å deserialisere brukerkonto fra økten
$account = unserialize($_SESSION['account']);

// Sjekk at $account er en gyldig instans
if (!$account || !($account instanceof Student)) {
    $logger->logError("Får ikke tak på kontoen ved sletting av gjøremål.");
    die("Kontoen kunne ikke hentes fra økten. Vennligst logg inn på nytt.");
}

// Sjekk om oppgave-ID er sendt
if (isset($_GET['task_id'])) {
    $taskId = $_GET['task_id'];

    // Valider at oppgave-ID er et gyldig tall
    if (!is_numeric($taskId)) {
        die("Ugyldig oppgave-ID. Vennligst prøv igjen.");
    }

    // Forsøk å deaktivere oppgaven
    if ($account->deactivateTask($taskId)) {
        header('Location: ../public/home.php'); // Omdiriger til dashbordet ved suksess
        exit();
    } else {
        $logger->logError("Klarte ikke deaktivere gjøremål.");
        echo "Det oppsto et problem med å slette oppgaven. Vennligst prøv igjen.";
    }
} else {
    $logger->logError("Ingen oppgave-ID mottatt ved deaktivering av oppgave.");
    echo "Ingen oppgave-ID mottatt. Vennligst prøv igjen.";
}
?>