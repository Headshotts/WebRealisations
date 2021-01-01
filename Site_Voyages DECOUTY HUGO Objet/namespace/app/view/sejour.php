<?php
include_once("app/entity/Destination.php");
use app\controller\controllerReservation;

$affichage_handicap = "";
if(!empty($content)){ //Si l'utilisateur écrit une fausse URL directement pour accéder à une page
    if($content[0]->getHandicap() == 'Y'){
        $affichage_handicap = "Autorisé";
    }else{
        $affichage_handicap = "Non autorisé";
    }
}else{
    header('Location: index.php');
}
$reserv = new controllerReservation();
$fct_nbreserves = $reserv->countPlacesTaken($_GET['id_destination'])[0]['nbpers'];
if(is_null($fct_nbreserves)){
    $nb_reserves = 0;
}else{
    $nb_reserves = $fct_nbreserves;
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
<!--Content[0] récupère la valeur de content pour un fetch -->
<body>
    <div id="cadre_titre"><h2 id="nom_dest"><?= $content[0]->getNom()?></h2></div>
    <section class="flex_sejour">
        <article class="flex_dest">
            <img id="image_dest" src="<?= $content[0]->getImage()?>">
        </article>
        <article class="flex_dest">
            <p id="description_sejour"><?= $content[0]->getDescription()?></p>
            <p class="infos_dest">Transport : <?=$content[0]->getTransport()?></p>
            <p class="infos_dest">Nombre de places : <?= ($content[0]->getNbPlaces() - $nb_reserves)?></p>
            <p class="infos_dest">Places handicapés : <?= $affichage_handicap?></p>

            <div id="prix_dest"><strong>Prix : <?= $content[0]->getPrix()?>€ /personne (Prix Economique)</strong></div>
            <p id="infos_prix"><?=number_format(($content[0]->getPrix())*1.5, 2, '.', ' ')?>€ : Prix Premium / <?=number_format(($content[0]->getPrix())*1.8, 2, '.', ' ')?>€ : Prix Business</p>
        </article>
    </section>
    <?php
    if($content[0]->getNbPlaces() != $nb_reserves){ //Si la réservation n'est pas complète...
        if($content[0]->getHandicap() == 'Y'){
            echo "<div class='button_reserv'><a href='reservations.php?id_destination=" . $_GET['id_destination'] . "&handicap=true'" . ">Je souhaite réserver ce voyage !</a></div>";
        }else{
            echo "<div class='button_reserv'><a href='reservations.php?id_destination=" . $_GET['id_destination'] . "'>Je souhaite réserver ce voyage !</a></div>";
        }
    }else{
        echo "<div class=\"button_reserv_complete\">Réservation complète</div>";
    }

    ?>
</body>
</html>
