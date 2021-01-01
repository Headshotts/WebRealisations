<?php
include_once("app/entity/Destination.php");
include_once("app/controller/controllerReservation.php");
include_once("fonctions.php");
$reserv = new app\controller\controllerReservation();
?>

<?php if(empty($content)):?>
    <div id="empty-show-voyages">Votre recherche filtrée n'a donné aucun résultat.</div>
<?php endif;?>
<ul class="ul-voyages">
    <?php foreach($content as $values):?>
        <?php
        $fct_nbreserves = $reserv->countPlacesTaken($values->getIdDestination())[0]['nbpers'];
        if(is_null($fct_nbreserves)){
            $nb_reserves = 0;
        }else{
            $nb_reserves = $fct_nbreserves;
        }

        ?>
        <li class="show-voyages">
            <h3><?=$values->getNom()?></h3>
            <div class="flex-voyages">
                <div id="flex-voyage-1">
                    <p><?=tronquer_texte($values->getDescription())?></p>
                    <div id="symbols-voyages">
                        <?php if($values->getHandicap() == 'Y'):?>
                            <img src="images/site/handicap.jpg">
                        <?php endif;?>

                        <?php if($values->getTransport() == 'Avion'){
                            echo "<img src=\"images/site/avion.png\">";
                        } else if($values->getTransport() == 'Bateau'){
                            echo "<img src=\"images/site/bateau.jpg\">";
                        } else if($values->getTransport() == 'Train'){
                            echo "<img src=\"images/site/train.jpg\">";
                        } else {
                            echo "<img src=\"images/site/route.png\">";
                        }
                        ?>
                        <?php
                        if($nb_reserves == $values->getNbPlaces()){ //$values->getRatioPlaces() == 100
                            echo "<strong id=\"complete_reserv\">Réservation pleine.</strong>";
                        }else if($values->getNbPlaces() - $nb_reserves <= 20){ //$values->getRatioPlaces() > 90
                            $places_restantes = $values->getNbPlaces() - $nb_reserves;
                            echo "<strong id=\"almost-complete_reserv\">Plus que $places_restantes places restantes !</strong>";
                        }else{
                            echo "";
                        }
                        ?>
                    </div>
                </div>
                <div id="flex-voyage-2">
                    <p><?=$values->getPrix()?> €/personne</p>
                    <p>Nombre de places : <?=($values->getNbPlaces() - $nb_reserves)?>/<?=$values->getNbPlaces()?></p>
                </div>
            </div>
            <div class="show_more_voyages"><a href="sejour.php?id_destination=<?=$values->getIdDestination()?>">En savoir plus</a></div>
        </li>
    <?php endforeach;?>
</ul>
