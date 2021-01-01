<?php
    session_start();
    include('connexion.php');
    $connexion = connexionBd();
    //Ce site sert à ce que l'utilisateur puisse voir son profil. Pour le moment, seul le remboursement d'un voyage a été défini sur la page.
    $sup = false; //Sert à écrire un message comme quoi la réservation a bien été supprimée.
    if(isset($_GET['sup'])){
        $sup = true;
    }

    //Savoir combien il y'a de réservations :

    $nb_reservations = $connexion->prepare("SELECT COUNT(id_reservation) as nombres FROM reservations WHERE id_client = :client");
    $nb_reservations->bindParam(':client', $_SESSION['id']);
    $nb_reservations->execute();
    $resultat_nb = $nb_reservations->fetch(PDO::FETCH_OBJ);

    //Mettre à jour l'historique de réservation du client dans son $_SESSION['reservation']
    $reservation = $connexion->prepare("SELECT date_debut, nombre_personnes, R.id_destination, id_reservation, D.nom, R.prix FROM RESERVATIONS R JOIN DESTINATION D ON D.id_destination = R.id_destination WHERE R.id_client = :client ORDER BY date_debut ASC");
    $reservation->bindParam(':client', $_SESSION['id']);
    $reservation->execute();
    $_SESSION['reservation'] = $reservation->fetchAll(PDO::FETCH_OBJ);



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
    <?php if($sup):?>
        <p>Suppression de la réservation réussie. Remboursement effectué.</p>
    <?php endif;?>
    <?php if(isset($_GET['reserv'])):?>
        <p>Réservation pour le voyage <?=$_GET['nom_dest']?> effectuée !</p>
    <?php endif;?>
    <p>Vous avez <?=$resultat_nb->nombres?> réservations en cours : </p>
    <table id="table_reservation" border="4">
        <tr><th>Nom du voyage</th><th>Prix du voyage</th><th>Date de départ</th><th>Nombre de personnes</th></tr>
        <?php foreach($_SESSION['reservation'] as $key => $values):?>
            <tr id="tr_reservation"><td><a href="remboursement.php?id_reservation=<?=$values->id_reservation?>&id_destination=<?=$values->id_destination?>"><?=$values->nom?></a></td><td><?=$values->prix?></td><td><?=$values->date_debut?></td><td><?=$values->nombre_personnes?></td></tr>
        <?php endforeach;?>
    </table>
    <form method="post" action="mon_profil.php"
    </form>

    <?php require_once("footer.php");?>
</main>
<script type="text/javascript" src="js/comportement.js"></script>
</body>



</html>
