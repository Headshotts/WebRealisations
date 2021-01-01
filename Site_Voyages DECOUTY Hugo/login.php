<?php

    //Page de connexion pour tout utilisateur
    include_once('connexion.php');
    $connexion = connexionBd();
    $pas_correspondance = "";
    if(isset($_POST['btnSubmit_connexion'])) {
        $email_Login = htmlspecialchars($_POST['email']);
        $mdp_Login = htmlspecialchars($_POST['mdp']);
        $GoodLogin = $connexion->prepare("SELECT * from Clients WHERE mail = :mail AND mdp = :mdp "); //On cherche le client qui correspond au mdp et au mail
        $GoodLogin->bindParam(':mail', $email_Login);
        $GoodLogin->bindParam(':mdp', $mdp_Login);
        $GoodLogin->execute();

        $resultat = $GoodLogin->fetch(PDO::FETCH_OBJ);
        if (empty($resultat)) { //Si il n'y a pas de résultat, on affiche un message d'erreur.
            $pas_correspondance = "Réessayez, aucune correspondance dans la base de données.";
        } else { //Sinon, on crée ses variables de sessions.
            session_start();
            $_SESSION['id'] = $resultat->id_client;
            $_SESSION['nom'] = $resultat->nom;
            $_SESSION['statut'] = $resultat->statut;
            $_SESSION['prenom'] = $resultat->prenom;
            $_SESSION['mdp'] = $mdp_Login; //htmlspecialchars($_POST['mdp']);
            $_SESSION['tel'] = $resultat->tel;
            $_SESSION['mail'] = $resultat->mail;
            $_SESSION['handicap'] = $resultat->handicap;

            $reservation = $connexion->prepare("SELECT date_debut, nombre_personnes, R.id_destination, id_reservation, D.nom, R.prix FROM RESERVATIONS R JOIN DESTINATION D ON D.id_destination = R.id_destination WHERE R.id_client = :client ORDER BY date_debut ASC");
            $reservation->bindParam(':client', $_SESSION['id']);
            $reservation->execute();
            $_SESSION['reservation'] = $reservation->fetchAll(PDO::FETCH_OBJ);
            header('Location:index.php');
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
    <p><?=$pas_correspondance?></p>
    <form method="POST" action="login.php">
        <fieldset>
            <p>
                <label for="email">Votre email :</label> <!-- Si la personne est connectée, écrire directement son nom dans le formulaire !-->
                <input type="email" id="email" name="email" required autofocus> <!--Mettre $_SESSION['nom'];!-->
            </p>

            <p>
                <label for="mdp">Votre mot de passe : </label>
                <input type="password" id="mdp" name="mdp" required>
            </p>
            <p>
                <input type="submit" name="btnSubmit_connexion" id="btnSubmit_connexion" value="Se connecter"/>
            </p>          
        </fieldset>
    </form>
   </main>
    <?php require_once("footer.php");?>
    <script text="text/javascript" src="js/comportement.js"></script>
</body>


        
</html>