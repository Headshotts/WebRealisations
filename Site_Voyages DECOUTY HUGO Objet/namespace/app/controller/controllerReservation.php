<?php


namespace app\controller;
require_once("app/model/ReservationsModel.php");
use app\model\ReservationsModel;

class controllerReservation{
    private $model;

    public function __construct(){
        $this->model =new ReservationsModel();
        //$this->view=new View();

        //echo "controllerVoyage ville";
    }

    //Reservation reservations.php

    public function insertReserv($date, $nbp, $nbh, $nbbE, $nbbP, $nbbA, $prix, $iddestination, $idclient){
        $this->model->insertReservation($date, $nbp, $nbh, $nbbE, $nbbP, $nbbA, $prix, $iddestination, $idclient);
    }

    public function showNumberofReservations($id){
        $content = $this->model->NumberofReservations($id);

        include_once("app/view/mon_profil.php");
    }

    public function HistoricalReservations($id){
        $content = $this->model->HistoricalReservationfromClient($id);
        return $content;
    }

    //Reservation -- remboursement.php
    public function deleteReserv($id){
        $this->model->DeleteReservation($id);
    }

    public function countPlacesTaken($id){
        return $this->model->CheckLastPlaces($id);
    }

    //Reservation -- login.php

    public function DeleteReservWithExpirationDate($date){
        return $this->model->DeleteExpiredReservations($date);
    }

}






