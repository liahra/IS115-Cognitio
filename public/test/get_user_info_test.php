<?php
// Inkluder databaseforbindelsen
require_once '../../private/inc/db.inc.php';

function get_user_info($pdo, $user_id) {
    // Forbered en SQL-forespørsel
    $stmt = $pdo->prepare('SELECT password, email FROM accounts WHERE id = :id');
    
    // Bind verdien for user_id
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    
    // Utfør spørringen
    $stmt->execute();
    
    // Hent resultatet som en assosiativ array
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Returner brukerinformasjon hvis funnet, ellers returner null
    return $user_info ? $user_info : null;
}

// Test koden ved å hente informasjon om en bruker
$user_id = 1; // Bruk id-en til en eksisterende bruker
$user_info = get_user_info($pdo, $user_id);

// Sjekk om brukerinformasjonen ble hentet og skriv ut resultatet
if ($user_info) {
    echo 'Passord: ' . $user_info['password'] . '<br>';
    echo 'E-post: ' . $user_info['email'] . '<br>';
} else {
    echo 'Ingen bruker funnet med ID ' . $user_id;
}
?>

