<?php 
    session_start();
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'root';
    $DATABASE_NAME = 'phplogin';

    // Koble til databasen med angitt informasjon.
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
        // // Hvis feil med tilkoblig til databasen.
        exit('Mislyktes å koble til MySQL: ' . mysqli_connect_error());
    } else {
        echo 'Vellykket tilkobling til MySQL!<br>';
    }

    // / Har form blitt sendt?
    if ( !isset($_POST['username'], $_POST['password']) ) {
        // Could not get the data that should have been sent.
        exit('Please fill both the username and password fields!');
    }

    // Forbereder SQL-spørringene -> forhindrer SQL-injections.
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bind parameter (s = string)
        $stmt->bind_param('s', $_POST['username']); // Brukerinput håndteres som data og ikke som en del av selve SQL-kommandoen.
        $stmt->execute();
        $stmt->store_result(); // Lagre resultatet så kontoen kan sjekkes i databasen.

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();

            // Konto eksisterer, verifiser passord.
            if ($_POST['password'] === $password) {
            // Bruker er verifisert og har logget inn.
            // Lag 'sessions' for å vite at brukeren er logget inn.
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                echo 'Velkommmen tilbake, ' . htmlspecialchars($_SESSION['name'], ENT_QUOTES) . '!';
            } else {
                // Feil passord.
                echo 'Feil brukernavn og/eller passord!';
            }
        } else {
            // Feil brukernavn.
            echo 'Feil brukernavn og/eller passord!';
        }
        $stmt->close();
    }
?> 