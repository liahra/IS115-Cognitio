<?php
session_start();
require_once 'inc/db.inc.php';
require_once 'account.php';

$db = new Database();
$pdo = $db->getConnection();
$account = new Account();


// Sjekk om skjemaet er sendt
if (!isset($_POST['username'], $_POST['password'])) {
    // Kan ikke hente data, returner til innlogging med feilmelding
    header('Location: login.php?error=empty_fields');
    exit();
}

try {

    $user = $db->getUser($_POST['username']);
    if($user){
        // Verifiser passordet
        if (password_verify($_POST['password'], $user['password'])) {
            // Bruker verifisert, sett opp øktvariabler
            $_SESSION['loggedin'] = TRUE;

            /*** Setter opp account-objectet med all informasjon om bruker, unntatt passord ***/
            $account->setId($user['id']);
            $account->setFirstName($user['fname']);
            $account->setLastName($user['lname']);
            $account->setUsername($user['username']);
            $account->setEmail($user['email']);
            $account->setRole($user['role']);
            // Lagre account i session-variabelen
            $_SESSION['account'] = serialize($account);

            // Omdiriger til hjemmesiden
            header('Location: ../public/home.php');
            exit();
        } else {
            // Feil passord, returner til innlogging
            header('Location: ../public/login.php?error=incorrect_password');
            exit();
        }
    } else {
        // Kan ikke hente bruker, returner til innlogging med feilmelding
        header('Location: login.php?error=user_not_found');
        exit();
    }

} catch (PDOException $e) {
    // Håndter feil ved SQL-spørringen eller tilkobling
    header('Location: ../../phplogin/login.php?error=query_failed');
    exit();
}
