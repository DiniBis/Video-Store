<?php
session_start();
/*si l'utilisateur est connecté*/
if(isset($_SESSION['user_id'])) {    
    /*récupère l'id du film dans le formulaire*/
    if (isset($_POST['id'])){
        $id_film = htmlspecialchars($_POST['id']);
    }
    /*ajoute le film au SQL*/
    $pdo = new PDO();
    $id_user=$_SESSION["user_id"];
    $requete=$pdo->prepare('INSERT INTO PANIERS (id_utilisateur, id_film) VALUES (:id_user, :id_film)');
    $requete->execute(['id_user'=>$id_user, 'id_film'=>$id_film]);
    /*redirige vers la page d'accueil*/
    header("Location: accueil.php");
    exit;
}
else {
    echo "Erreur, assurez vous d'être connecté ou que le film existe";
}