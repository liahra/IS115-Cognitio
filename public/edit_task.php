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

// Hent oppgave-ID fra URL
$taskId = $_GET['id'];
$task = $db->getTaskById($taskId, $account->getId());

if (!$task) {
    echo "Oppgaven ble ikke funnet.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rediger Oppgave</title>
</head>
<body>

<h2>Rediger Oppgave</h2>
<form action="../src/process_edit_task.php" method="post">
    <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
    
    <label for="title">Tittel:</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>

    <label for="description">Beskrivelse:</label>
    <textarea id="description" name="description"><?= htmlspecialchars($task['description']) ?></textarea>

    <label for="due_date">Forfallsdato:</label>
    <input type="date" id="due_date" name="due_date" value="<?= htmlspecialchars($task['due_date']) ?>">

    <label for="status">Status:</label>
    <select id="status" name="status">
        <option value="pending" <?= $task['status'] == 'pending' ? 'selected' : '' ?>>Pågående</option>
        <option value="not-started" <?= $task['status'] == 'not-started' ? 'selected' : '' ?>>Ikke startet</option>
        <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : '' ?>>Fullført</option>
    </select>

    <input type="submit" value="Oppdater Oppgave">
</form>

</body>
</html>