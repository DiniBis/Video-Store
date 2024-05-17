<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>IMDB - Recherche</title>
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
	<a href="panier.php"><img src="panier.png"/></a>
</header>
<?php
/*liaison au SQL*/
$pdo = new PDO();
/*récupérer les infos du formulaire*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["search"]) && isset($_POST["search-type"])){
        $search = htmlspecialchars($_POST["search"]);
        $searchType = htmlspecialchars($_POST["search-type"]);
    }
    /*comparer avec un nom de film ou de réalisateur (passer les 2 en majuscule)*/
    if ($searchType=='nom'){
        $requete=$pdo->prepare('SELECT * FROM VIDEOS WHERE titre = :nom');
        $requete->execute(['nom'=>$search]);
    }
    elseif ($searchType=='real'){
        $requete=$pdo->prepare('SELECT * FROM VIDEOS WHERE realisateur = :nom');
        $requete->execute(['nom'=>$search]);
    }
    else {
        echo "Veuillez choisir un type de recherche";
    }
    /*Afficher le ou les résultats*/
    ?>
	<section id='previews'>
	<?php
    foreach($requete as $row){
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
	}
}?>
</body>
</html>