<?php
    session_start();
    require_once '../src/account.php';
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