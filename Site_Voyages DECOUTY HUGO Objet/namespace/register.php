<?php

//Page d'inscription afin d'être inséré dans la base de données.
//<->MOT DE PASSE SECURISE :  8 à 20 caractères
    include_once("app/controller/controllerClient.php");


    spl_autoload_register('chargerClasse'); //Autoload
    function chargerClasse($classe) {
        $classe = str_replace('\\', '/', $classe);
        require $classe . '.php';
    }
    $client = new app\Controller\controllerClient();


    $erreur_mail = false;
    $erreur_mdp = false;
    if(isset($_POST['btnSubmit'])){

        $mail = htmlspecialchars($_POST['mail']);

        if(!empty($client->searchClientWithMail($mail)[0])){ //Est-ce que cet e-mail à déjà été utilisé (Usurpation d'identité impossible).
            $erreur_mail = true;

            if($_POST['mdp'] != $_POST['mdp_c']){ //Est-ce que les mots de passe ne sont pas pareils (Ecriture du deuxième message d'erreur).
                $erreur_mdp = true;
                header('Location: register.php?erreur_mail=true&erreur_mdp=true');
            }else{
                header('Location: register.php?erreur_mail=true');
            }

        }else{
            //Si l'utilisateur écrit plus de caractères que marqué, on le redirige vers un message d'erreur.
            if(strlen(htmlspecialchars($_POST['nom'])) > 20 || strlen(htmlspecialchars($_POST['prenom'])) > 15 || strlen(htmlspecialchars($_POST['mdp'])) > 20 || strlen(htmlspecialchars($_POST['mail'])) > 80){
                header('Location: register.php?error=full');
            }else{
                if($_POST['mdp'] == $_POST['mdp_c']){
                    session_start();

                    $_SESSION['nom'] = htmlspecialchars($_POST['nom']);
                    $_SESSION['prenom'] = htmlspecialchars($_POST['prenom']);
                    $_SESSION['mdp'] = htmlspecialchars($_POST['mdp']);
                    //$_SESSION['mdp'] = hash('sha256',htmlspecialchars($_POST['mdp']));
                    $_SESSION['mail'] = htmlspecialchars($_POST['mail']);
                    $_SESSION['tel'] = htmlspecialchars($_POST['tel']);
                    $_SESSION['handicap'] = $_POST['handicap'][0];
                    $_SESSION['statut'] = 'User';

                    $client->insertClient($_SESSION['nom'], $_SESSION['prenom'], $_SESSION['mdp'], $_SESSION['mail'], $_SESSION['tel'], $_SESSION['handicap']);

                    $_SESSION['id'] = $client->recupId($_SESSION['mail'], $_SESSION['mdp'])[0]->getIdClient();

                    header('Location: index.php');
                }else{
                    $erreur_mdp = true;
                    header('Location: register.php?erreur_mdp=true');
                }
            }
        }
    }


?>


<!DOCTYPE html>
<html>
<head>
    <title>TripAirplanes - S'inscrire</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
   <?php require_once("appelHeader.php");?>
   <main>
       <?php if(isset($_GET['erreur_mail']) && $_GET['erreur_mail'] === 'true'):?>
            <div class="erreur_register"><p><img src="images/site/danger.jpg">E-mail déjà utilisé.</p></div><br>
       <?php endif;?>
       <?php if(isset($_GET['erreur_mdp']) && $_GET['erreur_mdp'] === 'true'):?>
            <div class="erreur_register"><p><img src="images/site/danger.jpg">Veuillez recommencer, les deux mots de passe ne sont pas identiques.</p></div><br>
       <?php endif;?>
       <?php if(isset($_GET['error']) && $_GET['error'] === 'full'):?>
           <div class="erreur_register"><p><img src="images/site/danger.jpg">Veuillez respecter les tailles maximales pour chaque information</p></div><br>
       <?php endif;?>
        <form id="form-register" method="POST" action="register.php">
            <fieldset>
                <p>
                    <label for="nom">Votre nom :</label> <!-- Si la personne est connectée, écrire directement son nom dans le formulaire !-->
                    <input type="text" id="nom" name="nom" placeholder="(20 caractères maximum)" required autofocus> <!--Mettre $_SESSION['nom'];!-->
                </p>
                <p>
                    <label for="prenom">Votre prénom : </label>
                    <input type="text" id="prenom" name="prenom" placeholder="(15 caractères maximum)" required>
                </p>
                <p>
                    <label for="mdp">Votre mot de passe : </label>
                    <input type="password" id="mdp" name="mdp" placeholder="(20 caractères maximum)" required>
                </p>
                <p>
                    <label for="mdp_c">Confirmez votre mot de passe : </label>
                    <input type="password" id="mdp" name="mdp_c" required>
                </p>
                <p>
                    <label for="mail">Votre email : </label>
                    <input type="email" id="mail" name="mail" placeholder="(80 caractères maximum)" required>
                </p>
                <p>
                    <label for="tel">Votre numéro de téléphone : </label>
                    <input type="tel" id="tel" name="tel" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}" placeholder="exemple : 00-00-00-00-00" required>
                </p>
                <p>
                    <label for="handicap">Avez-vous un handicap ?</label>
                    <input type="radio" id="handicap" name="handicap[]" value="Y">Oui <!-- Si il y'a un cochage du "oui", demander un justificatif relais handicap par PHP? ou juste un message !-->
                    <input type="radio" id="handicap" name="handicap[]" value="N" checked="checked">Non
                </p>
                <p id="submit-register">
                    <!--<label for="submit">S'inscrire</label>-->
                    <input type="submit" name="btnSubmit" id="btnSubmit-register" value="S'inscrire" />
                </p>
            </fieldset>
        </form>
   </main>

    <?php require_once("footer.php");?>
    <script text="text/javascript" src="js/comportement.js"></script>
</body>


        
</html>