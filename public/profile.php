<?php
// Start bruker-session.
session_start();

// Er bruker innlogget?
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

// Db-tilkobling
include_once '../src/inc/db.inc.php';

// Hent passord og epost fra db.
include_once '../src/inc/get_user_info.inc.php';

$user_info = get_user_info($con, $_SESSION['id']);
$password = $user_info('password');
$email = $user_info('email');
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