<?php 
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Hvis feil med tilkoblig til databasen.
	exit('Mislyktes å koble til MySQL: ' . mysqli_connect_error());
} else {
    echo 'Vellykket tilkobling til MySQL!';
}

// Har form blitt sendt?
if (isset($_POST['username'], $_POST['password'])) {
    // Får ikke hentet data.
    exit('Vennligst fyll inn feltene for både brukernavn og passord.');
}

// Forbereder SQL-spørringene -> forhindrer SQL-injections.
if($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // s = string
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Lagre resultatet så kontoen kan sjekkes i databasen.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Konto eksisterer, verifiser passord.
        // NB: Husk password_hash i registreringsfila!
        if (password_verify($_POST['password'], $password)) {
            // Bruker er verifisert og har logget inn.
            // Lag 'sessions' for å vite at brukeren er logget inn.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            echo 'Velkommen tilabke, ' . htmlspecialchars($_SESSION['name'], ENT_QUOTES) . '!';
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