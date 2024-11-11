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

// Funksjon for å håndtere filopplasting
function handleFileUpload($file) {
    if (isset($file) && $file['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($file['name']);

        // Flytt den opplastede filen til ønsket mappe
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            return $uploadFile; // Returner filstien for lagring i databasen
        } else {
            echo "Det oppstod en feil under opplastningen.";
            return null;
        }
    }
    return null; // Returner null hvis ingen fil ble lastet opp
}

// Funksjon for å legge til oppgave
function addNewTask($account, $title, $course_code, $description, $due_date, $status, $materialUrl) {
    return $account->addTask($_SESSION['user_id'], $title, $course_code, $description, $due_date, $status, $materialUrl);
}

// Opprett en instans av Account-klassen og sett bruker-ID
$account = new Account();
$account->setId($_SESSION['user_id']); // Setter bruker-ID

// Hent oppgaveinformasjon fra skjema
$title = $_POST['title'];
$course_code = $_POST['course_code'];
$description = $_POST['description'];
$due_date = $_POST['due_date'];
$status = $_POST['status'];

// Håndter filopplastning og få filsti
$materialUrl = handleFileUpload($_FILES['material']);

// Legg til oppgave i databasen
if (addNewTask($account, $title, $course_code, $description, $due_date, $status, $materialUrl)) {
    header('Location: ../public/home.php'); // Omdirigerer til hjem-siden ved suksess
    exit();
} else {
    echo "Det oppsto et problem med å legge til oppgaven. Vennligst prøv igjen."; // Feilmelding ved mislykket forsøk
}
