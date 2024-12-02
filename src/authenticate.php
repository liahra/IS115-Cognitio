<?php
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
        header('Location: ../public/index.php');
        exit();
    }

    try {
        $db->clearOldLoginAttempts($username);
        $failedAttempts = $db->getLoginAttempts($username, 60);

        if ($failedAttempts >= 3) {
            $_SESSION['error'] = "For mange mislykkede forsøk. Kontoen er låst i én time.";
            header('Location: ../public/index.php');
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
                header('Location: ../public/index.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Feil brukernavn eller passord.";
            header('Location: ../public/index.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "En feil oppstod. Prøv igjen senere.";
        header('Location: ../public/index.php');
        exit();
    }
}