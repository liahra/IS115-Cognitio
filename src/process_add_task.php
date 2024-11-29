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

$account =unserialize($_SESSION['account']);
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

/* // Opprett en instans av Account-klassen og sett bruker-ID
$account = unserialize($_SESSION['account']); */



// Hent oppgaveinformasjon fra skjema og håndter evt. manglende data
$title = isset($_POST['title']) ? $_POST['title'] : '';
$course_code = isset($_POST['course_code']) ? $_POST['course_code'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$due_date = isset($_POST['due_date']) ? $_POST['due_date'] : '';
$due_hour = isset($_POST['due_hour']) ? $_POST['due_hour'] : '';
$due_minute = isset($_POST['due_minute']) ? $_POST['due_minute'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : 'pending';

// Håndter filopplastning og få filsti
$materialUrl = handleFileUpload($_FILES['material']);
// Legg til oppgave i databasen
if ($account->addNewTask($title, $course_code, $description, $due_date . " " . $due_hour . ":" . $due_minute, $status, $materialUrl)) {
    header('Location: ../public/home.php'); // Omdirigerer til hjem-siden ved suksess
    exit();
} else {
    echo "Det oppsto et problem med å legge til oppgaven. Vennligst prøv igjen."; // Feilmelding ved mislykket forsøk
}
?>