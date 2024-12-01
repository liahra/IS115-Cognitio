<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Legg til oppgave</title>
    <link rel="stylesheet" href="./resources/css/add_task.css   ">
</head>
<body>
    <h2>Legg til ny oppgave</h2>
    <form action="../src/process_add_task.php" method="post" enctype="multipart/form-data">
        <label for="title">Tittel:</label>
        <input type="text" id="title" name="title" placeholder="Skriv inn tittelen" required>

        <label for="course_code">Emnekode:</label>
        <input type="text" id="course_code" name="course_code" placeholder="Skriv inn emnekode" required>

        <label for="description">Beskrivelse:</label>
        <textarea id="description" name="description" placeholder="Skriv inn beskrivelse"></textarea>

        <label for="due_date">Forfallsdato:</label>
        <input type="date" id="due_date" name="due_date" required>

        <label for="due_time">Klokkeslett:</label>
        <div>
        <select name="due_hour" id="due_hour" class="time">
            <?php 
                for($i = 0; $i < 24; $i++){
                    if($i < 10){
                        $h = "0" . $i;
                    } else {
                        $h = $i;
                    }
                   echo  "<option value=\"$h\">$h</option>";
                }
            ?>
        </select> : 
        <select name="due_minute" id="due_minute" class="time">
            <?php 
                for($i = 0; $i < 60; $i++){
                    if($i < 10){
                        $m = "0" . $i;
                    } else {
                        $m = $i;
                    }
                   echo  "<option value=\"$m\">$m</option>";
                }
            ?>
        </select>
        </div>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="">Velg status</option>
            <option value="not-started">Ikke startet</option>
            <option value="pending">Pågående</option>
            <option value="completed">Fullført</option>
        </select>

        <label for="material">Kursmateriell:</label>
        <label class="custom-file-upload">
            Velg fil
            <input type="file" id="material" name="material" class="file-input" onchange="updateFileName()">
        </label>
        <span class="file-name" id="file-name">Ingen fil valgt</span> <br /><br /><br />

    <input type="submit" value="Legg til oppgave">
    </form>

    <script>
    // Oppdaterer filnavnet når en fil er valgt
    function updateFileName() {
        const input = document.getElementById('material');
        const fileName = document.getElementById('file-name');
        fileName.textContent = input.files.length > 0 ? input.files[0].name : "Ingen fil valgt";
    }

</script>
</body>
</html>