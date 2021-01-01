<?php

?>

    <div id="cadre-remboursement">
        <p>Souhaitez-vous vraiment vous faire rembourser le voyage : <?=$content[0]->getNom()?> ? </p>
        <div id="buttons-remboursement">
            <form method="post" action="remboursement.php?id_reservation=<?=$_GET['id_reservation']?>&id_destination=<?=$_GET['id_destination']?>">
                <input type="submit" name="rembourser" id="rembourser" value="Oui, je veux être remboursé">
            </form>
            <a href="mon_profil.php?client=<?=$_SESSION['id']?>">Retourner sur mon profil</a>
        </div>
    </div>

