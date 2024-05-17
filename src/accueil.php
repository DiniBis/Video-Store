<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>IMDB - Accueil</title>
</head>
<header>
	<form action="recherche.php" method="post">
		<label for="search"></label>
		<input type="search" name="search" id="search">
		<select name="search-type">
			<option value="">--Choisis une option--</option>
			<option value="nom">par Titre</option>
			<option value="real">par Réalisateur</option>
		</select>
		<button type="submit" value="search_btn">Rechercher</button>
	</form>
	<a href="panier.php"><img src="panier.png"/></a>
</header>
<body>
<?php 
/*liaison au SQL*/
$pdo = new PDO();
?>
<h1>Accueil</h1>
<?php
/*Requête SQL*/
$requete = $pdo->prepare('SELECT titre, prix, image, id FROM videos');
$requete->execute();
/*Récupération des résultats sous forme de tableau associatif*/
$resultat = $requete->fetch(PDO::FETCH_ASSOC);
if ($resultat) {
    $titre = $resultat['titre'];
    $prix = $resultat['prix'];
    $image = $resultat['image'];
	$id = $resultat['id'];
} else {
    echo "Pas de film trouvé";
}
/*Création des previews*/
	?>
	<section id='previews'>
	<?php
	/*Pour chaque films*/
	foreach($requete as $row) {
		?>
		<section class=preview>
			<a href="details/<?php echo $row['id']?>">
				<h2><?php echo $row['titre']?></h2>
				<h3><?php echo $row['prix']?> €</h3>
				<img src="<?php echo $row['image']?>" width="100px"/>
			</a>
			<form action="ajout_panier.php" method="post">
				<input type="hidden" name="id" value="<?php echo $row['id']?>"/>
				<button type="submit" name="panier">Ajouter au panier</button>
			</form>
		</section>
		<?php
	}?>
	</section>
</body>
</html>