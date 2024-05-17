<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>IMDB - Panier</title>
</head>
<header>
    <a href="../accueil.php">Accueil</a>
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
<h1>Votre panier</h1>
<?php
session_start();
/*Si connecté*/
if(isset($_SESSION['user_id'])) {    
    $pdo = new PDO();
    /*Récupérer l'id de l'utilisateur connecté (dans la session)*/
    $id_user=$_SESSION["user_id"];
    /*Récupérer tous les id de films dans le panier WHERE l'id_utilisateur est l'id de l'utilisateur connecté*/
    /*JOIN pour avoir les infos des films liés*/
    $requete=$pdo->prepare('SELECT * FROM PANIERS JOIN VIDEOS ON paniers.id_film=videos.id WHERE paniers.id_utilisateur=:id_user');
    $requete->execute(['id_user'=>$id_user]); 
    /*CALCUL DE LA SOMME & AFFICHAGE*/
    /*initialisation de $somme*/
    $somme=0;
    ?>
    <section id='articles'>
	<?php
    foreach($requete as $row){        
        ?>
        </br>
		<section class=article>
			<a href="details/<?php echo $row['id']?>">
				<h2><?php echo $row['titre']?></h2>
                <!--pour chaque films de la requête, ajouter le prix du film à la somme-->
				<h3><?php echo $row['prix']; $somme+=$row['prix']?> €</h3>
				<img src="<?php echo $row['image']?>" width="100px"/>
			</a>
			<form action="supp_panier.php" method="post">
                <!--panier.id étant écrasé par le join, on peut le trouver avec '2'-->
                <input type="hidden" name="id" value="<?php echo $row['2']?>"/>
				<button type="submit" value="<?php echo $row['2']?>">Supprimer</button>
			</form>
		</section>
		<?php
	}?>
    </section>
    <!--afficher la somme-->
    <h2>Somme: <?php echo $somme?> €</h2>
    <?php
}
/*Sinon*/
else {
    echo "Connectez vous pour afficher votre panier";
}?>
<form action="panier.php" method="post">
    <!--panier.id étant écrasé par le join, on peut le trouver avec '2'-->
	<button type="submit" value="suppression">Tout supprimer</button>
</form>
<?php
/*Bouton "Tout supprimer"*/
if(isset($_POST['action'])) {
    if(isset($_SESSION['user_id'])) {    
        $pdo = new PDO();
        $id_user=$_SESSION["user_id"];
        /*supprime tout le panier de l'utilisateur*/
        $requete=$pdo->prepare('DELETE FROM PANIERS WHERE id_utilisateur=:id_user');
        $requete->execute(['id_user'=>$id_user]);
        exit;
    }
    else {
        echo "Erreur, assurez vous d'être connecté ou que le film existe";
    }
}