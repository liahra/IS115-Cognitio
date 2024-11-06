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
$todos = $account->getUnfinishedTodos(); // Henter gjøremål for den spesifikke brukeren
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
            <?php if (!empty($todos)): ?>
                <ul class="no-style">
                    <?php foreach ($todos as $todo) {
                        $value = htmlspecialchars($todo['value'], ENT_QUOTES);
                        $todo_id = htmlspecialchars($todo['id'], ENT_QUOTES);
                        include './inc/todo_item.php';
                    } ?>
                    <!-- <li>
                            <span><?= htmlspecialchars($todo['value'], ENT_QUOTES) ?></span><br>
                        </li> -->
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
        <form action="../src/add_todo.php" ; method="POST">
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
        <form action="">
            <h4>Slett gjøremål?</h4>
            <p>Er du sikker på at du vil slette dette gjøremålet?</p>
            <div>
                <button id="cancel_delete_todo">Avbryt</button>
                <button id="submit_delete_todo" type="submit">Slett</button>
            </div>
        </form>
    </dialog>

    <script>
        const add_todo = document.getElementById('add_todo');
        const add_todo_window = document.getElementById('add_todo_window');
        const cancel_add_todo = document.getElementById('cancel_add_todo');
        const delete_todo_window = document.getElementById('delete_todo_window');

        // Åpne et modalt vindu for å legge til nytt gjøremål
        add_todo.addEventListener("click", () => {
            add_todo_window.showModal();
        });

        // Lukk det modale vinduet for gjøremål uten å legge til nytt gjøremål
        cancel_add_todo.addEventListener("click", (e) => {
            e.preventDefault();
            add_todo_window.close();

        });

        // Hent inn alle slett-knappene til gjøremål
        const delete_buttons = document.querySelectorAll('[id^=todo_]');
        console.log(delete_buttons);
        // Legg på eventlistener på knappene for å kunne slette et gjøremål
        for(let delete_btn of delete_buttons){
            delete_btn.addEventListener("click", ()=>{
                // Hent id til gjøremålet (som korresponderer til id i databasen)
                const id = delete_btn.id.slice(5);
                // TODO:
                console.log("Send me to database to delete by opening a dialog to confirm or deny!");
                delete_todo_window.showModal(); 
            });
        }
    </script>
</body>

</html>