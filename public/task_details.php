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
function formatNorwegianDateTime($dateTimeString) {
    $dateTime = date_create($dateTimeString);
    $norwegianMonths = [
        'jan.', 'feb.', 'mars', 'apr.', 'mai', 'juni',
        'juli', 'aug.', 'sep.', 'okt.', 'nov.', 'des.'
    ];
    $day = date_format($dateTime, 'j');
    $monthIndex = (int)date_format($dateTime, 'n') - 1;
    $year = date_format($dateTime, 'Y');
    $time = date_format($dateTime, 'H:i');
    return "$day. {$norwegianMonths[$monthIndex]} $year kl. $time";
}
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oppgavedetaljer</title>
    <link rel="stylesheet" href="./resources/css/style.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        .task-details-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 100px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
        }

        .task-details-container h1 {
            font-size: 24px;
            color: #333;
        }

        .task-details-container p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .task-details-container p strong {
            color: #333;
        }

        .task-details-container .file-link {
            display: inline-block;
            margin: 10px 0;
            color: #45a049;
            text-decoration: none;
            font-size: 15px;
        }

        .task-details-container .file-link:hover {
            text-decoration: underline;
        }

        .task-meta {
            display: flex; /* Plasserer elementene ved siden av hverandre */
            /* justify-content: space-between; /* Jevn fordeling av plass */
            gap: 40px; /* Avstand mellom elementene */
            margin: 20px 0; /* Litt mellomrom rundt seksjonen */
        }

        .task-meta p {
            margin: 0;
            font-size: 15px;
            color: #555;
        }

        .task-meta p strong {
            color: #333;
        }

        .edit-task-button {
            display: inline-block;
            background-color: #83BF73;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
        }

        .edit-task-button:hover {
            background-color: #45a049;
        }
    </style>
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
                <a href="<?= htmlspecialchars($task['material_url'], ENT_QUOTES) ?>" class="file-link" target="_blank">
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