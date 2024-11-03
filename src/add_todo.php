<?php

session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Inkluder nødvendige filer

require_once 'account.php';

// Opprett en instans av Account-klassen og sett bruker-ID
$account = new Account();
$account->setId($_SESSION['user_id']); // Setter bruker-ID

// Hent oppgaveinformasjon fra skjema
$value = $_POST['todovalue'];

// Ikke legg til en tom verdi
if ($value === "") {
    header("Location: /../public/home.php?todo=empty");
    exit();
} else {
    print_r($_POST);
    // Bruk addTodo-metoden til å legge til oppgaven
    if ($account->addTodo($_SESSION['user_id'], $value)) {
        header('Location: ../public/home.php?todo=success'); // Omdirigerer til hjem-siden ved suksess
        exit();
    } else {
        //echo "Det oppsto et problem med å legge til oppgaven. Vennligst prøv igjen."; // Feilmelding ved mislykket forsøk
        header('Location: ../public/home.php?todo=failed'); // Omdirigerer til hjem-siden ved suksess
        exit();
    }
}
