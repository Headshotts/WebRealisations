<?php
    session_start();
    include_once('connexion.php');
    $connexion = connexionBd();
/*Page de réservation du site. */
date_default_timezone_set('Europe/Paris');
/*$reserv = false;

    if(isset($_GET['success'])){
        //Booléen pour le message comme quoi la réservation a bien été effectué.
        $reserv = true;
    }*/

    if(isset($_GET['id_destination'])){

        $destination = $connexion->prepare("SELECT * FROM destination WHERE id_destination = :id");
        $destination->bindParam(':id', $_GET['id_destination']);
        $destination->execute();
        $resultat_d = $destination->fetch(PDO::FETCH_OBJ);

        if(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['handicap'])){
            if(isset($_POST['btnSubmit'])){
                $date_reserv = htmlspecialchars($_POST["date_reserv"]);
                $current_date = date('Y-m-d');
                if($date_reserv < $current_date){
                    header('Location: reservations.php?id_destination=' . $_GET['id_destination'] . '&invalid_date=true');
                    //header('Location: reservations.php');
                }elseif($_POST['nb_tickets'] > $_POST['nb_tickets_max']){ //Si le nombre de tickets voulus est trop grand, alors on redirige avec un message d'erreur.
                    header('Location: reservations.php?id_destination=' . $_GET['id_destination'] . '&places_max=true');
                }else{
                    $date = $_POST['date_reserv'];
                    $date_modifie = date('Y-m-d',strtotime($date));

                    $nb_tickets = $_POST['nb_tickets'];
                    $nb_handicap = $_POST['handicap'][0];
                    $eco = $_POST['type_billet']['economic'];
                    $premium = $_POST['type_billet']['premium'];
                    $business = $_POST['type_billet']['business'];
                    $prix_a_payer = $_POST['prix_a_payer'];

                    $ajout_reservation = $connexion->prepare("INSERT INTO reservations(date_debut, nombre_personnes, nb_handicapes, nb_billets_Eco, nb_billets_Premium, nb_billets_Affaires, prix, id_destination, id_client) VALUES (:date, :nb_pers, :nb_h, :nb_eco, :nb_pre, :nb_af, :prix, :dest, :client)");
                    $ajout_reservation->bindParam(':date', $date_modifie);
                    $ajout_reservation->bindParam(':nb_pers', $nb_tickets);
                    $ajout_reservation->bindParam(':nb_h', $nb_handicap);
                    $ajout_reservation->bindParam(':nb_eco', $eco);
                    $ajout_reservation->bindParam(':nb_pre', $premium);
                    $ajout_reservation->bindParam(':nb_af', $business);
                    $ajout_reservation->bindParam(':prix', $prix_a_payer);
                    $ajout_reservation->bindParam(':dest', $_GET['id_destination']);
                    $ajout_reservation->bindParam(':client', $_SESSION['id']);
                    $ajout_reservation->execute();
                    //Pas de unique dans les ajouts de réservations.

                    //Modifie les places restantes de la destination dans la BDD. [N'est pas bon]

                    $modif_nb_places_dest = $connexion->prepare("UPDATE destination D SET D.nb_reserves = (SELECT sum(R.nombre_personnes) as nb_pers FROM Reservations R WHERE R.id_destination = :idD) WHERE D.id_destination = :idR");
                    //("UPDATE destination D SET D.nb_places = D.nb_places - (SELECT sum(R.nombre_personnes) as nombre_personnes from reservations R WHERE R.id_destination = :idD) WHERE D.id_destination = :idR");
                    $modif_nb_places_dest->bindParam(':idD', $_GET['id_destination']);
                    $modif_nb_places_dest->bindParam(':idR', $_GET['id_destination']);
                    $modif_nb_places_dest->execute();

                    header('Location: mon_profil.php?client=' . $_SESSION['id'] . '&nom_dest=' . $resultat_d->nom . '&reserv=true');
                }
            }
        }else{
            header('Location: login.php');
        }
    }else{
        header('Location: index.php');
    }


    //Faire un SELECT * FROM Destination WHERE id_destination = :id ou :id -> $_GET['id_destination'] et mettre dans le formulaire de type hidden : $resultat->prix

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
        <?php require_once('appelHeader.php');?>
   </header>
  <main>
      <?php if(isset($_GET['invalid_date'])):?>
          <div class="erreur_reserv"><p><img src="images/site/danger.jpg">La date de réservation n'est pas valide.</p></div>
      <?php endif;?>
      <?php if(isset($_GET['places_max'])):?>
          <div class="erreur_reserv"><p><img src="images/site/danger.jpg">Réservation pleine. Choississez une nouvelle destination ou veuillez prendre moins de tickets.</p></div>
      <?php endif;?>
      <p>Vous souhaitez réserver pour le voyage : <?=$resultat_d->nom?></p>
      <form method="POST" action="reservations.php?id_destination=<?=$_GET['id_destination']?>">

        <fieldset>
            <p>
                <label for="nom">Votre nom :</label> <!-- Si la personne est connectée, écrire directement son nom dans le formulaire !-->
                <input type="text" id="nom" name="nom" value="<?=$_SESSION['nom']?>"required autofocus> <!--Mettre $_SESSION['nom'];!-->
            </p>
            <p>
                <label for="prenom">Votre prénom : </label>
                <input type="text" id="prenom" name="prenom" value="<?=$_SESSION['prenom']?>" required>
            </p>
            <p>      
                <label for="date_reserv">Date de réservation : </label>
                <input type="date" id="date_reserv" name="date_reserv" required>
            </p>

            <p>
                <label for="type_billet">Choississez le type de billet/les différents types de billets que vous souhaitez acheter : </label>

                <input class="billet" id="economic" type="number" min="0" step="1" name="type_billet[economic]" value="0">Economique
                <input class="billet" id="premium" type="number" min="0" step="1" name="type_billet[premium]" value="0">Premium
                <input class="billet" id="business" type="number" min="0" step="1" name="type_billet[business]" value="0">Affaires
                <input type="hidden" name="nb_tickets" id="nb_tickets" value="0">  <!-- Récupération du nombre de tickets achetés pour la BDD -->
                <p id="str_nb_tickets">Il y'a 0 tickets à payer.</p>
                <input type="hidden" id="prix_voyage" value="<?=$resultat_d->prix?>">
                <p id="prix_a_payer">Prix à payer : 0€</p> <!--CODE JS!-->
                <input type="hidden" class="prix_a_payer" name="prix_a_payer" value="0"> <!-- Récupération du prix total pour la BDD -->
                <input type="hidden" name="nb_tickets_max" id="nb_tickets_max" value="<?=($resultat_d->nb_places - $resultat_d->nb_reserves)?>">
            </p>
            <p>
                <label for="handicap">Combien y'a t-il de places handicapés à réserver ?</label>
                <input id="handicap_reserv" type="number" min="0" step="1" name="handicap" value="0">
                <!-- Pour le moment, toute place peut être une place handicapée -> pas de limitation de places handicapés en plus du nb de places -->
            </p>
            <p class="submit">
                <label for="submit">Procéder au paiement :</label>
                <input type="submit" name="btnSubmit" id="btnSubmit" value="Payer" />
                <!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tbody><tr><td align="center"></td></tr><tr><td align="center"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" border="0" alt="PayPal Logo" /></a></td></tr></tbody></table><!-- PayPal Logo -->
            </p>
        </fieldset>
      </form>

  </main>
    <?php require_once("footer.php");?>
    <script type="text/javascript" src="js/comportement.js"></script>
</body>
</html>