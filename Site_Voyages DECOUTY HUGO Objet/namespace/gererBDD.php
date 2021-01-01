<?php
    session_start();
    include_once("app/controller/controllerVoyage.php");


    spl_autoload_register('chargerClasse'); //Autoload
    function chargerClasse($classe) {
        $classe = str_replace('\\', '/', $classe);
        require $classe . '.php';
    }
    $voyage = new app\Controller\controllerVoyage();

    if($_SESSION['statut'] == 'Admin'){ //Pour être sûr que la personne qui se connecte a bien le statut Admin, sinon on le redirige sur la page d'accueil.
        $dest_fichier = "images/"; //Chemin relatif vers le dossier où stocker l'image.
        if(isset($_POST['submit_ajout'])){
            if(strlen(htmlspecialchars($_POST['description'])) > 300) { //300 caractères pour le textarea de gererBDD.php (Description).
                header('Location: gererBDD.php?error=fulldescription');
            }elseif(strlen(htmlspecialchars($_POST['image'])) > 250) { //250 caractères pour l'URL de l'image de ma BDD.
                header('Location: gererBDD.php?error=fullImageURL');
            }elseif(strlen(htmlspecialchars($_POST['nom'])) > 40) { //40 caractères pour la taille du nom du voyage pour le stocker dans ma BDD.
                header('Location: gererBDD.php?error=fullTravelName');
            }else {
                $nom = htmlspecialchars($_POST['nom']);
                $description = htmlspecialchars($_POST['description']);
                $transport = $_POST['transport'][0];
                $nb_places = htmlspecialchars($_POST['nb_places']);
                $prix = htmlspecialchars($_POST['prix']);
                $handicap = $_POST['handicap'][0];
                $image = $dest_fichier . htmlspecialchars($_FILES['voyage']['name']);
                move_uploaded_file($_FILES['voyage']['tmp_name'], $dest_fichier . htmlspecialchars($_FILES['voyage']['name']));
                if($image == "images/"){ //Si il n'y a pas d'image choisi, on prend celle par défaut.
                    $image = "images/default.jpg";
                }
                //On ajoute la destination à la BDD.
                $voyage->insertDest($nom, $description, $transport, $nb_places, $prix, $handicap, $image);

                header('Location: gererBDD.php');
            }
        }
    }else{
        header('Location: index.php');
    }



    /*      PARTIE DELETE       */
    if(isset($_POST['submit_retrait'])){
        $voyage->deleteDest($_POST['destination'][0]);
        header('Location: gererBDD.php');

    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>TripAirplanes - GererBDD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body id="body-gerer">
    <?php require_once('appelHeader.php');?>
    <main id="main-gerer">
        <?php if(isset($_GET['error']) && $_GET['error'] === 'fulldescription'):?>
            <div class="erreur-login"><p><img src="images/site/danger.jpg">Description trop longue (300 caractères maximum).</p></div>
        <?php endif;?>
        <?php if(isset($_GET['error']) && $_GET['error'] === 'fullImageURL'):?>
            <div class="erreur-login"><p><img src="images/site/danger.jpg">Le nom de l'image est trop long (250 caractères maximum).</p></div>
        <?php endif;?>
        <?php if(isset($_GET['error']) && $_GET['error'] === 'fullTravelName'):?>
            <div class="erreur-login"><p><img src="images/site/danger.jpg">Nom de voyage trop long (40 caractères maximum).</p></div>
        <?php endif;?>
        <section class="flex">
            <article class="flex_gerer">
                <div class="h2_gerer">
                    <h2>Ajouter un voyage</h2>
                </div>
                <div class="content">
                    <form method="post" action="gererBDD.php" enctype="multipart/form-data">
                        <p>
                            <label for="nom">Nom du voyage :</label>
                            <input type="text" size="40" name="nom" id="nom" placeholder="(40 caractères maximum)" required>
                        </p>
                        <p>
                            <label for="description">Description : </label>
                            <textarea type="text" name="description" id="description" placeholder="Présenter le trajet, les réservations possibles, les qualités du trajet, le prix... (300 caractères maximum)" required></textarea>
                        </p>
                        <p>
                            <label for="transport[]">Type de transport : </label>
                            <select id="transport[]" name="transport[]" size="1"> <!-- multiple="multiple" !-->
                                <option value="Route" >Route</option>
                                <option value="Train">Train</option>
                                <option value="Avion" selected="selected">Avion</option>
                                <option value="Bateau">Bateau</option>
                                <!--<option value="Autres">Autres</option>-->
                            </select>
                        </p>
                        <p>
                            <label for="nb_places">Nombre de places disponibles : </label>
                            <input type="number" name="nb_places" id="nb_places" min="0" max="10000" required>
                        </p>
                        <p>
                            <label for="prix">Prix :</label>
                            <input type="number" step="0.01" min="0.00" max="10000.00" placeholder="Exemple : '0.00' ou '29'" pattern="[0-9]{1, },[[0-9]]{2}$" name="prix" id="prix" required>
                        </p>
                        <p>
                            <label for="handicap[]">Places handicapés ?</label>
                            <input type="radio" name="handicap[]" value="Y">Oui
                            <input type="radio" name="handicap[]" checked="checked" value="N">Non
                        </p>
                        <p>
                            <label for="voyage">Image du voyage (libre de droit !)</label>
                            <input type="file" name="voyage" accept="image/jpeg, image/png">
                        </p>
                        <div class="zone_submit">
                            <input type="submit" name="submit_ajout" value="Ajouter le voyage">
                        </div>
                    </form>
                </div>

            </article>
            <article class="flex_gerer">
                <div class="h2_gerer">
                    <h2>Supprimer un voyage</h2>
                </div>
                <div class="content">
                    <?php $voyage->findDestination() ?>
                </div>
            </article>

        </section>
    </main>
<?php require_once("footer.php");?>
<script text="text/javascript" src="js/comportement.js"></script>
</body>



</html>
