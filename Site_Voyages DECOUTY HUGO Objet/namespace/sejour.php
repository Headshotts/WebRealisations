<?php
    session_start();
    //Séjour correspondant au modèle de chaque voyage
    include_once("app/controller/controllerVoyage.php");
    include_once("app/controller/controllerReservation.php");

    spl_autoload_register('chargerClasse'); //Autoload
    function chargerClasse($classe) {
        $classe = str_replace('\\', '/', $classe);
        require $classe . '.php';
    }
    $voyage = new app\controller\controllerVoyage();

?>

<!DOCTYPE html>
<html>
<head>
    <title>TripAirplanes - Séjour</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
    <?php require_once('appelHeader.php');?>
    <main>
        <?php $voyage->getDestbyId($_GET['id_destination']);?>
    </main>
<br><br>

<?php require_once("footer.php");?>
<script text="text/javascript" src="js/comportement.js"></script>
</body>



</html>
