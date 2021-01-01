<?php
    session_start();
    include_once('connexion.php');
    include_once('fonctions.php');
    $connexion = connexionBd();
    //ALTER TABLE reservations ADD CONSTRAINT reservations_clients_C FOREIGN KEY (client) REFERENCES client(id_client) ON DELETE CASCADE.
    //ALTER TABLE reservations ADD CONSTRAINT reservations_dest_C FOREIGN KEY (destination) REFERENCES destination(id_destination) ON DELETE CASCADE.

    if($_SESSION['statut'] == 'Admin'){ //Pour être sûr que la personne qui se connecte a bien le statut Admin, sinon on le redirige sur la page d'accueil.
        $dest_fichier = "images/"; //Chemin relatif vers le dossier où stocker l'image.
        if(isset($_POST['submit_ajout'])){
            if(strlen($_POST['description']) > 300) { //300 caractères fait référence au textarea de gererBDD.php (Description).
                echo "Trop de caractères dans la partie 'Description' (300 caractères maximum)";
                //Faire des strlen pour $_POST['nom']...
            }else {
                $nom = $_POST['nom'];
                $description = $_POST['description'];
                $transport = $_POST['transport'][0];
                $nb_places = $_POST['nb_places'];
                $prix = $_POST['prix'];
                $handicap = $_POST['handicap'][0];
                $image = $dest_fichier . $_FILES['voyage']['name'];
                move_uploaded_file($_FILES['voyage']['tmp_name'], $dest_fichier . $_FILES['voyage']['name']);
                if($image == "images/"){ //Si il n'y a pas d'image choisi, on prend celle par défaut.
                    $image = "images/default.jpg";
                }
                //On ajoute la destination à la BDD.
                $ajout_requete = $connexion->prepare("INSERT INTO destination(nom, description, transport, nbplaces, prix, handicap, image) VALUES (:nom, :description, :transport, :nb_places, :prix, :handicap, :image)");
                $ajout_requete->bindParam(':nom', $nom);
                $ajout_requete->bindParam(':description', $description);
                $ajout_requete->bindParam(':transport', $transport);
                $ajout_requete->bindParam(':nb_places', $nb_places);
                $ajout_requete->bindParam(':prix', $prix);
                $ajout_requete->bindParam(':handicap', $handicap);
                $ajout_requete->bindParam(':image', $image);
                $ajout_requete->execute();
                header('Location: gererBDD.php');
            }
        }
    }else{
        header('Location: index.php');
    }



    /*      PARTIE DELETE       */
    $destination =  "SELECT * FROM Destination"; //On les récupères tous afin de les afficher dans la barre déroulante.
    $count_d = $connexion->query($destination);
    $resultat_d = $count_d->fetchALL(PDO::FETCH_OBJ);

    if(isset($_POST['submit_retrait'])){
        $enlever_voyage = $_POST['destination'][0];

        $enlever_requete = $connexion->prepare("DELETE FROM destination WHERE iddestination = :id");
        $enlever_requete->bindParam(':id', $enlever_voyage);
        $enlever_requete->execute();

        //          Après suppression, l'auto-increment est redéfini pour obtenir une suite logique d'identifiants. (excepté si l'élément supprimé n'est pas le dernier élément).
        $remettre_Auto_Increment = "ALTER TABLE destination AUTO_INCREMENT= 1";
        $count_AI = $connexion->exec($remettre_Auto_Increment);
        header('Location: gererBDD.php');
    }
?>

<!DOCTYPE html>
<html lang="fr">
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
<br><br>
<main>
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
                            <option value="Autres">Autres</option>
                        </select>
                    </p>
                    <p>
                        <label for="nb_places">Nombre de places disponibles : </label>
                        <input type="number" name="nb_places" id="nb_places" required>
                    </p>
                    <p>
                        <label for="prix">Prix :</label>
                        <input type="number" step="0.01" min="0.00" placeholder="Exemple : '0.00' ou '29'" pattern="[0-9]{1, },[[0-9]]{2}$" name="prix" id="prix" required>
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
                <form method="post" action="gererBDD.php">
                    <p>
                        <label for="destination">Destination à supprimer : </label>
                        <select id="destination" name="destination[]">
                            <?php foreach($resultat_d as $key => $values):?>
                                <option value="<?=$values->id_destination?>"><?=$values->id_destination . " : " . $values->nom?></option>
                            <?php endforeach;?>
                        </select>
                    </p>
                    <div class="zone_submit">
                        <input type="submit" name="submit_retrait" id="submit_retrait" value="Supprimer le voyage">
                    </div>
                </form>
            </div>
        </article>

    </section>
</main>
<?php require_once("footer.php");?>
<script text="text/javascript" src="js/comportement.js"></script>
</body>



</html>
