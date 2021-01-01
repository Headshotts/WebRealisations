<?php
    session_start();

    use app\controller\controllerReservation;
    use app\controller\controllerVoyage;
//Site qui sert au remboursement d'un voyage.
    spl_autoload_register('chargerClasse'); //Autoload
    function chargerClasse($classe) {
        $classe = str_replace('\\', '/', $classe);
        require $classe . '.php';
    }

    $reserv = new controllerReservation();
    $voyage = new controllerVoyage();
    //Pour éviter que quelqu'un qui ne soit pas connecté puisse arriver sur cette page
    if(!isset($_SESSION['id'])){
        header('Location: login.php');
    }

    if(isset($_POST['rembourser'])){

        //On supprime la réservation en question.

        $reserv->deleteReserv($_GET['id_reservation']);

        header('Location: mon_profil.php?client='. $_SESSION['id'] . '&sup=true');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>TripAirplanes - Remboursement</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
<?php require_once("appelHeader.php");?>
<main>
    <?php $voyage->NameDestFromId($_GET['id_destination']);?>
</main>
<?php require_once("footer.php");?>
<script type="text/javascript" src="js/comportement.js"></script>
</body>



</html>
