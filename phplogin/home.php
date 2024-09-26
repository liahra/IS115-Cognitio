<?php 
session_start();

// Hvis ikke bruker er logget inn, send til logg inn side.
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cognitio</title>
		<link rel="stylesheet" href="styles.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Cognitio</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profil</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logg ut</a>
			</div>
		</nav>
		<div class="content">
			<h2>Dashbord</h2>
			<p>Velkommen tilbake, <?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?>!</p>
		</div>
	</body>
</html>