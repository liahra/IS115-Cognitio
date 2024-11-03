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

// Opprett en instans av Account-klassen
$account = new Account();
$account->setId($_SESSION['user_id']); // Setter bruker-ID fra sesjonen
$tasks = $account->getUpcomingTasks(); // Henter oppgaver for den spesifikke brukeren
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cognitio - Dashboard</title>
    <link rel="stylesheet" href="./resources/css/style.css">
</head>

<body>
    <!-- Sidebar -->

    <?php
    // Tester inkludering med absolutt path
    include($_SERVER['DOCUMENT_ROOT'] . "/public/inc/sidebar.inc.php");
    ?>

    <!-- Main Content -->
    <div class="content">
    
        <section class="top-section">
            <h2>Dashboard</h2>
            <p>Velkommen tilbake, <?= htmlspecialchars($_SESSION['name'], ENT_QUOTES) ?>!</p>
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
                            <span>Forfallsdato: <?= htmlspecialchars($task['due_date'], ENT_QUOTES) ?></span>
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
        </section>
        
    </div>

    <dialog id="add_todo_window">
        <form action="../src/add_todo.php"; method="POST">
            <h4>Nytt gjøremål</h4>
            <input type="text" name="todovalue" > 
            <div>
                <button id="cancel_add_todo">Avbryt</button>
                <button id="submit_todo" type="submit">Legg til</button>
            </div>
        </form>
    </dialog>
    
    <script>
        const add_todo = document.getElementById('add_todo');
        const add_todo_tindow = document.getElementById('add_todo_window');
        const cancel_add_todo = document.getElementById('cancel_add_todo');

        // Open a modal dialog to add new task
        add_todo.addEventListener("click", ()=>{
            add_todo_tindow.showModal();
        });

        // Close the modal window without submitting a new item
        cancel_add_todo.addEventListener("click", (e)=>{
            e.preventDefault();
            add_todo_tindow.close();
            
        })
    </script>
</body>

</html>