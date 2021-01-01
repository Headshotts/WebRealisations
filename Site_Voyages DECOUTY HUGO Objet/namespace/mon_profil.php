<?php
    session_start();
    include_once("app/controller/controllerClient.php");
    include_once("app/controller/controllerVoyage.php");
    include_once("app/controller/controllerReservation.php");

    spl_autoload_register('chargerClasse'); //Autoload
    function chargerClasse($classe) {
        $classe = str_replace('\\', '/', $classe);
        require $classe . '.php';
    }
    $client = new app\controller\controllerClient();
    $voyage = new app\Controller\controllerVoyage();
    $reserv = new app\Controller\controllerReservation();

//Ce site sert à ce que l'utilisateur puisse voir son profil. Pour le moment, seul le remboursement d'un voyage a été défini sur la page.

    //Pour éviter que quelqu'un qui ne soit pas connecté puisse arriver sur cette page
    if(!isset($_SESSION['id'])){
        header('Location: login.php');
    }

    //Savoir combien il y'a de réservations :
    $_SESSION['reservation'] = $reserv->HistoricalReservations($_SESSION['id']);

    // PARTIE INFORMATION PERSONNELLES
    $WorkingFunction = false;

    if(isset($_POST['btnSubmit-profile'])){
        //Si toute la partie 'Mdp' est vide, alors on fera un changement sans mdp à l'intérieur de la requête.
        if(empty($_POST['ancient_mdp']) && empty($_POST['new_mdp']) && empty($_POST['new_mdp_c'])){
            //On récupère les données du $_POST
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $mail = htmlspecialchars($_POST['mail']);
            $tel = htmlspecialchars($_POST['tel']);
            //Si le mail a été modifié, on regarde bien qu'il y'a unicité par rapport à la boîte mail (Pas deux e-mails pareils dans la BDD).
            if($_POST['mail'] != $_SESSION['mail']){
                $email_exists = $client->searchClientWithMail($mail);

                if(is_null($email_exists[0])){ //Si il n'existe pas de clients qui ont ce mail, alors on insère les modifications dans la BDD.
                    $changement_mdp = false;
                    $WorkingFunction = true;

                }else{ //Si un client possède déjà cette adresse mail, alors on redirige vers une erreur.
                    header('Location: mon_profil.php?client=' . $_SESSION['id'] . '&change_mail=false');
                }
            }else{ //Si il y'a bien unicité par rapport à la boîte mail, alors on insère directement.
                $changement_mdp = false;
                $WorkingFunction = true;

            }


            //Si toute la partie 'Mdp' est remplie, alors on fera un changement avec le mdp à l'intérieur de la requête.
        }else if(!empty($_POST['ancient_mdp']) && !empty($_POST['new_mdp']) && !empty($_POST['new_mdp_c'])){
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $ancient_mdp = htmlspecialchars($_POST['ancient_mdp']);
            $new_mdp = htmlspecialchars($_POST['new_mdp']);
            $new_mdp_c = htmlspecialchars($_POST['new_mdp_c']);
            $mail = htmlspecialchars($_POST['mail']);
            $tel = htmlspecialchars($_POST['tel']);
            //On vérifie que l'utilisateur écrit bien son ancien mot de passe.
            //Si l'ancien mot de passe qu'on souhaite modifier n'est pas celui attendu, où que les deux mots de passes de confirmation ne sont pas identiques
            if($client->MdpExistsInDatabase($_SESSION['id'])[0]->getMdp() == $_POST['ancient_mdp'] && $new_mdp == $new_mdp_c){
                if($_POST['mail'] != $_SESSION['mail']){

                    $email_exists = $client->searchClientWithMail($mail);

                    if(is_null($email_exists[0])) { //Si il n'existe pas de clients qui ont ce mail, alors on insère les modifications dans la BDD.
                        $changement_mdp = true;
                        $WorkingFunction = true;

                    }else{ //Si un client possède déjà cette adresse-mail, alors on redirige vers une erreur.
                        header('Location: mon_profil.php?client=' . $_SESSION['id'] . '&change_mail=false');
                    }
                }else{
                    $changement_mdp = true;
                    $WorkingFunction = true;
                }

            }else{
                header('Location: mon_profil.php?client=' . $_SESSION['id'] . '&change_mdp=false');
            }

            //Sinon, on provoque une erreur car un des éléments de la partie 'Mdp' est vide.
        }else{
            header('Location: mon_profil.php?client=' . $_SESSION['id'] . '&change_mdp=false');
        }

        if(strlen(htmlspecialchars($_POST['nom'])) > 20 || strlen(htmlspecialchars($_POST['prenom'])) > 15 || strlen(htmlspecialchars($_POST['mdp'])) > 20 || strlen(htmlspecialchars($_POST['mail'])) > 80){
            header('Location: mon_profil.php?client=' . $_SESSION['id'] . '&error=full');
        }else{
            if($changement_mdp && $WorkingFunction){
                $client->UpdateWithPasswordFields($nom, $prenom, $new_mdp, $mail, $tel, $_SESSION['id']);

                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['mdp'] = $new_mdp;
                $_SESSION['mail'] = $mail;
                $_SESSION['tel'] = $tel;
                header('Location: mon_profil.php?client=' . $_SESSION['id'] . '&change=true');
            }else if(!($changement_mdp) && $WorkingFunction){
                $client->UpdateWithoutPasswordFields($nom, $prenom, $mail, $tel, $_SESSION['id']);

                //On redéfinit les variables de sessions.
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['mail'] = $mail;
                $_SESSION['tel'] = $tel;
                header('Location: mon_profil.php?client=' . $_SESSION['id'] . '&change=true');
            }
        }

    }


