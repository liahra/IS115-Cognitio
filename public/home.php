<?php
session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Inkluder nødvendige filer og sett opp klasser
/* require_once '../src/inc/db.inc.php';  // Har lagt denne inn i account-klassen */
require_once '../src/account.php';
require_once '../src/inc/db.inc.php';

$db = new Database();

// Opprett en instans av Account-klassen
//$account = new Account();
$account = unserialize($_SESSION['account']);
//$account->setId($_SESSION['user_id']); // Setter bruker-ID fra sesjonen
$tasks = $db->getUpcomingTasks($account->getId()); // Henter oppgaver for den spesifikke brukeren
$todos = $db->getUnfinishedTodos($account->getId()); // Henter gjøremål for den spesifikke brukeren
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cognitio - Dashboard</title>
    <link rel="stylesheet" href="./resources/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body>
    <!-- Sidebar -->
    <?php
    // Tester inkludering med absolutt path
    include("./inc/sidebar.inc.php");
    //phpinfo();
    ?>

    <!-- Main Content -->
    <div class="content">
        <section class="top-section">
            <h2>Dashboard</h2><br />
            <br />
            <p>Velkommen tilbake, <?= htmlspecialchars($account->getFirstName(), ENT_QUOTES)?><?= $account->getRole()==="admin" ? "<sup>*</sup>" : "" ?>!</p><br /><br />
        </section>

        <!-- Assignments section -->
        <section>
            <button onclick="window.location.href='add_task.php'">Legg til ny oppgave</button>

            <h3>Kommende oppgaver</h3>
            <?php if (!empty($tasks)): ?>
                <ul>
                    <?php foreach ($tasks as $task): ?>
                        <li>
                            <strong><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></strong><br>
                            <span>Beskrivelse: <?= htmlspecialchars($task['description'], ENT_QUOTES) ?></span><br>
                            <span>Forfallsdato: <?= htmlspecialchars($task['due_date'], ENT_QUOTES) ?></span><br>

                            <!-- Rediger-knapp -->
                            <a href="edit_task.php?id=<?= $task['id'] ?>" class="edit-button">Rediger</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Ingen kommende oppgaver.</p>
            <?php endif; ?>
        </section>
        <!-- Todo section -->
        <section>
            <button id="add_todo">Legg til gjøremål</button>
            <h3>Gjøremål</h3>
            <?php if (!empty($todos)): ?>
                <ul class="no-style">
                    <?php foreach ($todos as $todo) {
                        // Verdier som skal legges inn i dette todo-itemet
                        $value = htmlspecialchars($todo['value'], ENT_QUOTES);
                        $todo_id = htmlspecialchars($todo['id'], ENT_QUOTES);
                        // Legg til todo-itemet
                        include './inc/todo_item.php';
                    } ?>
                    <?php //endforeach; 
                    ?>
                </ul>
            <?php else: ?>
                <p>Ingen kommende gjøremål.</p>
            <?php endif; ?>
        </section>

    </div>

    <!-- Vindu for å legge til gjøremål -->
    <dialog id="add_todo_window">
        <form action="../src/process_add_todo.php" ; method="POST">
            <h4>Nytt gjøremål</h4>
            <input type="text" name="todovalue">
            <div>
                <button id="cancel_add_todo">Avbryt</button>
                <button id="submit_todo" type="submit">Legg til</button>
            </div>
        </form>
    </dialog>

    <!-- Vindu for å bekrefte sletting av gjøremål -->
    <dialog id="delete_todo_window">
        <div>
            <h4>Slett gjøremål?</h4>
            <p>Er du sikker på at du vil slette dette gjøremålet?</p>
            <form action="../src/process_delete_todo.php", method="POST">
                <div>
                    <input type="hidden" name="id" >
                    <button id="cancel_delete_todo">Avbryt</button>
                    <button id="submit_delete_todo" type="submit">Slett</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Vindu for å redigere gjøremål -->
     <dialog id="update_todo_window">
        <div>
            <h4>Oppdater gjøremål</h4>
            <form action="../src/process_update_todo.php" method="post">
                <input type="hidden" name="id">
                <input type="hidden" name="original_description">
                <input type="text" name="updated_description" id="update_todo_content">
                <div>
                    <button id="cancel_update_todo">Avbryt</button>
                    <button id="submit_update_todo" type="submit">Oppdater</button>
                </div>
            </form>
        </div>
     </dialog>



    <script src="./resources/js/app.js"></script>
</body>

</html>