<?php
/* // Sjekk om skjemaet er sendt
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
             Setter opp account-objectet med all informasjon om bruker, unntatt passord
            $account->setId($user['id']);
            $account->setFirstName($user['fname']);
            $account->setLastName($user['lname']);
            $account->setUsername($user['username']);
            $account->setEmail($user['email']);
            $account->setProfileUrl($user['profileUrl']);
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
} */

session_start();
require_once 'inc/db.inc.php';
require_once 'account.php';

$db = new Database();
$pdo = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Brukernavn og passord må fylles ut.";
        header('Location: ../public/login.php');
        exit();
    }

    try {
        $db->clearOldLoginAttempts($username);
        $failedAttempts = $db->getLoginAttempts($username, 60);

        if ($failedAttempts >= 3) {
            $_SESSION['error'] = "For mange mislykkede forsøk. Kontoen er låst i én time.";
            header('Location: ../public/login.php');
            exit();
        }

        $user = $db->getUser($username);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $db->clearOldLoginAttempts($username);

                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'student') {
                    $account = new Student();
                } else {
                    $account = new Admin();
                }

                $account->setId($user['id']);
                $account->setFirstName($user['fname']);
                $account->setLastName($user['lname']);
                $account->setUsername($user['username']);
                $account->setEmail($user['email']);
                $account->setProfileUrl($user['profileUrl']);

                $_SESSION['account'] = serialize($account);

                header('Location: ../public/home.php');
                exit();
            } else {
                $db->logLoginAttempt($username);
                $_SESSION['error'] = "Feil brukernavn eller passord.";
                header('Location: ../public/login.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Feil brukernavn eller passord.";
            header('Location: ../public/login.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "En feil oppstod. Prøv igjen senere.";
        header('Location: ../public/login.php');
        exit();
    }
}