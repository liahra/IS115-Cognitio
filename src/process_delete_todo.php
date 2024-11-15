<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once 'account.php';

$account = new Account();
$account->setId($_SESSION['user_id']);

$todoId = $_POST['id'];
echo $todoId;
/*
if ($account->updateTask($taskId)) {
    header('Location: ../public/home.php'); // Omdiriger til dashbordet ved suksess
    exit();
} else {
    echo "Det oppsto et problem med å slette gjøremålet. Vennligst prøv igjen.";
} */
?>