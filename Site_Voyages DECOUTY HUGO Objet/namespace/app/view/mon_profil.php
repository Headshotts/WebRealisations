<?php
include_once("app/entity/Destination.php");
include_once("app/entity/Reservation.php");
include_once("app/controller/controllerVoyage.php");

$voyage = new app\controller\ControllerVoyage();
    //Ce site sert à ce que l'utilisateur puisse voir son profil. Pour le moment, seul le remboursement d'un voyage a été défini sur la page.
?>

<div id="reserv-profile"><h1>Réservations</h1></div>
<p id="nb-reserv-profile">Vous avez <?=$content[0]->getNombres()?> réservations en cours. </p>
<?php if($content[0]->getNombres() > 0):?>
    <table id="table_reservation">
        <tr><th>Nom du voyage</th><th>Prix du voyage</th><th>Date de départ</th><th>Nombre de personnes</th></tr>
        <?php foreach($_SESSION['reservation'] as $key => $values):?>
            <tr id="tr_reservation"><td><a href="remboursement.php?id_reservation=<?=$values->getIdReservation()?>&id_destination=<?=$values->getIdDestination()?>"><img src="images/site/bin.png"</a><a href="sejour.php?id_destination=<?=$values->getIdDestination()?>"><?=$voyage->showName($values->getIdDestination())[0]->getNom()?></a></td><td><?=$values->getPrix()?></td><td><?=$values->getDateDebut()?></td><td><?=$values->getNombrePersonnes()?></td></tr>

        <?php endforeach;?>
    </table>
<?php endif;?>






<!--
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
        <input type="email" id="mail" name="mail" value="<?=$_SESSION['mail']?>">
    </p>
    <p>
        <label for="tel">Votre numéro de téléphone : </label>
        <input type="tel" id="tel" name="tel" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}" placeholder="exemple : '00-00-00-00-00'" value="<?=$_SESSION['tel']?>" required>
    </p>
    <input type="submit" id="btnSubmit-profile" name="btnSubmit-profile" value="Accepter les modifications">
</form>

-->