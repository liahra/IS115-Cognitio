<?php 
    session_start();

    define ('DB_HOST', 'localhost');
    define ('DB_USER', 'root');
    define ('DB_PASS', 'root');
    define ('DB_NAME', 'phplogin');
    $dkn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

    try {
        $pdo = new PDO($dkn, DB_USER, DB_PASS);
        echo 'Tilkobling til databasen var vellykket! <br>';
    } catch (PDOExeption $e) {
        echo 'Feil ved tilkobling til databasen: ' . $e->getMessage();
    }

?>