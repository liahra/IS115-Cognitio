<?php
session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

require_once '../src/account.php';

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location index.php');
    exit();
}

// Sjekk at account er satt i session
if (!isset($_SESSION['account'])) {
    echo '<p style="color: red;">Brukerdata kunne ikke lastes. Prøv å logge inn på nytt.</p>';
    exit();
}

// Hent account-objektet
$account = unserialize($_SESSION['account']);

// Sjekk om unserialize fungerer
if (!$account) {
    echo '<p style="color: red;">Feil med brukersession. Prøv å logge inn på nytt.</p>';
    exit();
}

$tasks = $account->getUpcomingTasks(); // Henter oppgaver for den spesifikke brukeren
$todos = $account->getUnfinishedTodos(); // Henter gjøremål for den spesifikke brukeren

require "../src/inc/utilities.inc.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cognitio - Dashboard</title>
    <link rel="stylesheet" href="./resources/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="./resources/css/home.css">

</head>


<body>
    <!-- Sidebar -->
    <?php
    $page = 'home';
    include("./inc/sidebar.inc.php");
    ?>

    <!-- Main Content -->
    <div class="content">
        <section class="top-section">
            <h2>Dashboard</h2>
        </section>

        <section class="task-section">
            <div class="task-container">
                <h2>Kommende innleveringer</h2>
                <?php
                // Begrens oppgavene til de fem nærmeste
                $upcomingTasks = array_slice($tasks, 0, 5);
                ?>
                <?php if (!empty($upcomingTasks)): ?>
                    <?php foreach ($upcomingTasks as $task): ?>
                        <div class="task-card">
                            <h3>
                                <a href="task_details.php?task_id=<?= urlencode($task['id']) ?>" class="task-link">
                                    📝 <?= htmlspecialchars($task['title'], ENT_QUOTES) ?>
                                </a>
                            </h3>
                            <!-- <?php echo isLate($task['due_date'], $task['status']) ? "<div class='late'>mangler</div>" : ""; ?> -->
                            <div class="task-details">
                                <div><strong>Emne</strong> <?= htmlspecialchars($task['course_code'], ENT_QUOTES) ?></div>
                                <span class="separator">|</span>
                                <div><strong>Forfall</strong> <?= htmlspecialchars(formatNorwegianDateTime($task['due_date']), ENT_QUOTES) ?></div>
                                <span class="separator">|</span>
                                <div class="task_status"><strong>Status</strong>&nbsp; <?= isLate($task['due_date'], $task['status']) ?  "<span class='late'>mangler</span>" : htmlspecialchars(getStatus($task['status']), ENT_QUOTES)  ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Ingen kommende innleveringer.</p>
                <?php endif; ?>

                <!-- Knappene nederst -->
                 <div class="bottombuttons">
                <form action="add_task.php" method="GET">
                    <input type="submit" class="add-task-button" value="Legg til ny oppgave">
                </form>
                <a href="./tasks.php">Se alle oppgaver</a>
                <form action="generate_pdf.php" method="get">
                    <button type="submit" class="add-task-button">Last ned PDF</button>
                </form>
                </div>
            </div>
        </section>

        <!-- Todo section -->
        <section class="task-section">
            <div class="task-container">
                <h2>Gjøremål</h2>

                <div>
                <?php if (!empty($todos)): ?>
                    <ul class="no-style">
                        <?php foreach ($todos as $todo) {
                            // Verdier som skal legges inn i dette todo-itemet
                            if($todo['value']){
                               $value = htmlspecialchars($todo['value'], ENT_QUOTES);
                                $todo_id = htmlspecialchars($todo['id'], ENT_QUOTES);
                                // Legg til todo-itemet
                                include './inc/todo_item.php'; 
                            }
                        } ?>
                        <?php //endforeach; 
                        ?>
                    </ul>
                <?php else: ?>
                    <p>Ingen kommende gjøremål.</p>
                <?php endif; ?>
                </div>
                <form action="../src/process_add_todo.php" method="post" class="todo_input_form">
                    <button type="submit" class="plussbutton">+</button>
                    <input type="text" placeholder="Legg til gjøremål" name="todovalue" class="todo_input">
                </form>
                
            </div>
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
            <form action="../src/process_delete_todo.php" , method="POST">
                <div>
                    <input type="hidden" name="id">
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