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

$profileUrl = handleFileUpload($_FILES['image']);
if($account->addProfileUrl($profileUrl)){
    $_SESSION['account'] = serialize($account);
    header("Location: ../public/profile.php");
} else{
    $logger->logError("Kunne ikke legge til profilbilde.");
    header("Location: ../public/profile.php?error=profile_image");
}

?>