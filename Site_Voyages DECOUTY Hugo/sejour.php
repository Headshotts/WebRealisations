<?php
    session_start();
    //Séjour correspondant au modèle de chaque voyage
    include_once('connexion.php');
    $connexion = connexionBd();
    $num_destination = htmlspecialchars($_GET['id_destination']);
    $destination = $connexion->prepare("SELECT * from destination where id_destination = :id"); //On affiche la destination correspondante.
    $destination->bindParam(':id', $num_destination);
    $destination->execute();

    $resultat_dest = $destination->fetch(PDO::FETCH_OBJ);
    //Afficher le résultat de 'handicap' de la BDD de manière compréhensive pour les utilisateurs :
    $affichage_handicap = "";
    if(!empty($resultat_dest)){ //Si l'utilisateur écrit une fausse URL directement pour accéder à une page
        if($resultat_dest->handicap == 'Y'){
            $affichage_handicap = "Autorisé";
        }else{
            $affichage_handicap = "Non autorisé";
        }
    }else{
        header('Location: index.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>TripAirplanes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
<header>
    <?php require_once('appelHeader.php');?>
</header>
    <main>
        <div id="cadre_titre"><h2 id="nom_dest"><?= $resultat_dest->nom?></h2></div>
        <section class="flex_sejour">
            <article class="flex_dest">
                <img id="image_dest" src="<?= $resultat_dest->image?>">
            </article>
            <article class="flex_dest">
                <p id="description_sejour"><?= $resultat_dest->description ?></p>
                <p class="infos_dest">Transport : <?=$resultat_dest->transport?></p>
                <p class="infos_dest">Nombre de places : <?= ($resultat_dest->nb_places - $resultat_dest->nb_reserves)?></p>
                <p class="infos_dest">Places handicapés : <?= $affichage_handicap?></p>
                <div id="prix_dest"><strong>Prix : <?= $resultat_dest->prix?>€ /personne (Prix Economique)</strong></div>
                <p id="infos_prix"><?=($resultat_dest->prix)*1.5?>€ : Prix Premium / <?=($resultat_dest->prix)*1.8?>€ : Prix Business</p>
            </article>
        </section>
        <div class="button_reserv"><a href="reservations.php?id_destination=<?=$_GET['id_destination']?>">Je souhaite réserver ce voyage !</a></div>
    </main>
<br><br>

<?php require_once("footer.php");?>
<script text="text/javascript" src="js/comportement.js"></script>
</body>



</html>
