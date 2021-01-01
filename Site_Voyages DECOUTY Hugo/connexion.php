<?php

define("SERVEUR", "localhost");
define("USER", "root");
define("MDP", "");
define("BD", "voyages");

function connexionBd($hote=SERVEUR, $username=USER, $mdp=MDP, $bd =BD){
    try{$connex= new PDO('mysql:host='.$hote.';dbname='.$bd, $username, $mdp);
    $connex->exec("SET CHARACTER SET utf8");//Gestion des accents

        return $connex;
    }
    catch(Exception $e){
        echo'Erreur : '.$e->getMessage().'<br/>';
        echo'N°: '.$e->getCode();


        return null;

    }
}
?>