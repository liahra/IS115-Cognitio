<?php 
// DB-tilkobling
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
	exit('Mislyktes å koble til MySQL: ' . mysqli_connect_error());
}

// Eksisterer dataen?
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	exit('Vennligst fullfør registreringsformen.');
}

// Er verdier fylt ut?
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	exit('Vennligst fullfør registreringsformen.');
}

// Validering av input
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Ugyldig e-post.');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Ugyldig brukernavn.');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('Passord må være mellom 5 og 20 bokstaver!');
}

// Eksisterer brukernavnet?
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Lagre data for sjekk mot db.
	if ($stmt->num_rows > 0) {
		// Brukernavn eksisterer.
		echo 'Brukernavn eksisterer allerede. Velg et annet.';
	} else {
		// Brukernavn eksisterer ikke - legg til ny konto.
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
            echo 'Du er blitt registrert. Du kan nå logge inn!';
        } else {
            echo 'Kunne ikke hente spørring!';
        }
	}
	$stmt->close();
} else {
	echo 'Kunne ikke hente spørring!';
}
$con->close();
?>