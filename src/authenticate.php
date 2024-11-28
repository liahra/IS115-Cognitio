<?php
// Sjekk om skjemaet er sendt
if (!isset($_POST['username'], $_POST['password'])) {
    // Kan ikke hente data, returner til innlogging med feilmelding
    header('Location: login.php?error=empty_fields');
    exit();
}

session_start();
require_once 'inc/db.inc.php';
require_once 'account.php';

$db = new Database();
$pdo = $db->getConnection();

try {

    $user = $db->getUser($_POST['username']);
    if($user){
        // Verifiser passordet
        if (password_verify($_POST['password'], $user['password'])) {
            // Bruker verifisert, sett opp øktvariabler
            $_SESSION['loggedin'] = true;
            // Er dette en admin eller student?
            if($user['role'] === 'student'){
                $account = new Student();
            } else {
                $account = new Admin();
            }
            /*** Setter opp account-objectet med all informasjon om bruker, unntatt passord ***/
            $account->setId($user['id']);
            $account->setFirstName($user['fname']);
            $account->setLastName($user['lname']);
            $account->setUsername($user['username']);
            $account->setEmail($user['email']);
            // Lagre bruker-ID og account i session-variabelen
            $_SESSION['user_id'] = $user['id'];
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
