<?php

    //Page de connexion pour tout utilisateur
    include_once("app/controller/ControllerClient.php");
    include_once("app/controller/ControllerReservation.php");
    use app\controller\controllerClient;
    use app\controller\controllerReservation;
    $client = new controllerClient();
    $reserv = new controllerReservation();


    spl_autoload_register('chargerClasse'); //Autoload
    function chargerClasse($classe) {
        $classe = str_replace('\\', '/', $classe);
        require $classe . '.php';
    }

    $pas_correspondance = false;
    if(isset($_POST['btnSubmit_connexion'])) {
        $mail_Login = htmlspecialchars($_POST['mail']);
        $mdp_Login = htmlspecialchars($_POST['mdp']);

        //On récupère le mail et le mdp du client et on tente de récupérer le client en question.
        $array_client = $client->recupId($mail_Login, $mdp_Login);

        if(empty($array_client)){ //Si il n'y a pas de résultat, on affiche un message d'erreur.
            $pas_correspondance = true;
        } else { //Sinon, on crée ses variables de sessions.
            session_start();
            $_SESSION['id'] = $array_client[0]->getIdClient();
            $_SESSION['nom'] = $array_client[0]->getNom();
            $_SESSION['statut'] = $array_client[0]->getStatut();
            $_SESSION['prenom'] = $array_client[0]->getPrenom();
            $_SESSION['mdp'] = $mdp_Login;
            $_SESSION['tel'] = $array_client[0]->getTel();
            $_SESSION['mail'] = $array_client[0]->getMail();
            $_SESSION['handicap'] = $array_client[0]->getHandicap();



            //On enlève les réservations dont la date est expirée.
            $date = date('Y-m-d');
            $reserv->DeleteReservWithExpirationDate($date);

            header('Location:index.php');
       }
    }

?>


<!DOCTYPE html>
<html>
<head>
    <title>TripAirplanes - Se connecter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
   <?php require_once("appelHeader.php");?>
   <main>
    <?php if($pas_correspondance):?>
        <div class="erreur-login"><p><img src="images/site/danger.jpg">Réessayez, aucune correspondance dans la base de données.</p></div>
    <?php endif;?>
    <form id="form-login" method="POST" action="login.php">
        <fieldset>
            <p>
                <label for="mail">Votre email :</label> <!-- Si la personne est connectée, écrire directement son nom dans le formulaire !-->
                <input type="email" id="mail" name="mail" required autofocus> <!--Mettre $_SESSION['nom'];!-->
            </p>

            <p>
                <label for="mdp">Votre mot de passe : </label>
                <input type="password" id="mdp" name="mdp" required>
            </p>
            <p id="submit-login">
                <input type="submit" name="btnSubmit_connexion" id="btnSubmit-connexion" value="Se connecter"/>
            </p>          
        </fieldset>
    </form>
   </main>
    <?php require_once("footer.php");?>
    <script type="text/javascript" src="js/comportement.js"></script>
</body>

</html>