<?php
// Start bruker-session.
session_start();

// Er bruker innlogget?
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

// Db-tilkobling
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
	exit('Mislyktes å koble til MySQL: ' . mysqli_connect_error());
}

// Hent passord og epost fra db.
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
// Hent brukerinfo fra ID
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Profil</title>
</head>
<body class="loggedin">
    <div class="navtop">
        <div>
            <h1>Cognitio</h1>
			<a href="profile.php"><i class="fas fa-user-circle"></i>Profil</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logg ut</a>
        </div>
    </div>
    <div class="content">
        <h2>Brukerprofil</h2>
        <p>Kontoinformasjon:</p>
        <div>
            <table>
                <tr>
                    <td>Brukernavn:</td>
                    <td><?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?></td>
                </tr>
                <tr>
                    <td>Passord:</td>
                    <td><?=htmlspecialchars($password, ENT_QUOTES)?></td>
                </tr>
                <tr>
                    <td>E-post:</td>
                    <td><?=htmlspecialchars($email, ENT_QUOTES)?></td>
                </tr>
            </table>
        </div>
    </div>   
</body>
</html>