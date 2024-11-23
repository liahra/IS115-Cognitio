<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once './account.php';
$account = unserialize($_SESSION['account']);

$taskId = $_POST['task_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$due_date = $_POST['due_date'];
$status = $_POST['status'];

if ($account->updateTask($taskId, $title, $description, $due_date, $status)) {
    header('Location: ../public/home.php'); // Omdiriger til dashbordet ved suksess
    exit();
} else {
    echo "Det oppsto et problem med å oppdatere oppgaven. Vennligst prøv igjen.";
}
?>