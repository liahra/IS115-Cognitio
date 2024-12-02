<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Logg inn</title>
</head>

<body>
    <img src="./resources/img/cognitio_logo_sort.png" alt="" height="35">
    <div class="login">
        <h1>Logg inn</h1>
        <form action="../src/authenticate.php" method="post">
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="username" placeholder="Brukernavn" id="username" required>
            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Passord" id="password" required>
            <!-- Vis feilmelding her -->
            <?php if (!empty($_SESSION['error'])): ?>
                <p style="color: red; text-align: center;"><?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <input type="submit" value="Logg inn">
        </form>

    </div>
</body>

</html>