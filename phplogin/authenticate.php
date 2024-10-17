<?php 
    session_start();
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'root';
    $DATABASE_NAME = 'phplogin';

    // Koble til databasen.
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
        // // Hvis feil.
        exit('Mislyktes å koble til MySQL: ' . mysqli_connect_error());
    } else {
        echo 'Vellykket tilkobling til MySQL!<br>';
    }

    // / Form sendt?
    if ( !isset($_POST['username'], $_POST['password']) ) {
        // Kan ikke hente data.
        exit('<br><b> Vennligst fyll inn feltene for både brukernavn og passord! </b>');
    }

    // Forbereder SQL-spørringene.
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bind parameter (s = string)
        $stmt->bind_param('s', $_POST['username']); // Brukerinput håndteres som data og ikke som en del av selve SQL-kommandoen.
        $stmt->execute();
        $stmt->store_result(); // Lagre resultatet.

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();

            // Konto eksisterer, verifiser passord.
            if ($_POST['password'] === $password) {
            // Bruker verifisert og logget inn.
            // Lag tilhørende bruker-sessions.
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                echo header('Location: home.php');
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