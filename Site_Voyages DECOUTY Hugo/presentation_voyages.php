<?php
    /* Présentation des voyages

Possibilité de rechercher le voyage que l'on souhaite à travers une barre de recherche puis les séléctions de voyages classées dans l'ordre décroissant du pourcentage de Places prises/Places totales avec message en rouge PLUS BEAUCOUP DE PLACES ! si plus de 90%.

Si un des voyages nous plaît, alors un bouton "En savoir plus" permet d'accéder à la page directement du voyage souhaité.
Sur cette même page "En savoir plus", on pourra voir toutes les informations du voyage et réserver :

- Soit à la fin du site en footer...
- Soit avec un bouton "Réserver" qui mène à [Reservations.php?...] où "..." est l'URL séléctionnant l'id_destination du voyage choisi et qui incrémente son nombre de réservations.

*/

/*      --AMELIORATIONS POUR CHOIX_VOYAGES.PHP--
    On suppose que tous les voyages autorisent tous types de billets : Economique, Standard, Première classe et Affaires.
    <->Barre de recherche permettant de trouver soi-même le voyage que l'on souhaite (Requête SQL préparée avec pour valeur, la barre de recherche)
    <->Créer le site paiement.php qui mène à un faux site bancaire qui calcule le prix en fonction du nb de réservations (client + personnes).
    <->Mettre des filtres styles listes déroulantes [Type de transport | Handicap | Continent (A AJOUTER DANS BDD section Sejour !!!!)]
*/
?>