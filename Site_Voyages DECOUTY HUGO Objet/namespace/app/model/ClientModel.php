<?php


namespace app\model;
require_once("app/entity/Client.php");
require_once("app/model/model.php");
use app\entity\Client;

class ClientModel extends Model{

    public function __construct() {
        $this->table = "client";
        parent::__construct();
    }

    /* --- GENERIC --- */
    public function findAll(){
        $model = parent::find();
        $result = array();
        foreach ($model as $client) {
            $result[] = new Client($client);
        }
        return $result;
    }

    /* USE in register.php and login.php */
    public function FindClient($mail, $mdp){
        //Used to know if the user put his mail and his password correctly.
        $model = parent::find(array("conditions" => "mail = '$mail' AND mdp = '$mdp'"));
        $result = array();
        foreach ($model as $client) {
            $result[] = new Client($client);
        }
        return $result;
    }

    /* --- FROM appelHeader.php --- */
    public function PersonalTextHeader($nom, $prenom, $mail){
        //Show the name, first name of the client, identifying too by his password.
        $model = parent::find(array("conditions" => "nom = '$nom' AND prenom = '$prenom' AND mail = '$mail'"));
        $result = array();
        foreach ($model as $client) {
            $result[] = new Client($client);
        }
        return $result;

    }

    /* --- FROM mon_profil.php --- */
    public function EmailAlreadyExists($mail){
        //Used to know if the user that wants to change his mail for another one already exists in the Database or not.
        $model = parent::find(array("fields" => "mail",
                               "conditions" => "mail = '$mail'"));
        $result = array();
        foreach ($model as $client) {
            $result[] = new Client($client);
        }
        return $result;
    }

    public function RecupPassword($id){
        //Used to know if the user put correctly his password.
        $model = parent::find(array("fields" => "mdp",
                               "conditions" => "idclient = $id"));
        $result = array();
        foreach ($model as $client) {
            $result[] = new Client($client);
        }
        return $result;
    }

    public function UpdateClientWithoutPassword($nom, $prenom, $mail, $tel, $id){
        #Update the client if he doesn't filled the password fields.

        parent::newupdate(array("fields" => array("nom" => $nom,
                                                 "prenom" => $prenom,
                                                 "mail" => $mail,
                                                  "tel" => $tel),
                                "conditions" => "idclient = $id"));
    }

    public function UpdateClientWithPassword($nom, $prenom, $mdp, $mail, $tel, $id){
        #Update the client if he filled the password fields.

        parent::newupdate(array("fields" => array("nom" => $nom,
            "prenom" => $prenom,
            "mdp" => $mdp,
            "mail" => $mail,
            "tel" => $tel),
            "conditions" => "idclient = $id"));

    }

    /* ---  FROM register.php --- */
    public function NewClient($nom, $prenom, $mdp, $mail, $tel, $handicap){
        #Insert the client registered into our Database
        $model = parent::insert(array("columns" => "nom, prenom, mdp, mail, tel, handicap",
                                      "values" => "'$nom', '$prenom', '$mdp', '$mail', '$tel', '$handicap'"));
        return $model;
    }

}