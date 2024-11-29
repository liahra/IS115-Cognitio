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

$account = unserialize($_SESSION['account']);

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
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
    font-family: "Open Sans", sans-serif;
    margin: 20px;
    background-color: #f5f5f5;
}

.task-section {
    display: flex;
    justify-content: left;
    margin-top: 20px;
}

.task-container {
    width: 90%;
    max-width: 800px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column; /* Sørger for at elementene legges oppå hverandre */
    gap: 10px; /* Avstand mellom oppgavene */
    height: auto; /* Dynamisk høyde */
}

.task-container h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: left;
    color: #333;
}

.task-card {
    padding-top: 10px;
    border-bottom: 1px solid #e0e0e0;
}

.task-card:last-child {
    border-bottom: none; /* Fjern linje for siste oppgave */
}

.task-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.task-icon {
    font-size: 20px;
    margin-right: 10px;
}

.task-card h3 {
    font-size: 18px;
    color: #333;
}

.task-card p {
    margin: 5px 0;
    font-size: 14px;
    color: #555;
}

.task-details {
    display: flex; 
    align-items: center; 
    gap: 20px; 
    font-size: 14px; 
    font-weight: 400; 
    padding-bottom: 18px;
}

.task-details .separator {
    margin: 0 10px; 
    font-weight: 300; 
}

.task-details div {
    font-size: 12px;
    font-weight: 300;
}

.task-link {
    text-decoration: none; /* Fjerner understrek */
    color: #007BFF; /* Farge for lenken */
    font-weight: bold; /* Gjør teksten tydeligere */
}

.task-link:hover {
    text-decoration: underline; /* Understrek ved hover */
    color: #0056b3; /* Mørkere farge ved hover */
}

input[type="submit"],
.add-task-button {
    background-color: #83BF73;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    display: block;
    text-align: center;
    margin-top:48px;
}

input[type="submit"]:hover,
.add-task-button:hover {
    background-color: #45a049;
}

/* Fjern det opprinnelige filopplastingsfeltet */
.file-input {
    display: none;
}

/* Style for tilpasset knapp */
.custom-file-upload {
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
    background-color: #83BF73;
    color: white;
    border-radius: 4px;
    font-weight: 100;
}

/* Style for visning av filnavnet */
.file-name {
    margin-left: 10px;
    font-style: italic;
    color: #555;
}
</style>

<body>
    <!-- Sidebar -->
    <?php
    $page = 'home';
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
                            <div class="task-details">
                                <div><strong>Emne:</strong> <?= htmlspecialchars($task['course_code'], ENT_QUOTES) ?></div>
                                <span class="separator">|</span>
                                <div><strong>Forfallsdato:</strong> <?= htmlspecialchars($task['due_date'], ENT_QUOTES) ?></div>
                                <span class="separator">|</span>
                                <div><strong>Status:</strong> <?= htmlspecialchars($task['status'], ENT_QUOTES) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Ingen kommende innleveringer.</p>
                <?php endif; ?>

                <!-- Knappen nederst -->
                <form action="add_task.php" method="GET">
                    <input type="submit" class="add-task-button" value="Legg til ny oppgave">
                </form>
            </div>
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