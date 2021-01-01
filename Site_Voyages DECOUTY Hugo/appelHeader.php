<?php
include_once('fonctions.php');
include_once('connexion.php');
$connexion = connexionBd();

    $header = false; //Si true, alors on affiche le header pour les visiteurs ou personnes non connectés.
    $header_admin = false; //Si true, alors on affiche le header administrateur permettant de visionner la base de données.
    $header_user = false; //Si true, alors on affiche le header pour les utilisateurs connectés, qui ne sont pas administrateurs.

    if(isset($_SESSION['nom']) && isset($_SESSION['mdp'])) { //Si la personne est connectée...

        $User = $connexion->prepare("SELECT * FROM Clients WHERE nom = :nom AND prenom = :prenom AND mdp = :mdp "); //...On cherche le client en question...
        $User->bindParam(':nom', $_SESSION['nom']); //...Et on affiche ses variables de session...
        $User->bindParam(':prenom', $_SESSION['prenom']);
        $User->bindParam(':mdp', $_SESSION['mdp']);
        $User->execute();
        $resultat_u = $User -> fetch(PDO::FETCH_OBJ);

        if ($_SESSION['statut'] == 'Admin') { //On regarde son statut afin d'afficher le header administrateur ou utilisateur.
            $header_admin = true;
        } else {
            $header_user = true;
        }
    } else {
        $header = true;
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>TripAirplanes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
<header>
    <nav class="cadre_header">
        <div id="image_header"><img src="images/site/header-image.svg"></div>
        <ul id="ul-header">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="presentation_voyages.php">Voyages</a></li>
            <?php if($header_admin):?>
                <li id="li_connexion"><?="Bienvenue " . $_SESSION['nom'] . " " . $_SESSION['prenom']?><br><a href="mon_profil.php?client=<?= $resultat_u->id_client?>">Mon profil</a> | <a href="gererBDD.php">Gérer les données</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif;?>
            <?php if($header_user):?>
                <li id="li_connexion"><?="Bienvenue " . $_SESSION['nom'] . " " . $_SESSION['prenom']?><br><a href="mon_profil.php?client=<?= $resultat_u->id_client?>">Mon profil</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php endif;?>
            <?php if($header):?>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">S'inscrire</a></li>
            <?php endif;?>
        </ul>
    </nav>
</header>
</body>
</html>
