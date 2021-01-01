<?php
include_once("app/controller/controllerVoyage.php");
session_start();

spl_autoload_register('chargerClasse'); //Autoload
function chargerClasse($classe) {
    $classe = str_replace('\\', '/', $classe);
    require $classe . '.php';
}
$voyage = new app\controller\controllerVoyage();


if(isset($_POST['btnSubmit-show-voyages'])){
    if(empty($_POST['nbplaces'])){
        $nbplaces = 0; //Par défaut, on suppose que la personne souhaite juste chercher des voyages.
    }else{
        $nbplaces = htmlspecialchars($_POST['nbplaces']);
    }

    $transport = $_POST['transport'][0];
    if($transport == 'All'){
        $transport = '';
    }else{
        $transport = " AND transport = " . "'" . $_POST['transport'][0] . "'" . " ";
    }

    if(empty($_POST['prix'])){
        $prix = 10000; //Prix maximal d'une place que l'on peut attribuer à une destination.
    }else{
        $prix = htmlspecialchars($_POST['prix']);
    }

    if(isset($_POST['handicap-show-voyages'])){
        if($_POST['handicap-show-voyages'] == 'Y'){
            $handicap = 'Y';
        }else {
            $handicap = 'N';
        }
    }else{
        $handicap = 'N';
    }

    if(isset($_POST['ratioplacesNotFull'])){
        if($_POST['ratioplacesNotFull'] == 'Yes'){
            $ratioplaces = '<=';  //Prend en considération les réservations pleines
        }else{
            $ratioplaces = '<';
        }
    }else{
        $ratioplaces = '<';  //Ne prend pas en compte les ratioplaces qui valent 100, donc ne prennent pas en considération les réservations pleines.
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>TripAirplanes - Voyages</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
<?php require_once('appelHeader.php');?>
<main>
    <h2 id="h2-show">Voyages disponibles</h2>
    <!-- Recherche filtrée -->
    <div id="background-form-show-voyages">
        <form id="form-show-voyages" method="post" action="presentation_voyages.php">
            <div id="div-flex-border-form-show-voyages">
                <div class="border-form-show-voyages">
                    <label for="nbplaces-show-voyages">Nombres de personnes : </label><br>
                    <input type="number" min="0" max="1000" step="1" name="nbplaces" id="nbplaces-show-voyages" placeholder="Entre 1 et 1000">
                </div>
                <div class="border-form-show-voyages">
                    <label for="transport-show-voyages">Type de transport : </label><br>
                    <select id="transport-show-voyages" name="transport[]" size="1">
                        <option value="All">Tous les transports</option>
                        <option value="Avion">Avion</option>
                        <option value="Bateau">Bateau</option>
                        <option value="Route">Route</option>
                        <option value="Train">Train</option>
                    </select>
                </div>
                <div class="border-form-show-voyages">
                    <label for="prix-show-voyages">Prix maximum/personne : </label><br>
                    <input type="number" min="0" max="1000" step="0.01" pattern="[0-9]{1, },[[0-9]]{2}$" name="prix" id="prix-show-voyages" placeholder="Exemple : 0.00 ou 29">
                </div>
                <div class="border-form-show-voyages">
                    <input id="btnSubmit-show-voyages" type="submit" name="btnSubmit-show-voyages" value="Rechercher">
                </div>
            </div>
            <div id="checkbox-form-show-voyages">
                <input type="checkbox" name="handicap-show-voyages" value="Y">Afficher les places handicapés
                <input type="checkbox" name="ratioplacesNotFull" value="Yes" checked="checked">Afficher les réservations pleines
            </div>
        </form>
    </div>

    <?php if(isset($_POST['btnSubmit-show-voyages'])){
        $voyage->FilterSearch($nbplaces, $transport, $prix, $handicap, $ratioplaces);
    }else{
        $voyage->showVoyages_c();
    }?>
    <?php require_once("footer.php");?>
</main>
<script text="text/javascript" src="js/comportement.js"></script>
</body>



</html>
