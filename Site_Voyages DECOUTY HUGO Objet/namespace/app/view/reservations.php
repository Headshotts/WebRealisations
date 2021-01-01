<?php
    use app\controller\controllerReservation;
    $reserv = new controllerReservation();

$fct_nbreserves = $reserv->countPlacesTaken($_GET['id_destination'])[0]['nbpers'];
if(is_null($fct_nbreserves)){
    $nb_reserves = 0;
}else{
    $nb_reserves = $fct_nbreserves;
}
?>

<p id="info_reserv">Vous souhaitez réserver pour le voyage : <?=$content[0]->getNom()?></p>
<?php if(isset($_GET['handicap'])){
    echo "<form id=\"form-reserv\" method=\"post\" action=\"reservations.php?id_destination=" . $_GET['id_destination'] . "&handicap=true\">";
}else{
    echo "<form id=\"form-reserv\" method=\"post\" action=\"reservations.php?id_destination=" . $_GET['id_destination'] . "\">";
}
?>


    <fieldset>
        <p>
            <label for="nom">Votre nom :</label>
            <input type="text" id="nom" name="nom" value="<?=$_SESSION['nom']?>" readonly required autofocus>
        </p>
        <p>
            <label for="prenom">Votre prénom : </label>
            <input type="text" id="prenom" name="prenom" value="<?=$_SESSION['prenom']?>" readonly required>
        </p>
        <p>
            <label for="date_reserv">Date de réservation : </label>
            <input type="date" id="date_reserv" name="date_reserv" required>
        </p>

        <p id="billet">
            <label  for="type_billet">Choississez le(s) type(s) de billet(s) que vous souhaitez acheter : </label><br>

            <input class="billet" id="economic" type="number" min="0" step="1" name="type_billet[economic]" value="0" required>Economique
            <input class="billet" id="premium" type="number" min="0" step="1" name="type_billet[premium]" value="0" required>Premium
            <input class="billet" id="business" type="number" min="0" step="1" name="type_billet[business]" value="0" required>Affaires
            <input type="hidden" name="nb_tickets" id="nb_tickets" value="0">  <!-- Récupération du nombre de tickets achetés pour la BDD -->
            <div id="resultat-reserv">
        <p id="str_nb_tickets">Vous souhaitez 0 tickets.</p>
        <input type="hidden" id="prix_voyage" value="<?=$content[0]->getPrix()?>">
        <p id="prix_a_payer">Prix à payer : 0€</p>
        </div>
        <input type="hidden" class="prix_a_payer" name="prix_a_payer" value="0"> <!-- Récupération du prix total pour la BDD -->
        <input type="hidden" name="nb_tickets_max" id="nb_tickets_max" value="<?=($content[0]->getNbPlaces() - $nb_reserves)?>">
        </p>
        <?php if(isset($_GET['handicap'])):?>
            <p id="handicap-p">
                <label for="handicap">Combien y'a t-il de places handicapés à réserver ?</label>
                <input id="handicap_reserv" type="number" min="0" step="1" name="handicap" value="0">
                <!-- Pour le moment, toute place peut être une place handicapée -> pas de limitation de places handicapés en plus du nb de places -->
            </p>
        <?php endif;?>
        <p id="submit-reserv">
            <label for="submit">Procéder au paiement :</label>
            <input type="submit" name="btnSubmit" id="btnSubmit" value="Payer" />
            <!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tbody><tr><td align="center"></td></tr><tr><td align="center"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" border="0" alt="PayPal Logo" /></a></td></tr></tbody></table><!-- PayPal Logo -->
        </p>
    </fieldset>
</form>