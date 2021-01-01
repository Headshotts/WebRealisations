<?php


namespace app\entity;


class Destination {
    private $id_destination;
    private $nom;
    private $description;
    private $transport;
    private $nb_places;
    private $nb_reserves;
    private $prix;
    private $handicap;
    private $image;
    private $ratioplaces;
    //private $_nbpers;

    public function __construct(array $data){
        $this->hydrate($data);
    }

    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    //public function getNbPers(){ return $this->$_nbpers; }

    public function getRatioPlaces(){ return $this->ratioplaces; }

    public function setRatioPlaces($ratioplaces){ $this->ratioplaces = $ratioplaces; }

    public function getIdDestination(){ return $this->id_destination; }

    public function setIdDestination($id_destination){ $this->id_destination = $id_destination; }

    public function getNom(){ return $this->nom; }

    public function setNom($nom){ $this->nom = $nom; }

    public function getDescription(){ return $this->description; }

    public function setDescription($description){ $this->description = $description; }

    public function getTransport(){ return $this->transport; }

    public function setTransport($transport){ $this->transport = $transport; }

    public function getNbPlaces(){ return $this->nb_places; }

    public function setNbPlaces($nb_places){ $this->nb_places = $nb_places; }

    public function getNbReserves(){ return $this->nb_reserves; }

    public function setNbReserves($nb_reserves){ $this->nb_reserves = $nb_reserves; }

    public function getPrix(){ return $this->prix; }

    public function setPrix($prix){ $this->prix = $prix; }

    public function getHandicap(){ return $this->handicap; }

    public function setHandicap($handicap){ $this->handicap = $handicap; }

    public function getImage(){ return $this->image; }

    public function setImage($image){ $this->image = $image; }


}

