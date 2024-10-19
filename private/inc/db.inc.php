<?php 
    session_start();
    
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'root';
    $DATABASE_NAME = 'phplogin';

    // Koble til databasen.
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
        // // Hvis feil.
        exit('Mislyktes å koble til MySQL: ' . mysqli_connect_error());
    } else {
        echo 'Vellykket tilkobling til MySQL!<br>';
    }

    function get_db_info($con) {

    }
?>