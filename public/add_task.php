<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Legg til oppgave</title>
    <link rel="stylesheet" href="./resources/css/style.css">
</head>
<body>
    <h2>Legg til ny oppgave</h2>
    <form action="../src/process_add_task.php" method="post">
        <label for="title">Tittel:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="description">Beskrivelse:</label>
        <textarea id="description" name="description"></textarea>
        
        <label for="due_date">Forfallsdato:</label>
        <input type="date" id="due_date" name="due_date">
        
        <input type="submit" value="Legg til oppgave">
    </form>
</body>
</html>