<?php
session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Inkluder nødvendige filer
require_once 'inc/db.inc.php';
require_once 'account.php';

// Opprett en instans av Account-klassen og sett bruker-ID
$account = new Account();
$account->setId($_SESSION['user_id']); // Setter bruker-ID

// Hent oppgaveinformasjon fra skjema
$title = $_POST['title'];
$description = $_POST['description'];
$due_date = $_POST['due_date'];

// Bruk addTask-metoden til å legge til oppgaven
if ($account->addTask($_SESSION['user_id'], $title, $description, $due_date)) {
    header('Location: ../public/home.php'); // Omdirigerer til hjem-siden ved suksess
    exit();
} else {
    echo "Det oppsto et problem med å legge til oppgaven. Vennligst prøv igjen."; // Feilmelding ved mislykket forsøk
}