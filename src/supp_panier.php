<?php
session_start();
/*si l'utilisateur est connecté*/
if(isset($_SESSION['user_id'])) {    
    /*récupère l'id de l'article dans le formulaire*/
    if (isset($_POST['id'])){
        $id_article = htmlspecialchars($_POST['id']);
    }
    /*supprime le film du SQL*/
    $pdo = new PDO();
    $id_user=$_SESSION["user_id"];
    $requete=$pdo->prepare('DELETE FROM PANIERS WHERE id_utilisateur=:id_user AND id=:id');
    $requete->execute(['id_user'=>$id_user, 'id'=>$id_article]);
    header("Location: panier.php");
    exit;
}
else {
    echo "Erreur, assurez vous d'être connecté ou que le film existe";
}