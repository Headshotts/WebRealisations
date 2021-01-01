<?php

//Page d'accueil du serveur. Permet à la fois d'accéder à l'inscription, à la (dé)connexion des utilisateurs mais aussi à la réservation potentielle.
session_start();

?>


<!DOCTYPE html>
<html>




<head>
    <title>TripAirplanes - Accueil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0", shrink-to-fit="no">
    <link rel="stylesheet" type="text/css" href="css/reset.css"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>
   <?php require_once('appelHeader.php');?>
   <main>
       <h1 id="index-title">Bienvenue sur TripAirplanes</h1>
       <section class="index-flex">
           <article class="index-subflex">
               <img src="images/site/index-part1.jpg" alt="TripAirplanes">
           </article>
           <article class="index-subflex">
               <h1>TripAirplanes : Le site de réservation de voyages en ligne</h1>
               <p>TripAirplanes est une compagnie de voyages qui vous proposent plus d'une centaine de réservations possibles dans des
                   dizaines de pays pour un prix attractif et une expérience inoubliable.
               </p>
               <p>
                   TripAirplanes, c'est aussi une compagnie qui vous proposent des séjours de 7 jours, avec des activités ludiques et avec une vue
                   à couper le souffle. Pour profiter de nos voyages, inscrivez-vous dès maintenant <a href="register.php">ici !</a>
               </p>
           </article>
       </section>

       <section class="index-flex">
           <article class="index-subflex">
               <img src="images/site/index-part2.jpg" alt="TripAirplanes">
           </article>
           <article class="index-subflex">
               <h1>Une société qui écoute sa clientèle</h1>
               <p>TripAirplanes est une société qui a su s'éléver grâce à sa communauté et ses retours. En effet, nous prenons toujours soin d'offir
                   une expérience sur notre site qui est ergonomique et agréable, tout en conservant la sécurisation des données de nos utilisateurs.
               </p>
               <p>
                   Si vous faites déjà partie de la TripAirplanes Community, vous pouvez dès à présent réserver un voyage
                   <a href="presentation_voyages.php">ici</a> ou appeller notre agence pour un entretien au 06 29 414 20424.
               </p>
           </article>
       </section>

       <section class="index-flex">
           <article class="index-subflex">
               <img src="images/site/index-part3.jpg" alt="TripAirplanes">
           </article>
           <article class="index-subflex">
               <h1>Une traçabilité et un service à votre écoute</h1>
               <p>Depuis votre profil, vous pouvez à tout moment voir les réservations que vous avez faites et supprimer votre réservation à tout instant.<br>

               </p>
               <p>Profitez d'un service client opérationnel et compétent 24h/24 les jours ouvrés. L'appel n'est pas surtaxé et nous faisons en
                   sorte que l'appel soit pris dans les 5 minutes.<br>
               Pour tout renseignement supplémentaire, ou problèmes à corriger, veuillez nous contacter au numéro : 06 29 414 20424 ou par mail : tripairplanes@pro.com .
               </p>
           </article>
       </section>

    <?php require_once("footer.php");?>
   </main>
   <script text="text/javascript" src="js/comportement.js"></script>
</body>


        
</html>