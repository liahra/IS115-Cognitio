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
$taskId = $_GET['task_id'];
$task = $db->getTaskById($taskId, $account->getId());

if (!$task) {
    echo "Oppgaven ble ikke funnet.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="no">
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
            max-width: 700px;
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
        .time {
            width: 6ch;
        }
        textarea {
            resize: vertical;
            height: 600px;
        }
        .button-group {
            display: flex;
            gap: 20px;
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
            <input type="date" id="due_date" name="due_date" value="<?= htmlspecialchars(substr($task['due_date'], 0, 10), ENT_QUOTES) ?>">

            <label for="due_time">Klokkeslett:</label>
            <div>
                <select name="due_hour" id="due_hour" class="time">
                    <?php
                    $currentHour = (int)substr($task['due_date'], 11, 2); // Hent time fra datoen
                    for ($i = 0; $i < 24; $i++) {
                        $h = str_pad($i, 2, "0", STR_PAD_LEFT); // Legg til ledende null
                        echo "<option value=\"$h\"" . ($i === $currentHour ? " selected" : "") . ">$h</option>";
                    }
                    ?>
                </select> : 
                <select name="due_minute" id="due_minute" class="time">
                    <?php
                    $currentMinute = (int)substr($task['due_date'], 14, 2); // Hent minutt fra datoen
                    for ($i = 0; $i < 60; $i++) {
                        $m = str_pad($i, 2, "0", STR_PAD_LEFT); // Legg til ledende null
                        echo "<option value=\"$m\"" . ($i === $currentMinute ? " selected" : "") . ">$m</option>";
                    }
                    ?>
                </select>
            </div>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="not-started" <?= $task['status'] === 'not-started' ? 'selected' : '' ?>>Ikke startet</option>
                <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pågående</option>
                <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Fullført</option>
            </select>

            <div class="button-group">
                
                <!-- Sletteskjema -->
                <a href="../src/process_delete_task.php?task_id=<?= urlencode($task['id']) ?>" class="delete-button" style="text-decoration: none"; onclick="return confirm('Er du sikker på at du vil slette denne oppgaven?')">Slett oppgave</a>
                <input type="submit" value="Oppdater oppgave">
            </div>
        </form>
    </div>
</body>
</html>