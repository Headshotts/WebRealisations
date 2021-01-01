<?php


namespace app\entity;


class Reservation {
    private $_id_reservation;
    private $_date_debut;
    private $_date_fin;
    private $_nombre_personnes;
    private $_nb_handicapes;
    private $_nb_billets_Eco;
    private $_nb_billets_Premium;
    private $_nb_billets_Affaires;
    private $_prix;
    private $_id_destination;
    private $_id_client;
    private $nombres;

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

    public function getNombres(){ return $this->nombres; }

    public function setNombres($nombres){ $this->nombres = $nombres; }

    public function getIdReservation(){ return $this->_id_reservation; }

    public function setIdReservation($id_reservation){ $this->_id_reservation = $id_reservation; }

    public function getDateDebut(){ return $this->_date_debut; }

    public function setDateDebut($date_debut) { $this->_date_debut = $date_debut; }

    public function getDateFin(){ return $this->_date_fin; }

    public function setDateFin($date_fin){ $this->_date_fin = $date_fin; }

    public function getNombrePersonnes() { return $this->_nombre_personnes; }

    public function setNombrePersonnes($nombre_personnes){ $this->_nombre_personnes = $nombre_personnes; }

    public function getNbHandicapes(){ return $this->_nb_handicapes; }

    public function setNbHandicapes($nb_handicapes){ $this->_nb_handicapes = $nb_handicapes; }

    public function getNbBilletsEco(){ return $this->_nb_billets_Eco; }

    public function setNbBilletsEco($nb_billets_Eco){ $this->_nb_billets_Eco = $nb_billets_Eco; }

    public function getNbBilletsPremium(){ return $this->_nb_billets_Premium; }

    public function setNbBilletsPremium($nb_billets_Premium){ $this->_nb_billets_Premium = $nb_billets_Premium; }

    public function getNbBilletsAffaires(){ return $this->_nb_billets_Affaires; }

    public function setNbBilletsAffaires($nb_billets_Affaires){ $this->_nb_billets_Affaires = $nb_billets_Affaires; }

    public function getPrix(){ return $this->_prix; }

    public function setPrix($prix){ $this->_prix = $prix; }

    public function getIdDestination(){ return $this->_id_destination; }

    public function setIdDestination($id_destination){ $this->_id_destination = $id_destination; }

    public function getIdClient(){ return $this->_id_client; }

    public function setIdClient($id_client){ $this->_id_client = $id_client; }




}