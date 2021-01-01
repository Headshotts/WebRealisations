<?php

    function tronquer_texte($texte, $longueur_max = 100)
    {
    if (strlen($texte) > $longueur_max) { //Si la longueur du texte est supérieure à 100 caractères (par défaut)
        $texte = substr($texte, 0, $longueur_max); //On garde 100 caractères au texte
        $texte .= "..."; //On écrit à la place trois petits points pour montrer que c'est pas fini.
    }
    return $texte;
}
?>