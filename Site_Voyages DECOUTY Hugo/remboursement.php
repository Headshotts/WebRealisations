<?php
    session_start();
    include_once('connexion.php');
    $connexion = connexionBd();
    //Site qui sert au remboursement d'un voyage.

    //Récupération du nom de la destination (Affichage).
    $recup_nom_dest = $connexion->prepare("SELECT nom from destination WHERE id_destination = :id");
    $recup_nom_dest->bindParam(':id', $_GET['id_destination']);
    $recup_nom_dest->execute();
    $nom = $recup_nom_dest->fetch(PDO::FETCH_OBJ);

    if(isset($_POST['rembourser'])){

        //On supprime la réservation en question.
        $suppression_reserv = $connexion->prepare("DELETE FROM reservations WHERE id_reservation = :id");
        $suppression_reserv->bindParam(':id', $_GET['id_reservation']);
        $suppression_reserv->execute();

        //On vérifie qu'il y'a toujours des réservations. Si on supprime la dernière réservation qu'il y'avait sur un voyage, le changement ne se fait pas bien.
        $verif_nombre = "SELECT sum(R.nombre_personnes) as nb_pers FROM reservations R WHERE R.id_destination = :idD";
        $verif_places_restantes = $connexion->prepare($verif_nombre);
        $verif_places_restantes->bindParam(':idD', $_GET['id_destination']);
        $verif_places_restantes->execute();
        $resultat_verif = $verif_places_restantes->fetch(PDO::FETCH_OBJ);

        //On modifie le nombre de places restantes suite à la réservation supprimée.
        if($resultat_verif->nb_pers == null){ //Si on n'a plus de résultats, alors on met 0...
            $modif_places_dest = $connexion->prepare("UPDATE destination D SET D.nb_reserves = 0 WHERE D.id_destination = :idD");
            $modif_places_dest->bindParam(':idD', $_GET['id_destination']);
            $modif_places_dest->execute();
        }else{ //..Sinon, on soustrait par le nombre de places réservées.
            $modif_nb_places_dest = $connexion->prepare("UPDATE destination D SET D.nb_reserves = (SELECT sum(R.nombre_personnes) as nb_pers FROM reservations R WHERE R.id_destination = :idD) WHERE D.id_destination = :idR");
            $modif_nb_places_dest->bindParam(':idD', $_GET['id_destination']);
            $modif_nb_places_dest->bindParam(':idR', $_GET['id_destination']);
            $modif_nb_places_dest->execute();
        }
        header('Location: mon_profil.php?client='. $_SESSION['id'] . '&sup=true');
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
    <?php require_once("appelHeader.php");?>
</header>
<main>
    <p>Souhaitez-vous vraiment vous faire rembourser le voyage : <?=$nom->nom?> ? </p>
    <form method="post" action="remboursement.php?id_reservation=<?=$_GET['id_reservation']?>&id_destination=<?=$_GET['id_destination']?>">
        <input type="submit" name="rembourser" id="rembourser" value="Oui, je veux être remboursé">
        <a href="mon_profil.php?id=<?=$_SESSION['id']?>">Retourner sur mon profil</a>
    </form>
</main>
<?php require_once("footer.php");?>
<script text="text/javascript" src="js/comportement.js"></script>
</body>



</html>
