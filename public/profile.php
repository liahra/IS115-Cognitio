<?php
// Start bruker-session.
session_start();

// Er bruker innlogget?
if (!$_SESSION['loggedin']) {
	header('Location: ./index.php');
	exit;
}

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
                    <td>Fornavn:</td>
                    <td><?=htmlspecialchars($account->getFirstName() , ENT_QUOTES)?></td>
                </tr>
                <tr>
                    <td>Etternavn:</td>
                    <td><?=htmlspecialchars($account->getLastName() , ENT_QUOTES)?></td>
                </tr>
                <tr>
                    <td>Brukernavn:</td>
                    <td><?=htmlspecialchars($account->getUsername() , ENT_QUOTES)?></td>
                </tr>
                <tr>
                    <td>E-post:</td>
                    <td><?=htmlspecialchars($account->getEmail(), ENT_QUOTES)?></td>
                </tr>
            </table>
        </div>
    </div>   
    <script src="./resources/js/app.js"></script>  

</body>
</html>