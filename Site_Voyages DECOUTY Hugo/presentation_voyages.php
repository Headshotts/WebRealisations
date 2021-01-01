<?php
    /* Présentation des voyages

Possibilité de rechercher le voyage que l'on souhaite à travers une barre de recherche puis les séléctions de voyages classées dans l'ordre décroissant du pourcentage de Places prises/Places totales avec message en rouge PLUS BEAUCOUP DE PLACES ! si plus de 90%.

Si un des voyages nous plaît, alors un bouton "En savoir plus" permet d'accéder à la page directement du voyage souhaité.
Sur cette même page "En savoir plus", on pourra voir toutes les informations du voyage et réserver :

- Soit à la fin du site en footer...
- Soit avec un bouton "Réserver" qui mène à [Reservations.php?...] où "..." est l'URL séléctionnant l'id_destination du voyage choisi et qui incrémente son nombre de réservations.

*/

/*      --AMELIORATIONS POUR CHOIX_VOYAGES.PHP--
    On suppose que tous les voyages autorisent tous types de billets : Economique, Standard, Première classe et Affaires.
    <->Barre de recherche permettant de trouver soi-même le voyage que l'on souhaite (Requête SQL préparée avec pour valeur, la barre de recherche)
    <->Créer le site paiement.php qui mène à un faux site bancaire qui calcule le prix en fonction du nb de réservations (client + personnes).
    <->Mettre des filtres styles listes déroulantes [Type de transport | Handicap | Continent (A AJOUTER DANS BDD section Sejour !!!!)]
*/

session_start();
include('connexion.php');
$connexion = connexionBd();
include('fonctions.php');

$presentation_voyages = "SELECT D.id_destination, D.nom, D.description, D.transport, D.prix, D.handicap, D.nb_places, D.nb_reserves, round(nb_reserves*100/nb_places,2) as ratio_places from Destination D GROUP BY D.id_destination, D.nom, D.description, D.transport, D.prix, D.handicap, D.nb_places, D.nb_reserves ORDER BY ratio_places DESC";
$count = $connexion->query($presentation_voyages);
$resultat_voyages = $count->fetchAll(PDO::FETCH_OBJ);

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
    <h2 id="h2-show">Voyages disponibles</h2>
    <ul class="ul-voyages">
        <?php foreach($resultat_voyages as $key => $values):?>
            <li class="show-voyages">
                <h3><?=$values->nom?></h3>
                <div class="flex-voyages">
                    <div id="flex-voyage-1">
                        <p><?=tronquer_texte($values->description)?></p>
                        <div id="symbols-voyages">
                            <?php if($values->handicap == 'Y'):?>
                                <img src="images/site/handicap.jpg">
                            <?php endif;?>

                            <?php if($values->transport == 'Avion'){
                                echo "<img src=\"images/site/avion.png\">";
                            } else if($values->transport == 'Bateau'){
                                echo "<img src=\"images/site/bateau.jpg\">";
                            } else if($values->transport == 'Train'){
                                echo "<img src=\"images/site/train.jpg\">";
                            } else {
                                echo "<img src=\"images/site/route.png\">";
                            }
                            ?>
                            <?php
                                if($values->nb_places == $values->nb_reserves){
                                    echo "<strong id=\"complete_reserv\">Réservation pleine.</strong>";
                                }else if($values->ratio_places > 90){
                                    $places_restantes = $values->nb_places - $values->nb_reserves;
                                    echo "<strong id=\"almost-complete_reserv\">Plus que $places_restantes places restantes !</strong>";
                                }else{
                                    echo "";
                                }
                            ?>
                        </div>
                    </div>
                    <div id="flex-voyage-2">
                        <p><?=$values->prix?> €/personne</p>
                        <p>Nombre de places : <?=($values->nb_places - $values->nb_reserves)?>/<?=$values->nb_places?></p>
                    </div>
                </div>
                <div class="show_more_voyages"><a href="sejour.php?id_destination=<?=$values->id_destination?>">En savoir plus</a></div>
            </li>
        <?php endforeach;?>
    </ul>
    <?php require_once("footer.php");?>
</main>
<script text="text/javascript" src="js/comportement.js"></script>
</body>



</html>
