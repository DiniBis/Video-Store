<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>IMDB - Details</title>
</head>
<header>
    <a href="../accueil.php">Accueil</a>
	<form action="../recherche.php" method="post">
		<label for="search"></label>
		<input type="search" name="search" id="search">
		<select name="search-type">
			<option value="">--Choisis une option--</option>
			<option value="nom">par Titre</option>
			<option value="real">par Réalisateur</option>
		</select>
		<button type="submit" value="search_btn">Rechercher</button>
	</form>
	<a href="panier.php"><img src="../panier.png"/></a>
</header>
<body>
<?php 
/*liaison au SQL*/
$pdo = new PDO();

/*s'il y a un ID dans l'url, le récupérer*/
$uri = $_SERVER['REQUEST_URI'];
$uri = explode('/',$uri);
if (isset($uri[2])) {
    $id=$uri[2];
	settype($id,"int"); /*Mon id devient un int le plus tôt possible, pouvant être rentré dans l'url on cherche à prévenir les injections*/
} else {
    $id=null;
}

/*Requête SQL*/
$requete = $pdo->prepare('SELECT titre, prix, realisateur, categorie, image, acteur FROM videos WHERE id = :id');
$requete->bindParam(':id', $id, PDO::PARAM_INT);
$requete->execute();
/*Récupération des résultats sous forme de tableau associatif*/
$resultat = $requete->fetch(PDO::FETCH_ASSOC);
if ($resultat) {
    $titre = $resultat['titre'];
    $prix = $resultat['prix'];
    $realisateur = $resultat['realisateur'];
    $categorie = $resultat['categorie'];
    $image = $resultat['image'];
    $acteur = $resultat['acteur'];
} else {
    echo "Problème d'id $id";
}
?>
<div id=detail_film>
<section id=info_film>
<h1>Titre: <?php echo $titre?></h1>
<a href="../realisateur.php/<?php echo $realisateur?>">
<h2>Réalisateur: <?php echo $realisateur?></h2>
</a>
<a href="../categorie.php/<?php echo $categorie?>">
	<h2>Catégorie: <?php echo $categorie?></h2>
</a>
<h2>Acteur(s): <?php echo $acteur?></h2>
</section>
<img src="<?php echo $image?>" width="400px"/>
</div>
<form action="../ajout_panier.php" method="post">
	<input type="hidden" name="id" value="<?php echo $id?>"/>
	<button type="submit" name="panier">Ajouter au panier</button>
</form>
</body>
</html>