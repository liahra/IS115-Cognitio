<?php
// Start bruker-session.
session_start();

// Er bruker innlogget?
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

/* // Db-tilkobling
include_once '../src/inc/db.inc.php';

// Hent passord og epost fra db.
include_once '../src/inc/get_user_info.inc.php';

$user_info = get_user_info($pdo, $_SESSION['id']);
$password = $user_info['password'];
$email = $user_info['email']; */

require_once '../src/account.php';
$account = unserialize($_SESSION['account']);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>Profil</title>
</head>
<body>
     <!-- Sidebar -->
     <?php
    $page = 'profile';
    include("./inc/sidebar.inc.php");
    //phpinfo();
    ?>
    <div class="content">
        <section class="top-section">
                <h2>Brukerprofil</h2><br />
                <p>Kontoinformasjon</p>
        </section>
        <div>
            <table>
                <tr>
                    <td>Brukernavn:</td>
                    <td><?=htmlspecialchars($account->getUsername() , ENT_QUOTES)?></td>
                </tr>
              <!--   <tr>
                    <td>Passord:</td>
                    <td><?=htmlspecialchars($password, ENT_QUOTES)?></td>
                </tr> -->
                <tr>
                    <td>E-post:</td>
                    <td><?=htmlspecialchars($account->getEmail(), ENT_QUOTES)?></td>
                </tr>
            </table>
        </div>
    </div>   
</body>
</html>