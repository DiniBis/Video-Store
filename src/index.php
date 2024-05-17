<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>IMDB - Connexion</title>
</head>
<body>
<section id='formulaire_connexion'>
	<h1>Connexion:</h1>
	<form action="index.php" method="post">
		<label for="email"> Email :</label>
		<input type="email" name="email" id="email">
		<label for="password"> Mot de passe</label>
		<input type="password" name="password" id="password">
		<button type="submit" name="action" value="inscription">S'inscrire </button>
		<button type="submit" name="action" value="connexion">Connexion</button>
	</form>
	<a href="accueil.php">continuer sans connexion</a>
</section>
<?php
$pdo = new PDO();
if(isset($_POST['action'])) {
	/*Traitement des infos pour la l'inscription*/
    if($_POST['action'] === 'inscription') {
		$mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$password = $_POST['password'];
		/*Hash du mot de passe (avec salt), pour ne pas l'avoir en clair dans le SQL*/
		$hash = password_hash($password, PASSWORD_DEFAULT, array('cost'=>9)); //(le salt à 9 fait que le hash sera appliqué 9 fois)
		/*Requête SQL*/
		$requete=$pdo->prepare('INSERT INTO UTILISATEURS (mail, password) VALUES (:mail, :password)');
		$requete->execute(['password'=>$hash, 'mail'=>$mail]);
    } elseif($_POST['action'] === 'connexion') {
		/*Traitement des infos pour la connexion*/
		/*créer une session (et non un cookie)*/
		session_start();
		/*rediriger vers la page d'accueil si l'utilisateur est connecté*/
		if(isset($_SESSION['user_id'])) {
			header("Location: accueil.php");
			exit;
		}
		$mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$password = $_POST['password'];
		/*Si les informations au dessus sont correctes*/
		/*Faire la requête suivante*/
		$requete=$pdo->prepare('SELECT id, password FROM UTILISATEURS WHERE mail = :mail');
		/*On récupère le mot de passe pour comparer les 2*/
		$requete->execute(['mail'=>$mail]);
		$resultat = $requete->fetch(PDO::FETCH_ASSOC);
		if ($resultat) {
			$id = $resultat['id'];
			$hash = $resultat['password'];
		} else {
			echo "Erreur de connexion";
		}
		/*Si les mots de passes correspondent*/
		if (password_verify($password,$hash)) {
			/* enregistrer dans la session l'id l'utilisateur*/
			$_SESSION["user_id"]=$id;
		} else {
			echo "Erreur lors de la connexion";
		}
	}
}
?>
</body>
</html>