# Video-Store
PHP and SQL-based movie shopping site  
[lien vers le FIGMA en lecture seule](https://www.figma.com/file/utIGsvbk1kpH82jBJHGMQk/1PHPD-movie-SQL?type=design&node-id=0%3A1&mode=design&t=B4zfnzfyaHKct543-1)

## Pages:
- connexion / inscription
	- possibilité de ne pas être connecté  
(si a choisi de rester connecté -> rediriger directement vers l'accueil)  
(faire un hash pour rentrer le mdp lors de l'inscription, et appliquer le même hash lors de la connexion)

- page d'accueil
	- textes de présentation
	- quelques vidéos (avec Titre + Prix + Ajouter au Panier)
	- barre de recherche (par Titre ou réalisateur)

- page recherche (résultats du SELECT précédent)

- page catégorie (SELECT par catégories)

- page détail
	- afficher toutes les infos d'une vidéo (via son ID dans l'url)
	- bouton ajouter au panier (demande d'être connecté)

- page panier
	- accessible seulement si connecté
	- liste des vidéos dans le panier dans l'utilisateur (Titre + Prix), suivi d'un bouton pour les supprimer
	- affiche la somme des prix

## Database (SQL)
- MOVIES
	- Titre
	- Prix
	- Réalisateur
	- Catégorie (ex: Action / Drama)
	- Image (sûrement un lien d'image web)
	- Acteur
	- ID (auto incrémenté)

|Titre|Prix|Réalisateur|Catégorie|Image|Acteur(s)|ID|
|-----|----|-----------|---------|-----|---------|--|

- USERS
	- Mail
	- Password
	- ID (auto incrémenté)

|Mail|Password|ID|
|----|--------|--|

- PANIER
	- ID Utilisateur
	- ID Film
	- ID (auto incrémenté) → permet de retrouver directement cet élément de panier pour le supprimer facilement

|ID_user|ID_movie|ID|
|-------|--------|--|
