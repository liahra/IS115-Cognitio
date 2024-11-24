<?php
    session_start();
    require_once '../src/account.php';

    // Sjekk om innlogget OG admin-bruker
    $account = unserialize($_SESSION['account']);

    if(!($_SESSION['loggedin'] && $account->getRole() === 'admin')){
        header ('Location: home.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>Document</title>
</head>
<body>
    <!-- Sidebar -->
    <?php
    $page = 'admin_panel';
    include("./inc/sidebar.inc.php");
    //phpinfo();
    ?>
    <div class="content">
        <section class="top-section">
                <h2>Admin Panel</h2><br />
                <p>Administrer brukere.</p>
        </section>
        <section>
            <h1>Registrerte studentbrukere</h1>
        </section>
    
    </div>
    
</body>
</html>