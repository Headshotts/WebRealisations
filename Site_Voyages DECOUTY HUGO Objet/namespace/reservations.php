<?php
/*Page de réservation du site. */
    session_start();
    include_once("app/controller/controllerVoyage.php");
    include_once("app/controller/controllerReservation.php");
    spl_autoload_register('chargerClasse'); //Autoload
    function chargerClasse($classe) {
        $classe = str_replace('\\', '/', $classe);
        require $classe . '.php';
    }
    date_default_timezone_set('Europe/Paris');
    $voyage = new app\controller\controllerVoyage();
    $reserv = new app\controller\controllerReservation();

if(isset($_GET['id_destination'])){

    if(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['handicap'])){
        if(isset($_POST['btnSubmit'])){
            $date_reserv = htmlspecialchars($_POST["date_reserv"]);
            $current_date = date('Y-m-d');
            if($date_reserv < $current_date){
                if(isset($_GET['handicap'])){
                    header('Location: reservations.php?id_destination=' . $_GET['id_destination'] . '&invalid_date=true&handicap=true');
                }else{
                    header('Location: reservations.php?id_destination=' . $_GET['id_destination'] . '&invalid_date=true');
                }


            }elseif($_POST['nb_tickets'] > $_POST['nb_tickets_max']){ //Si le nombre de tickets voulus est trop grand, alors on redirige avec un message d'erreur.
                if(isset($_GET['handicap'])){
                    header('Location: reservations.php?id_destination=' . $_GET['id_destination'] . '&places_max=true&handicap=true');
                }else {
                    header('Location: reservations.php?id_destination=' . $_GET['id_destination'] . '&places_max=true');
                }
            }elseif($_POST['nb_tickets'] == 0 || is_nan($_POST['nb_tickets'])){
                if(isset($_GET['handicap'])){
                    header('Location: reservations.php?id_destination=' . $_GET['id_destination'] . '&invalid_ticket=true&handicap=true');
                }else{
                    header('Location: reservations.php?id_destination=' . $_GET['id_destination'] . '&invalid_ticket=true');
                }

            }else{
                $date = $_POST['date_reserv'];
                $date_modifie = date('Y-m-d',strtotime($date));

                $nb_tickets = $_POST['nb_tickets'];
                if(isset($_GET['handicap'])){
                    $nb_handicap = $_POST['handicap'][0];
                }else{
                    $nb_handicap = 0;
                }
                $eco = $_POST['type_billet']['economic'];
                $premium = $_POST['type_billet']['premium'];
                $business = $_POST['type_billet']['business'];
                $prix_a_payer = $_POST['prix_a_payer'];

                $reserv->insertReserv($date_modifie, $nb_tickets, $nb_handicap, $eco, $premium, $business, $prix_a_payer, $_GET['id_destination'], $_SESSION['id']);

                header('Location: mon_profil.php?client=' . $_SESSION['id'] . '&nom_dest=' . $voyage->getName($_GET['id_destination'])[0]->getNom() . '&reserv=true');//$content[0]->getNom()
            }

        }
    }else{
        header('Location: login.php');
    }
}else{
    header('Location: index.php');
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>TripAirplanes - Réservation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<?php require_once('appelHeader.php');?>
  <main>

      <?php if(isset($_GET['invalid_date'])):?>
          <div class="erreur_reserv"><p><img src="images/site/danger.jpg">La date de réservation n'est pas valide.</p></div>
      <?php endif;?>
      <?php if(isset($_GET['places_max'])):?>
          <div class="erreur_reserv"><p><img src="images/site/danger.jpg">Réservation pleine. Veuillez prendre moins de tickets.</p></div>
      <?php endif;?>
      <?php if(isset($_GET['invalid_ticket'])):?>
          <div class="erreur_reserv"><p><img src="images/site/danger.jpg">Nombre de tickets inapproprié. Choississez une quantité valide.</p></div>
      <?php endif;?>
      <?php $voyage->getDestbyId_reserv($_GET['id_destination']);?>
  </main>
    <?php require_once("footer.php");?>
    <script type="text/javascript" src="js/comportement.js"></script>
</body>
</html>