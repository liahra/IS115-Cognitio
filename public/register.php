<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./resources/css/styles.css">
    <link rel="stylesheet" href="./resources/css/register.css">

    <title>Registrering</title>
</head>
<body>
    <img src="./resources/img/cognitio_logo_sort.png" alt="" height="35">
    <div class="register">
        <h1>Lag din Cognitio-konto</h1>
        <form action="../src/register.php" method="post" autocomplete="off">
            <!-- Fornavn -->
            <label for="fname">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="fname" placeholder="Fornavn" id="fname" required>
            
            <!-- Etternavn -->
            <label for="lname">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="lname" placeholder="Etternavn" id="lname" required>

            <!-- Brukernavn -->
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="username" placeholder="Brukernavn" id="username" required>
            
            <!-- E-post -->
            <label for="email">
                <i class="fas fa-envelope"></i>
            </label>
            <input type="email" name="email" placeholder="E-post" id="email" required>

            <!-- Passord -->
            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Passord" id="password" required>

            <!-- Bekreft passord -->
            <label for="confirm_password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="confirm_password" placeholder="Bekreft passord" id="confirm_password" required>

            <input type="submit" value="Send inn">
        </form>
    </div>
</body>
</html>