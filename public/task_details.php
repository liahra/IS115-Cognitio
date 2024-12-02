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

// Håndter filnedlasting
if (isset($_GET['download']) && !empty($_GET['download'])) {
    $filePath = '../src/uploads/' . basename($_GET['download']);
    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        readfile($filePath);
        exit;
    } else {
        echo "<p>Filen finnes ikke.</p>";
        exit;
    }
}

// Sjekk at 'task_id' er satt i URL
if (!isset($_GET['task_id']) || empty(trim($_GET['task_id']))) {
    echo "<p>Ingen oppgave valgt.</p>";
    exit;
}

// Hent 'task_id' fra URL
$taskId = htmlspecialchars($_GET['task_id'], ENT_QUOTES);

// Hent oppgaven fra databasen
$task = $db->getTaskById($taskId, $account->getId());

if (!$task) {
    echo "<p>Oppgaven finnes ikke.</p>";
    exit;
}

// Funksjon for å konvertere status til norsk
function translateStatus($status) {
    $statusTranslations = [
        'not-started' => 'Ikke startet',
        'pending' => 'Pågår',
        'completed' => 'Fullført'
    ];
    return $statusTranslations[$status] ?? $status;
}

// Funksjon for å formatere dato og tid på norsk
require('../src/inc/utilities.inc.php');
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oppgavedetaljer</title>
    <link rel="stylesheet" href="./resources/css/style.css">
    <link rel="stylesheet" href="./resources/css/task_details.css">
</head>
<body>
    <?php 
        $page = 'home';
        include("./inc/sidebar.inc.php");?>
   <div class="task-details-container">
        <h1><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></h1>
        <div class="task-meta">
            <p><strong>Emne </strong> <?= htmlspecialchars($task['course_code'], ENT_QUOTES) ?></p>
            <p><strong>Forfallsdato </strong> <?= formatNorwegianDateTime($task['due_date']) ?></p>
            <p><strong>Status </strong> <?= translateStatus($task['status']) ?></p>
        </div>
        
        <?php if (!empty($task['material_url'])): ?>
            <p><strong>Fil:</strong> 
                <a href="task_details.php?task_id=<?= urlencode($taskId) ?>&download=<?= urlencode($task['material_url']) ?>" class="file-link">
                    <?= htmlspecialchars(basename($task['material_url']), ENT_QUOTES) ?>
                </a>
            </p>
        <?php else: ?>
            <p><strong>Fil:</strong> Ingen filer lastet opp</p>
        <?php endif; ?>

        <p><strong>Beskrivelse:</strong><br><?= nl2br(htmlspecialchars($task['description'], ENT_QUOTES)) ?></p>
        
        <a href="edit_task.php?task_id=<?= urlencode($taskId) ?>" class="edit-task-button">Rediger Oppgave</a>
    </div>
</body>
</html>