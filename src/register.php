<?php
// DB-tilkobling: Inkluderer en ekstern fil som setter opp PDO-tilkoblingen
include_once './inc/db.inc.php';

// Sjekk om de nødvendige dataene fra skjemaet eksisterer i POST-forespørselen
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    exit('Vennligst fullfør registreringsformen.'); 
}

// Sjekk om de nødvendige feltene ikke er tomme
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    exit('Vennligst fullfør registreringsformen.'); 
}

// Valider at e-posten har et gyldig format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Ugyldig e-post.'); // Avslutt skriptet hvis e-posten ikke er gyldig
}

// Sjekk at brukernavnet kun inneholder bokstaver og tall
if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    exit('Ugyldig brukernavn.'); // Avslutt skriptet hvis brukernavnet inneholder ugyldige tegn
}

// Sjekk at passordet er innenfor de spesifiserte grensene for lengde
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Passord må være mellom 5 og 20 tegn!'); // Avslutt skriptet hvis passordet er for kort eller langt
}

try {
    // Forbered en SQL-spørring for å sjekke om brukernavnet allerede finnes i databasen
    $stmt = $pdo->prepare('SELECT id FROM accounts WHERE username = :username');
    
    // Bind brukernavnet til spørringen som en parameter
    $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
    
    // Utfør SQL-spørringen
    $stmt->execute();

    // Sjekk om brukernavnet allerede eksisterer i databasen
    if ($stmt->rowCount() > 0) {
        // Brukernavn eksisterer allerede, så avslutt registreringen
        exit('Brukernavn eksisterer allerede. Velg et annet.');
    } else {
        // Forbered en SQL-spørring for å sette inn en ny bruker i databasen
        $stmt = $pdo->prepare('INSERT INTO accounts (username, password, email) VALUES (:username, :password, :email)');
        
        // Hash passordet før det lagres i databasen for sikkerhet
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Bind brukernavn, hash av passordet, og e-post til spørringen
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);

        // Utfør SQL-spørringen for å sette inn brukeren
        $stmt->execute();

        // Gi brukeren en melding om at registreringen var vellykket
        echo 'Du er blitt registrert. Du kan nå logge inn!';

        // TODO
        // Videresend til loginside?
    }
} catch (PDOException $e) {
    // Hvis en feil oppstår under SQL-spørringene eller tilkoblingen, vis en feilmelding
    exit('Noe gikk galt: ' . $e->getMessage());
}
?>