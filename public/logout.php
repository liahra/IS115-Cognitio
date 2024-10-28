<?php 
// Start bruker-session
session_start();
// Avslutt bruker-session
session_destroy();
// Send til loginn-side
header('Location: ../index.php');
?>

