<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once 'account.php';
$account =unserialize($_SESSION['account']);

$todoId = $_POST['id'];


if ($account->deactivateTodo($todoId)) {
    header('Location: ../public/home.php'); // Omdiriger til dashbordet ved suksess
    exit();
} else {
    echo "Det oppsto et problem med å slette gjøremålet. Vennligst prøv igjen.";
}
?>