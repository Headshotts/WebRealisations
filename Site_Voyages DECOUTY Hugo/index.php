<?php

//Page d'accueil du serveur. Permet à la fois d'accéder à l'inscription, à la (dé)connexion des utilisateurs mais aussi à la réservation potentielle.

/*      --AMELIORATIONS--
    <->Mettre un cookie en fonction de la dernière page voyage visitée par le client.
    <->Afficher trois ou quatres voyages au hasard avec leur description + bouton EN SAVOIR PLUS qui mène à la page du voyage, qui elle même possède le bouton RESERVATION (si on peut encore réserver ce voyage -> encore de la place)
    <->Afficher la, ou les réservations du client sous forme de message avec un lien menant à la page voyage correspondante.
    <->BDD : Mettre les équivalents du SIMILAR TO à tous les attributs qui en ont besoin + rajouter la colonne STATUT à la table Client.
*/
session_start();
include_once('connexion.php');
$connexion = connexionBd();

$requete = "SELECT * from Destination";
$count = $connexion->query($requete);
$resultat = $count->fetchALL(PDO::FETCH_OBJ);

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
    <br><br>
    <caption>Destinations possibles : </caption>
    <table>
        <tr><th>id_voyage</th><th>nom</th><th>description</th><th>Type transport</th><th>nombre de places</th><th>nombres reservés</th><th>prix</th><th>Places handicapés</th><th>Images</th></tr>
        <?php foreach($resultat as $key => $values):?> <!-- à changer !-->
            <tr>       
            <?php foreach($values as $k => $v):?>             
               <td><a href="sejour.php?id_destination=<?=$values->id_destination?>"><?=$v?></a></td>               
            <?php endforeach;?>
            </tr>
        <?php endforeach;?>
    </table>
    <br><br>
       <p>Sur ce site, vous pouvez voir les différents voyages qu'il est possible de réserver, la possibilité de s'inscrire, se connecter et se déconnecter. Bien sûr, l'affichage des liens tels qu'il est fait ne sera pas fait ici, mais dans presentation_voyages.php, avec de l'esthétique.<br><br>
           User : root | Pas de password pour accéder à la Base de données -> Fichier voyages.sql du dossier SQL).</p><br><br>
       <p>Connexion à un compte admin afin de gérer les données : email : oui@gmail.com    mdp : oui</p>
       <p>Connexion à un compte user afin de gérer les données : email : monEmail@gmail.com   mdp : monMdp</p>
       <p>Pour accèder à la partie "L'administrateur peut gérer les données", il faut se connecter au compte administrateur avec les coordonnées ci-dessus et cliquer
           ensuite sur "Gérer les données" dans le header.</p>
       <p>Note : L'image "livre-de-voyage-31850289.jpg" dans le dossier "Site_Voyages" sert d'image test pour ajouter un voyage. Pour le moment, l'input FILE récupère toutes sortes de fichiers.</p>
       <p>La partie réservations est quasiment terminée (quelques détails restants). La partie est disponible depuis ce projet.</p>
    <a href="reservations.php">Je veux réserver</a>
    <?php require_once("footer.php");?>
   </main>
   <script text="text/javascript" src="js/comportement.js"></script>
</body>


        
</html>