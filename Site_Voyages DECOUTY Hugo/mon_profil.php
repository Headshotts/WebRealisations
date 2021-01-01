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


    // PARTIE INFORMATION PERSONNELLES
    if(isset($_POST['btnSubmit-profile'])){
        //Si toute la partie 'Mdp' est vide, alors on fera un changement sans mdp à l'intérieur de la requête.
        if(empty($_POST['ancient_mdp'] && empty($_POST['new_mdp'] && empty($_POST['new_mdp_c'])))){
            //On récupère les données du $_POST
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $mail = htmlspecialchars($_POST['mail']);
            $tel = htmlspecialchars($_POST['tel']);
            //Si le mail a été modifié, on regarde bien qu'il y'a unicité par rapport à la boîte mail (Pas deux e-mails pareils dans la BDD).
            if($_POST['mail'] != $_SESSION['mail']){
                $email_exists = $connexion->prepare("SELECT mail from clients WHERE mail = :mail");
                $email_exists->bindParam(':mail', $mail);
                $email_exists->execute();
                $result = $email_exists->fetch(PDO::FETCH_OBJ);
                if($result->mail == null){ //Si il n'existe pas de clients qui ont ce mail, alors on insère les modifications dans la BDD.
                    $modification = $connexion->prepare("UPDATE clients SET nom = :nom, prenom = :prenom, mail = :mail, tel = :tel WHERE id_client = :id");
                    $modification->bindParam(':nom', $nom);
                    $modification->bindParam(':prenom', $prenom);
                    $modification->bindParam(':mail', $mail);
                    $modification->bindParam(':tel', $tel);
                    $modification->bindParam(':id', $_GET['client']);
                    $modification->execute();

                    //On redéfinit les variables de sessions.
                    $_SESSION['nom'] = $nom;
                    $_SESSION['prenom'] = $prenom;
                    $_SESSION['mail'] = $mail;
                    $_SESSION['tel'] = $tel;
                    header('Location: mon_profil.php?client=' . $_GET['client'] . '&change=true');

                }else{ //Si un client possède déjà cette adresse-mail, alors on redirige vers une erreur.
                    header('Location: mon_profil.php?client=' . $_GET['client'] . '&change_mail=false');
                }
            }else{ //Si il y'a bien unicité par rapport à la boîte mail, alors on insère directement.
                $modification = $connexion->prepare("UPDATE clients SET nom = :nom, prenom = :prenom, tel = :tel WHERE id_client = :id");
                $modification->bindParam(':nom', $nom);
                $modification->bindParam(':prenom', $prenom);
                $modification->bindParam(':tel', $tel);
                $modification->bindParam(':id', $_GET['client']);
                $modification->execute();

                //On redéfinit les variables de sessions.
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['mail'] = $mail;
                $_SESSION['tel'] = $tel;
                header('Location: mon_profil.php?client=' . $_GET['client'] . '&change=true');
            }


            //Si toute la partie 'Mdp' est remplie, alors on fera un changement avec le mdp à l'intérieur de la requête.
        }else if(!empty($_POST['ancient_mdp'] && !empty($_POST['new_mdp'] && !empty($_POST['new_mdp_c'])))){

            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $ancient_mdp = htmlspecialchars($_POST['ancient_mdp']);
            $new_mdp = htmlspecialchars($_POST['new_mdp']);
            $new_mdp_c = htmlspecialchars($_POST['new_mdp_c']);
            $mail = htmlspecialchars($_POST['mail']);
            $tel = htmlspecialchars($_POST['tel']);
            //On vérifie que l'utilisateur écrit bien son ancien mot de passe.
            $verif_ancient_mdp = $connexion->prepare("SELECT mdp FROM Clients WHERE id_client = :id");
            $verif_ancient_mdp->bindParam(':id', $_GET['client']);
            $verif_ancient_mdp->execute();
            $result_ancient_mdp = $verif_ancient_mdp->fetch(PDO::FETCH_OBJ);

            //Si l'ancien mot de passe qu'on souhaite modifier n'est pas celui attendu, où que les deux mots de passes de confirmation ne sont pas identiques
            if($result_ancient_mdp->mdp == $_POST['ancient_mdp'] && $new_mdp == $new_mdp_c){
                if($_POST['mail'] != $_SESSION['mail']){
                    $email_exists = $connexion->prepare("SELECT mail from clients WHERE mail = :mail");
                    $email_exists->bindParam(':mail', $mail);
                    $email_exists->execute();
                    $result = $email_exists->fetch(PDO::FETCH_OBJ);
                    if($result->mail == null) { //Si il n'existe pas de clients qui ont ce mail, alors on insère les modifications dans la BDD.
                        $modification = $connexion->prepare("UPDATE clients SET nom = :nom, prenom = :prenom, mdp = :mdp, mail = :mail, tel = :tel WHERE id_client = :id");
                        $modification->bindParam(':nom', $nom);
                        $modification->bindParam(':prenom', $prenom);
                        $modification->bindParam(':mdp', $new_mdp);
                        $modification->bindParam(':mail', $mail);
                        $modification->bindParam(':tel', $tel);
                        $modification->bindParam(':id', $_GET['client']);
                        $modification->execute();

                        //On redéfinit les variables de sessions.
                        $_SESSION['nom'] = $nom;
                        $_SESSION['prenom'] = $prenom;
                        $_SESSION['mdp'] = $new_mdp;
                        $_SESSION['mail'] = $mail;
                        $_SESSION['tel'] = $tel;
                        header('Location: mon_profil.php?client=' . $_GET['client'] . '&change=true');
                    }else{ //Si un client possède déjà cette adresse-mail, alors on redirige vers une erreur.
                        header('Location: mon_profil.php?client=' . $_GET['client'] . '&change_mail=false');
                    }
                }else{
                    $modification = $connexion->prepare("UPDATE clients SET nom = :nom, prenom = :prenom, mdp = :mdp, tel = :tel WHERE id_client = :id");
                    $modification->bindParam(':nom', $nom);
                    $modification->bindParam(':prenom', $prenom);
                    $modification->bindParam(':mdp', $new_mdp);
                    $modification->bindParam(':tel', $tel);
                    $modification->bindParam(':id', $_GET['client']);
                    $modification->execute();

                    //On redéfinit les variables de sessions.
                    $_SESSION['nom'] = $nom;
                    $_SESSION['prenom'] = $prenom;
                    $_SESSION['mdp'] = $new_mdp;
                    $_SESSION['tel'] = $tel;
                    header('Location: mon_profil.php?client=' . $_GET['client'] . '&change=true');
                }

            }else{
                header('Location: mon_profil.php?client=' . $_GET['client'] . '&change_mdp=false');
            }

            //Sinon, on provoque une erreur car un des éléments de la partie 'Mdp' est vide.
        }else{
            header('Location: mon_profil.php?client=' . $_GET['client'] . '&change_mdp=false');
        }
    }

    /* TODO : Ecrire erreurs GET -> change_mdp, error_mail */

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
    <!--Réservation / Suppression -->
    <?php if($sup):?>
        <div class="erreur-profile"><p><img src="images/site/valider.jpg">Suppression de la réservation réussie. Remboursement effectué.</p></div>
    <?php endif;?>
    <?php if(isset($_GET['reserv'])):?>
        <div class="erreur-profile"><p><img src="images/site/valider.jpg">Réservation pour le voyage <?=$_GET['nom_dest']?> effectuée !</p></div>
    <?php endif;?>

    <!-- Changement des informations personnelles -->
    <?php if(isset($_GET['change'])):?>
        <div class="erreur-profile"><p><img src="images/site/valider.jpg">Changement réussi !</p></div>
    <?php endif;?>
    <?php if(isset($_GET['change_mdp'])):?>
        <div class="erreur-profile"><p><img src="images/site/danger.jpg">Mot de passe incorrect, champ non rempli, ou mots de passe non identique.</p></div>
    <?php endif;?>
    <?php if(isset($_GET['change_mail'])):?>
        <div class="erreur-profile"><p><img src="images/site/danger.jpg">E-mail existe déjà.</p></div>
    <?php endif;?>
    <form id="form-profile" method="post" action="mon_profil.php?client=<?= $_GET['client']?>">
        <h1>Informations personnelles</h1>
        <p>
            <label for="nom">Votre nom :</label> <!-- Si la personne est connectée, écrire directement son nom dans le formulaire !-->
            <input type="text" id="nom" name="nom" placeholder="(20 caractères maximum)" value="<?=$_SESSION['nom']?>" required autofocus>
        <p>
            <label for="prenom">Votre prénom : </label>
            <input type="text" id="prenom" name="prenom" placeholder="(15 caractères maximum)" value="<?=$_SESSION['prenom']?>" required>
        </p>
        <p>
            <label for="ancient_mdp">Ancien mot de passe : </label>
            <input type="password" id="ancient_mdp" name="ancient_mdp">
        </p>
        <p>
            <label for="new_mdp">Votre nouveau mot de passe : </label>
            <input type="password" id="new_mdp" name="new_mdp" placeholder="(20 caractères maximum)">
        </p>
        <p>
            <label for="new_mdp_c">Confirmez votre mot de passe : </label>
            <input type="password" id="new_mdp" name="new_mdp_c">
        </p>
        <p>
            <label for="mail">Votre email : </label>
            <input type="email" id="mail" name="mail" value="<?=$_SESSION['mail']?>">
        </p>
        <p>
            <label for="tel">Votre numéro de téléphone : </label>
            <input type="tel" id="tel" name="tel" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}" placeholder="exemple : '00-00-00-00-00'" value="<?=$_SESSION['tel']?>" required>
        </p>
        <input type="submit" id="btnSubmit-profile" name="btnSubmit-profile" value="Accepter les modifications">
    </form>
    <div id="reserv-profile"><h1>Réservations</h1></div>
    <p id="nb-reserv-profile">Vous avez <?=$resultat_nb->nombres?> réservations en cours. </p>
    <?php if($resultat_nb->nombres > 0):?>
        <table id="table_reservation">
            <tr><th>Nom du voyage</th><th>Prix du voyage</th><th>Date de départ</th><th>Nombre de personnes</th></tr>
            <?php foreach($_SESSION['reservation'] as $key => $values):?>
                <tr id="tr_reservation"><td><a href="remboursement.php?id_reservation=<?=$values->id_reservation?>&id_destination=<?=$values->id_destination?>"><?=$values->nom?></a></td><td><?=$values->prix?></td><td><?=$values->date_debut?></td><td><?=$values->nombre_personnes?></td></tr>
            <?php endforeach;?>
        </table>
    <?php endif;?>


    <?php require_once("footer.php");?>
</main>
<script type="text/javascript" src="js/comportement.js"></script>
</body>



</html>
