<?php
session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Inkluder nødvendige filer og sett opp klasser
require_once '../src/account.php';
require_once '../src/inc/db.inc.php';
require "../src/inc/utilities.inc.php";



$account = unserialize($_SESSION['account']);
$db = new Database();

// Gyldige sorteringsfelt og standard sorteringsretning
$validSortFields = ['title', 'description', 'course_code', 'due_date', 'status', 'material_url'];
$sortField = isset($_GET['sort']) && in_array($_GET['sort'], $validSortFields) ? $_GET['sort'] : 'due_date';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';
$nextOrder = $sortOrder === 'asc' ? 'desc' : 'asc'; // Bytter sorteringsretning

// Hent oppgavene sortert etter valgt felt og retning, ekskludert inaktive oppgaver
$tasks = $db->getActiveTasksByUserIdSorted($account->getId(), $sortField, $sortOrder);

// Funksjon for å vise sorteringsindikatoren
function getSortIcon($field, $currentSortField, $currentSortOrder) {
    if ($field === $currentSortField) {
        return $currentSortOrder === 'asc' ? '▲' : '▼';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dine Oppgaver</title>
    <link rel="stylesheet" href="./resources/css/style.css">
    <link rel="stylesheet" href="./resources/css/tasks.css">
</head>

<body>
    <?php

    $page = 'tasks';
    include("./inc/sidebar.inc.php");
    ?>

    <div class="content">
        <section class="top-section">
            <h2>Dine oppgaver</h2>
        </section>

        <?php if (!empty($tasks)): ?>
            <table>
                <thead>
                    <tr>
                        <th><a href="tasks.php?sort=title&order=<?= $nextOrder ?>">Tittel <span class="sort-icon"><?= getSortIcon('title', $sortField, $sortOrder) ?></span></a></th>
                        <th><a href="tasks.php?sort=course_code&order=<?= $nextOrder ?>">Emne <span class="sort-icon"><?= getSortIcon('course_code', $sortField, $sortOrder) ?></span></a></th>
                        <th><a href="tasks.php?sort=due_date&order=<?= $nextOrder ?>">Forfallsdato <span class="sort-icon"><?= getSortIcon('due_date', $sortField, $sortOrder) ?></span></a></th>
                        <th><a href="tasks.php?sort=status&order=<?= $nextOrder ?>">Status <span class="sort-icon"><?= getSortIcon('status', $sortField, $sortOrder) ?></span></a></th>
                        <th><a href="tasks.php?sort=material_url&order=<?= $nextOrder ?>">Kursmateriell <span class="sort-icon"><?= getSortIcon('material_url', $sortField, $sortOrder) ?></span></a></th>
                        <th>Handlinger</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($task['course_code'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars(formatNorwegianDateTime($task['due_date']), ENT_QUOTES) ?>
                            </td>
                            <td> <?=htmlspecialchars(getStatus($task['status']), ENT_QUOTES) ?></td>
                            <td>
                                <?php if (!empty($task['material_url'])): ?>
                                    <a href="<?= htmlspecialchars($task['material_url'], ENT_QUOTES) ?>" target="_blank">
                                        <?= htmlspecialchars(basename($task['material_url']), ENT_QUOTES) ?>
                                    </a>
                                <?php else: ?>
                                    Ingen materiell
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="task_details.php?task_id=<?= urlencode($task['id']) ?>">Vis</a>
                                <a href="edit_task.php?task_id=<?= urlencode($task['id']) ?>">Rediger</a>
                                <a href="../src/process_delete_task.php?task_id=<?= urlencode($task['id']) ?>" onclick="return confirm('Er du sikker på at du vil slette denne oppgaven?')">Slett</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Ingen oppgaver funnet.</p>
        <?php endif; ?>
    </div>
    <script src="./resources/js/app.js"></script>  

</body>

</html>