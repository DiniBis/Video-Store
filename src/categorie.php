<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>IMDB - Catégorie</title>
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

/*s'il y a une catégoire dans l'url, la récupérer*/
$uri = $_SERVER['REQUEST_URI'];
$uri = explode('/',$uri);
if (isset($uri[2])) {
    $categorie= htmlspecialchars($uri[2]);
    /*évite les erreurs dûes aux caractères spéciaux dans l'url ex:Com%C3%A9die*/
    $categorie = urldecode($categorie);
} else {
    $categorie=null;
}
/*Requête SQL*/
$requete = $pdo->prepare('SELECT id, titre, prix, realisateur, categorie, image, acteur FROM videos WHERE categorie = :categorie');
$requete->execute(['categorie'=>$categorie]);
/*Afficher tous les résultats*/
?><section id='previews'>
<?php
if($categorie!=null){
    foreach($requete as $row){
    ?>
    <section class=preview>
        <a href="../details/<?php echo $row['id']?>">
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
}
}?>
</body>
</html>