<?php
if (!empty($_POST)) {
    require_once '../account.php';
    require_once '../validation.php';

    $validator = new Validation();

    if (!$validator->validateFormData($_POST)) {
        // Hent og vis alle feilmeldingene hvis noen valideringer feiler
        foreach ($validator->getErrors() as $error) {
            echo $error . '<br>';
        }
        exit();
    }

    // Opprett en ny instans av Account-klassen
    $account = new Account();

    try {
        // Sjekk om brukernavnet allerede finnes
        if ($account->usernameExists($_POST['username'])) {
            exit('Brukernavn eksisterer allerede. Velg et annet.');
        } else {
            // Sett brukerdetaljene i Account-instansen
            $account->setFirstName($_POST['fname']);
            $account->setLastName($_POST['lname']);
            $account->setUsername($_POST['username']);
            $account->setEmail($_POST['email']);
            $account->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT)); // Hashet passord
            $account->setRole('admin'); // Setter standard rolle som 'admin'
            $account->setRegDate(date('Y-m-d'));

            $account->createAccount();

            // Bekreft at registreringen var vellykket
            echo 'Du er blitt registrert. Du kan nå logge inn!';
            exit();
        }
    } catch (PDOException $e) {
        exit('Noe gikk galt: ' . $e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminbruker</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        main {
            max-width: 80ch;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: whitesmoke;
            min-height: 100dvh;
        }

        form {
            display: flex;
            flex-direction: column;

            input {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <main>
        <h1>Opprett adminbruker</h1>
        <form action="" method="post">
            <!-- Fornavn -->
            <label for="fname">
                Fornavn:
            </label>
            <input type="text" name="fname" placeholder="Fornavn" id="fname" required>

            <!-- Etternavn -->
            <label for="lname">
                Etternavn:
            </label>
            <input type="text" name="lname" placeholder="Etternavn" id="lname" required>

            <!-- Brukernavn -->
            <label for="username">
                Brukernavn:
            </label>
            <input type="text" name="username" placeholder="Brukernavn" id="username" required>

            <!-- E-post -->
            <label for="email">
                E-post:
            </label>
            <input type="email" name="email" placeholder="E-post" id="email" required>

            <!-- Passord -->
            <label for="password">
                Passord:
            </label>
            <input type="password" name="password" placeholder="Passord" id="password" required>

            <!-- Bekreft passord -->
            <label for="confirm_password">
                Bekreft passord:
            </label>
            <input type="password" name="confirm_password" placeholder="Bekreft passord" id="confirm_password" required>

            <input type="submit" value="Send inn">
        </form>
    </main>
</body>

</html>