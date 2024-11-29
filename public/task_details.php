<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once '../src/account.php';
require_once '../src/inc/db.inc.php';

$account = unserialize($_SESSION['account']);
$db = new Database();

// Sjekk at 'task_id' er satt i URL
if (!isset($_GET['task_id']) || empty(trim($_GET['task_id']))) {
    echo "<p>Ingen oppgave valgt.</p>";
    exit;
}

// Hent 'task_id' fra URL
$taskId = htmlspecialchars($_GET['task_id'], ENT_QUOTES);

// Hent oppgaven fra databasen
$task = $db->getTaskById($taskId, $account->getId());

if ($task) {
    echo "<h1>" . htmlspecialchars($task['title'], ENT_QUOTES) . "</h1>";
    echo "<p><strong>Emne:</strong> " . htmlspecialchars($task['course_code'], ENT_QUOTES) . "</p>";
    echo "<p><strong>Forfallsdato:</strong> " . htmlspecialchars($task['due_date'], ENT_QUOTES) . "</p>";
    echo "<p><strong>Status:</strong> " . htmlspecialchars($task['status'], ENT_QUOTES) . "</p>";
} else {
    echo "<p>Oppgaven finnes ikke.</p>";
}
?>