<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Legg til oppgave</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        h2 {
            font-size: 24px;
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 56px;
            border-radius: 5px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 80px;
        }
        input[type="submit"] {
            background-color: #83BF73;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Skjul det opprinnelige filopplastingsfeltet */
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
        <input type="date" id="due_date" name="due_date">

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