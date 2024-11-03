<?php
    session_start(); 
    require_once 'inc/db.inc.php';
    require_once 'account.php';
    
    $db = new Database();
    $pdo = $db->getConnection();

    // Sjekk om skjemaet er sendt
    if (!isset($_POST['username'], $_POST['password'])) {
        // Kan ikke hente data, returner til innlogging med feilmelding
        header('Location: login.php?error=empty_fields');
        exit();
    }

    try {
        // Forbered SQL-spørringen med en navngitt parameter
        $stmt = $pdo->prepare('SELECT id, password FROM accounts WHERE username = :username');
        
        // Bind parameter (bruker navngitte parametere)
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->execute(); // Utfør spørringen

        // Sjekk om brukernavnet eksisterer
        if ($stmt->rowCount() > 0) {
            // Hent brukerens id og passord
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifiser passordet
            if (password_verify($_POST['password'], $user['password'])) {
                // Bruker verifisert, sett opp øktvariabler
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user;
                
                // Omdiriger til hjemmesiden
                header('Location: ../public/home.php');
                exit();
            } else {
                // Feil passord, returner til innlogging
                header('Location: ../public/login.php?error=incorrect_password');
                exit();
            }
        } else {
            // Feil brukernavn, returner til innlogging
            header('Location: ../public/login.php?error=incorrect_username');
            exit();
        }

    } catch (PDOException $e) {
        // Håndter feil ved SQL-spørringen eller tilkobling
        header('Location: ../../phplogin/login.php?error=query_failed');
        exit();
    }
?>