?>

<!DOCTYPE html>
<html>
<head>
    <title>TripAirplanes - Mon Profil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
<?php require_once('appelHeader.php');?>
<main>
    <!--Réservation / Suppression -->
    <?php if(isset($_GET['sup']) && $_GET['sup'] === 'true'):?>
        <div class="erreur-profile"><p><img src="images/site/valider.jpg">Suppression de la réservation réussie. Remboursement effectué.</p></div>
    <?php endif;?>
    <?php if(isset($_GET['reserv']) && $_GET['reserv'] === 'true'):?>
        <div class="erreur-profile"><p><img src="images/site/valider.jpg">Réservation pour <?=$_GET['nom_dest']?> effectuée !</p></div>
    <?php endif;?>

    <!-- Changement des informations personnelles -->
    <?php if(isset($_GET['change']) && $_GET['change'] === 'true'):?>
        <div class="erreur-profile"><p><img src="images/site/valider.jpg">Changement réussi !</p></div>
    <?php endif;?>
    <?php if(isset($_GET['change_mdp']) && $_GET['change_mdp'] === 'false'):?>
        <div class="erreur-profile"><p><img src="images/site/danger.jpg">Mot de passe incorrect, champ non rempli, ou mots de passe non identique.</p></div>
    <?php endif;?>
    <?php if(isset($_GET['change_mail']) && $_GET['change_mail'] === 'false'):?>
        <div class="erreur-profile"><p><img src="images/site/danger.jpg">E-mail existe déjà.</p></div>
    <?php endif;?>
    <?php if(isset($_GET['error']) && $_GET['error'] === 'full'):?>
        <div class="erreur-profile"><p><img src="images/site/danger.jpg">Veuillez respecter le nombre maximal de caractères.</p></div>
    <?php endif;?>


    <!--Vue jusqu'à form -->
    <form id="form-profile" method="post" action="mon_profil.php?client=<?= $_GET['client']?>">
        <h1>Informations personnelles</h1>
        <p>
            <label for="nom">Votre nom :</label>
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
            <input type="email" id="mail" name="mail" value="<?=$_SESSION['mail']?>" required>
        </p>
        <p>
            <label for="tel">Votre numéro de téléphone : </label>
            <input type="tel" id="tel" name="tel" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}" placeholder="exemple : '00-00-00-00-00'" value="<?=$_SESSION['tel']?>" required>
        </p>
        <input type="submit" id="btnSubmit-profile" name="btnSubmit-profile" value="Accepter les modifications">
    </form>
    <?php $reserv->showNumberofReservations($_SESSION['id']);?>


    <?php require_once("footer.php");?>
</main>
<script type="text/javascript" src="js/comportement.js"></script>
</body>



</html>
