<?php

namespace app\controller;

require_once("app/model/DestinationModel.php");
use app\model\DestinationModel;

class controllerVoyage {
    private $model;

    public function __construct()
    {
        $this->model =new DestinationModel();
        //$this->view=new View();

        //echo "controllerVoyage ville";

    }
    //Destination -- Generic

    public function findDestination(){
        $content = $this->model->findAll();

        include_once("app/view/gererBDD.php");
    }

    //Destination -- gererBDD.php

    public function insertDest($nom ,$description, $transport, $nb_places, $prix, $handicap, $voyage){
        $this->model->insertDestination($nom ,$description, $transport, $nb_places, $prix, $handicap, $voyage);
    }

    public function deleteDest($id){
        $this->model->deleteDestination($id);
    }

    //Destination -- presentation_voyages.php

    public function showVoyages_c(){
        $content = $this->model->showVoyages();

        include_once("app/view/presentation_voyages.php");
    }

    //Destination -- sejour.php

    public function getDestbyId($id){
        $content = $this->model->FindOne($id);

        include_once("app/view/sejour.php"); //Bug Array vide
    }
    //Destination -- reservations.php

    public function getDestbyId_reserv($id){
        $content = $this->model->FindOne($id);

        include_once("app/view/reservations.php"); //Bug Array vide
    }

    //For the URL of mon_profil.php.
    public function getName($id){
        $content = $this->model->getNameFromId($id);

        return $content;
    }

    //For the view of the name of the reservations in mon_profil.php

    public function showName($id){
        $content = $this->model->getNameFromId($id);

        return $content;
    }

    //Destination -- remboursement.php

    public function NameDestFromId($id){
        $content = $this->model->getNameFromId($id);
        include_once("app/view/remboursement.php");
    }

    //Destination -- presentation_voyages.php

    public function FilterSearch($nbplaces, $transport, $prix, $handicap, $ratioplaces){
        $content = $this->model->showVoyagesOnFilter($nbplaces, $transport, $prix, $handicap, $ratioplaces);

        include_once("app/view/presentation_voyages.php");
    }


}
