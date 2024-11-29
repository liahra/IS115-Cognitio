<?php
    session_start();
    require_once '../src/account.php';

    // Sjekk om innlogget OG admin-bruker
    $account = unserialize($_SESSION['account']);

    if(!($_SESSION['loggedin'] && $account->getRole() === 'admin')){
        header ('Location: home.php');
        exit();
    }

    // Hent alle studentbrukere
    $students = $account->getStudents();
    //print_r($students);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <link rel="stylesheet" href="./resources/css/admin_table.css">
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
        </section>
        <section>
            <h1>Studentbrukere</h1>
            <div><?php

                if(sizeof($students) === 0){
                    echo "<p>Ingen registrerte studenter.</p>";
                } else{
                    echo "<table>
                    <thead>
                        <tr>
                            <th >ID</th>
                            <th >Fornavn</th>
                            <th >Etternavn</th>
                            <th >E-post</th>
                            <th >Registreringsdato</th>
                        </tr>
                    </thead>
                    <tbody>";
                    foreach($students as $student){
                        include './inc/student_item.php';

                    }
                    echo "</tbody></table>";
                }

            ?></div>
        </section>
    
    </div>
    <script src="./resources/js/app.js"></script>  

</body>
</html>