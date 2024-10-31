<?php 
require_once '../../src/inc/db.inc.php';
require_once '../../src/account.php';

// Opprette ny instans av User-klassen
$user = new Account();

// Setter verdier
$user->setFirstName('Christine');
$user->setLastName('Nilsen');
$user->setUsername('chrnil');
$user->setEmail('chr@cn.com');
$user->setRole('student');
$user->setRegDate(date('Y-m-d')); // Setter dagens dato som registreringsdato

// Kaller createAccount-medoten for å lagre brukeren i databasen
$user->createAccount();
?>

