<?php


namespace app\model;
require_once("app/entity/Destination.php");
require_once("app/model/model.php");
use app\entity\Destination;

class DestinationModel extends model {
    public function __construct() {
        $this->table = "destination";
        parent::__construct();
    }

    /* --- GENERIC --- */
    #SELECT * FROM destination: Show all destinations
    public function findAll(){
        $model = parent::find();
        $result = array();
        foreach ($model as $Destination) {
            $result[] = new Destination($Destination);
        }
        return $result;
    }

    /* --- FROM gererBDD.php --- */

    public function insertDestination($nom ,$description, $transport, $nbplaces, $prix, $handicap, $voyage){
        #Insert the destination from the Database.
        $model = parent::insert(array("columns" => "nom, description, transport, nbplaces, prix, handicap, image",
                                      "values" => "'$nom', '$description', '$transport', $nbplaces, $prix, '$handicap', '$voyage'"));
        return $model;
    }

    public function deleteDestination($id){
        #Delete the destination from the Database.
        $model = parent::delete(array("conditions" => "iddestination = $id"));
        return $model;
    }

    //ALTER TABLE destination AUTO INCREMENT = 1

    /* --- FROM presentation_voyages.php */
    public function showVoyages(){
        #Show all travels.
        $model = parent::find(array("fields" => "iddestination, nom, description, transport, prix, handicap, nbplaces, round((SELECT sum(nombrepersonnes) from Reservation R WHERE R.iddestination = D.iddestination)*100/nbplaces,2) as ratioplaces ",
                                "letter" => "D",
                                "conditions" => "1 GROUP BY iddestination, nom, description, transport, prix, handicap, nbplaces",
                                "order" => "ratioplaces DESC"));
        $result = array();
        foreach ($model as $Destination) {
            $result[] = new Destination($Destination);
        }
        return $result;
    }

    public function showVoyagesOnFilter($nbplaces, $transport, $prix, $handicap, $ratioplaces){
        //Show travels, that the user wants to, according to the filter search. (Travels shown can be available or not, if he select to see full travels or not).
        $model = parent::find(
            array("letter" => "D",
                  "conditions" => "nbplaces - (SELECT COALESCE(sum(nombrepersonnes),0) from reservation R WHERE R.iddestination = D.iddestination) >= $nbplaces $transport AND D.prix <= $prix AND handicap = '$handicap' AND (round((SELECT COALESCE(sum(nombrepersonnes),0) from Reservation R WHERE R.iddestination = D.iddestination)*100/nbplaces,2)) $ratioplaces 100",
                  "order" => " round((SELECT SUM(nombrepersonnes) from reservation R WHERE R.iddestination = D.iddestination)*100/nbplaces,2) DESC"//"iddestination ASC"
            ));
        $result = array();
        foreach ($model as $Destination) {
            $result[] = new Destination($Destination);
        }
        return $result;

        //Request Example : SELECT * FROM destination D WHERE nbplaces - (SELECT COALESCE(sum(nombrepersonnes),0) from reservation R WHERE R.iddestination = D.iddestination) >= 4 AND D.prix <= 10000 AND handicap = 'Y' AND (round((SELECT COALESCE(sum(nombrepersonnes),0) from Reservation R WHERE R.iddestination = D.iddestination)*100/nbplaces,2)) <= 100 ORDER BY iddestination ASC
    }

    /* --- FROM reservations.php --- */

    //This function is also use in sejour.php
    public function FindOne($id){
        //Function used to get one destination by his id.
        $model = parent::find(array("conditions" => "iddestination = $id"));
        $result = array();
        foreach ($model as $Destination) {
            $result[] = new Destination($Destination);
        }
        //print_r($result);
        return $result;
    }

    //This function is also use in the view of mon_profil.php and remboursement.php
    public function getNameFromId($id){
        //Function used to get the name of the destination by his id.
        $model = parent::find(array("fields" => "nom",
                                    "conditions" => "iddestination = $id"));
        $result = array();
        foreach ($model as $Destination) {
            $result[] = new Destination($Destination);
        }
        return $result;
    }



}