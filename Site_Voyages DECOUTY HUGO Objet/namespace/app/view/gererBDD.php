<?php
    //$connexion = connexionBd();
    //ALTER TABLE reservations ADD CONSTRAINT reservations_clients_C FOREIGN KEY (client) REFERENCES client(id_client) ON DELETE CASCADE.
    //ALTER TABLE reservations ADD CONSTRAINT reservations_dest_C FOREIGN KEY (destination) REFERENCES destination(id_destination) ON DELETE CASCADE.

/*
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
                $ajout_requete = $connexion->prepare("INSERT INTO destination(nom, description, transport, nb_places, prix, handicap, image) VALUES (:nom, :description, :transport, :nb_places, :prix, :handicap, :image)");
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
    }*/



    /*      PARTIE DELETE       */
/*
    $destination =  "SELECT * FROM Destination"; //On les récupères tous afin de les afficher dans la barre déroulante.
    $count_d = $connexion->query($destination);
    $resultat_d = $count_d->fetchALL(PDO::FETCH_OBJ);

    if(isset($_POST['submit_retrait'])){
        $enlever_voyage = $_POST['destination'][0];

        $enlever_requete = $connexion->prepare("DELETE FROM destination WHERE id_destination = :id");
        $enlever_requete->bindParam(':id', $enlever_voyage);
        $enlever_requete->execute();

        //          Après suppression, l'auto-increment est redéfini pour obtenir une suite logique d'identifiants. (excepté si l'élément supprimé n'est pas le dernier élément).
        $remettre_Auto_Increment = "ALTER TABLE destination AUTO_INCREMENT= 1";
        $count_AI = $connexion->exec($remettre_Auto_Increment);
        header('Location: gererBDD.php');
    }*/
?>

<form method="post" action="gererBDD.php">
    <p>
        <label for="destination">Destination à supprimer : </label>
        <select id="destination" name="destination[]">
            <?php foreach($content as $key => $values):?>
                <option value="<?=$values->getIdDestination()?>"><?=$values->getIdDestination() . " : " . $values->getNom()?></option>
            <?php endforeach;?>
        </select>
    </p>
    <div class="zone_submit">
        <input type="submit" name="submit_retrait" id="submit_retrait" value="Supprimer le voyage">
    </div>
</form>

