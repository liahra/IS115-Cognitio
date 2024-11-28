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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        h2 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            height: 80px;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        input[type="submit"],
        .delete-button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"] {
            background-color: #83BF73;
            color: white;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .delete-button {
            background-color: #ff4d4d;
            color: white;
        }
        .delete-button:hover {
            background-color: #ff1a1a;
        }
    </style>
    <script>
        // Bekreftelse før sletting
        function confirmDeletion() {
            return confirm("Er du sikker på at du vil slette denne oppgaven?");
        }
    </script>
</head>
<body>
    <h2>Rediger Oppgave</h2>
    <div class="form-container">
        <!-- Oppdateringsskjema -->
        <form action="../src/process_edit_task.php" method="post">
            <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id'], ENT_QUOTES) ?>">

            <label for="title">Tittel:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['title'], ENT_QUOTES) ?>" required>

            <label for="description">Beskrivelse:</label>
            <textarea id="description" name="description"><?= htmlspecialchars($task['description'], ENT_QUOTES) ?></textarea>

            <label for="due_date">Forfallsdato:</label>
            <input type="date" id="due_date" name="due_date" value="<?= htmlspecialchars($task['due_date'], ENT_QUOTES) ?>">

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="not-started" <?= $task['status'] === 'not-started' ? 'selected' : '' ?>>Ikke startet</option>
                <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pågående</option>
                <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Fullført</option>
            </select>

            <div class="button-group">
                <input type="submit" value="Oppdater oppgave">
                <!-- Sletteskjema -->
                <form action="../src/process_delete_task.php" method="POST" onsubmit="return confirmDeletion();" style="margin: 0;">
                    <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id'], ENT_QUOTES) ?>">
                    <button type="submit" class="delete-button">Slett oppgave</button>
                </form>
            </div>
        </form>
    </div>
</body>
</html>