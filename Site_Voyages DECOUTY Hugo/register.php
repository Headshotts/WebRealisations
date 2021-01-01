<?php

    //Page d'inscription afin d'être inséré dans la base de données.
    //<->MOT DE PASSE SECURISE :  8 à 20 caractères
    include('connexion.php');
    $connexion = connexionBd();
    $erreur_mail = false;
    $erreur_mdp = false;
    if(isset($_POST['btnSubmit'])){
        $mail_valide = $connexion->prepare("SELECT * FROM clients WHERE mail = :mail");
        $mail_valide->bindParam(':mail', $_POST['mail']);
        $mail_valide->execute();
        $resultat_mail = $mail_valide->fetch(PDO::FETCH_OBJ);
        if(!empty($resultat_mail)){ //Est-ce que cet e-mail à déjà été utilisé (Usurpation d'identité impossible).
            $erreur_mail = true;
            if($_POST['mdp'] != $_POST['mdp_c']){ //Est-ce que les mots de passe ne sont pas pareils (Ecriture du deuxième message d'erreur).
                $erreur_mdp = true;
            }
        }else{
            if($_POST['mdp'] == $_POST['mdp_c']){
                session_start();
                $_SESSION['nom'] = htmlspecialchars($_POST['nom']);
                $_SESSION['prenom'] = htmlspecialchars($_POST['prenom']);
                $_SESSION['mdp'] = htmlspecialchars($_POST['mdp']);
                $_SESSION['mail'] = htmlspecialchars($_POST['mail']);
                $_SESSION['tel'] = htmlspecialchars($_POST['tel']);
                $_SESSION['handicap'] = $_POST['handicap'][0];
                $_SESSION['statut'] = 'User';

                $requete = $connexion->prepare("INSERT INTO Clients(nom, prenom, mdp, mail, tel, handicap) VALUES(:nom, :prenom, :mdp, :mail, :tel, :handicap)");
                $requete->bindParam(':nom', $_SESSION['nom']);
                $requete->bindParam(':prenom', $_SESSION['prenom']);
                $requete->bindParam(':mdp', $_SESSION['mdp']);
                $requete->bindParam(':mail', $_SESSION['mail']);
                $requete->bindParam(':tel', $_SESSION['tel']);
                $requete->bindParam(':handicap', $_SESSION['handicap']);
                $requete->execute();

                header('Location: index.php');
            }else{
                $erreur_mdp = true;
            }
        }
    }


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
       <?php require_once("appelHeader.php");?>
   </header>
   <main>
       <?php if($erreur_mail):?>
            <div class="erreur_register"><p><img src="images/site/danger.jpg">E-mail déjà utilisé.</p></div><br>
       <?php endif;?>
       <?php if($erreur_mdp):?>
            <div class="erreur_register"><p><img src="images/site/danger.jpg">Veuillez recommencer, les deux mots de passe n'étaient pas les mêmes.</p></div><br>
       <?php endif;?>
        <form method="POST" action="register.php">
            <fieldset>
                <p>
                    <label for="nom">Votre nom :</label> <!-- Si la personne est connectée, écrire directement son nom dans le formulaire !-->
                    <input type="text" id="nom" name="nom" required autofocus> <!--Mettre $_SESSION['nom'];!-->
                </p>
                <p>
                    <label for="prenom">Votre prénom : </label>
                    <input type="text" id="prenom" name="prenom" required>
                </p>
                <p>
                    <label for="mdp">Votre mot de passe : </label>
                    <input type="password" id="mdp" name="mdp" required>
                </p>
                    <label for="mdp_c">Confirmez votre mot de passe : </label>
                    <input type="password" id="mdp" name="mdp_c" required>
                <p>
                    <label for="mail">Votre email</label> <!-- Mail bug, on peut ne pas mettre '.com' ou '.fr' ex: 'jerem@gsdd' !-->
                    <input type="email" id="mail" name="mail">
                </p>
                <p>
                    <label for="tel">Votre numéro de téléphone</label>
                    <input type="tel" id="tel" name="tel" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}" placeholder="exemple : '00-00-00-00-00'" required>
                </p>
                <p>
                    <label for="handicap">Avez-vous un handicap ?</label>
                    <input type="radio" id="handicap" name="handicap[]" value="Y">Oui <!-- Si il y'a un cochage du "oui", demander un justificatif relais handicap par PHP? ou juste un message !-->
                    <input type="radio" id="handicap" name="handicap[]" value="N" checked="checked">Non
                </p>
                <p>
                    <label for="submit">S'inscrire</label>
                    <input type="submit" name="btnSubmit" id="btnSubmit" value="Envoi" />
                </p>
            </fieldset>
        </form>
   </main>
    <?php require_once("footer.php");?>
    <script text="text/javascript" src="js/comportement.js"></script>
</body>


        
</html>