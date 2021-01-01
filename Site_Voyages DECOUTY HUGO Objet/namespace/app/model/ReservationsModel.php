<?php


namespace app\model;
require_once("app/entity/Reservation.php");
require_once("app/model/model.php");
use app\entity\Reservation;

class ReservationsModel extends model {
    public function __construct() {
        $this->table = "reservation";
        parent::__construct();
    }

    /* --- GENERIC --- */
    //Show all reservations
    public function findAll(){
        $model = parent::find();
        $result = array();
        foreach ($model as $reservation) {
            $result[] = new Reservation($reservation);
        }
        return $result;
    }

    /* --- FROM login.php --- */

    public function DeleteExpiredReservations($date){
        //Delete a reservation that have been expired.
        parent::delete(array("conditions" => "datedebut < '$date'"));
    }

    /* --- FROM remboursement.php --- */

    public function DeleteReservation($id){
        //Delete a reservation if the user doesn't want to travel at the destination he wanted before.
        $model = parent::delete(array("conditions" => "idreservation = $id"));
        return $model;
    }

    public function CheckLastPlaces($id){
        //Used to see how many people reserved into the destination.
        $model = parent::find(array("fields" => "sum(nombrepersonnes) as nbpers",
                               "conditions" => "iddestination = $id"));
        return $model;
    }

    /* --- FROM reservations.php --- */

    public function insertReservation($date, $nbp, $nbh, $nbbE, $nbbP, $nbbA, $prix, $iddestination, $idclient){
        //Insert a reservation into the Database.
        $model = parent::insert(array("columns" => "datedebut, nombrepersonnes, nbhandicapes, nbbilletsEco, nbbilletsPremium, nbbilletsAffaires, prix, iddestination, idclient",
                                 "values" => "'$date', $nbp, $nbh, $nbbE, $nbbP, $nbbA, $prix, $iddestination, $idclient"));
        return $model;

    }

    /* --- FROM mon_profil.php --- */

    public function NumberofReservations($id){
        //Count how many reservations the user have.
        $model = parent::find(array("fields" => "COUNT(idreservation) as nombres",
                                      "conditions" => "idclient = $id"));
        $result = array();
        foreach ($model as $reservation) {
            $result[] = new Reservation($reservation);
        }
        return $result;
    }

    public function HistoricalReservationfromClient($id){
        //Used to show the informations of each reservation, that have been made by the user.
        $model = parent::find(array(
            "fields" => "datedebut, nombrepersonnes, R.iddestination, idreservation, D.nom, R.prix",
            "letter" => "R",
            "othertable" => "JOIN DESTINATION D ON D.iddestination = R.iddestination",
            "conditions" => "R.idclient = $id",
            "order" => "datedebut ASC"));
        $result = array();
        foreach ($model as $reservation) {
            $result[] = new Reservation($reservation);
        }
        return $result;
    }

}