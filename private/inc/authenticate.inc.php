<?php
    session_start();
    include 'db.inc.php';
    
    // Sjekk om skjemaet er sendt
    if (!isset($_POST['username'], $_POST['password'])) {

        // Kan ikke hente data, returner til innlogging med feilmelding
        header('Location: login.php?error=empty_fields');
        exit();
    }

    // Forbereder SQL-spørringene
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bind parameter (s = string)
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result(); // Lagre resultatet

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();

            // Konto eksisterer, verifiser passord
            if (password_verify($_POST['password'], $password)) {
                // Bruker verifisert og logget inn, lag session
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                header('Location: ../../phplogin/home.php');
                exit();
            } else {
                // Feil passord, returner til innlogging
                header('Location: ../../phplogin/login.php?error=incorrect_password');
                exit();
            }
        } else {
            // Feil brukernavn, returner til innlogging
            header('Location: ../../phplogin/login.php?error=incorrect_username');
            exit();
        }
        $stmt->close();
    } else {
        // Hvis spørringen mislykkes, returner en generell feilmelding
        header('Location: ../../phplogin/login.php?error=query_failed');
        exit();
    }
?> 