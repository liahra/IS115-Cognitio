<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
    
}

require_once 'account.php';
$account = unserialize($_SESSION['account']);

$todoId = $_POST['id'];
$updated_description = $_POST['updated_description'];


// Sjekk først om det faktisk har skjedd en oppdatering
if($_POST["original_description"] === $_POST["updated_description"]){
    header('Location: ../public/home.php'); // Omdiriger til dashbordet dersom ingenting er endret
    exit();
} else {
    if ($account->updateTodo($todoId, $updated_description)) {
        header('Location: ../public/home.php'); // Omdiriger til dashbordet ved suksess
        exit();
    } else {
        echo "Det oppsto et problem med å oppdatere gjøremålet. Vennligst prøv igjen.";
    }
}