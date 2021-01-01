<?php


namespace app\entity;


class Client {
    private $_idclient;
    private $_nom;
    private $_prenom;
    private $_mdp;
    private $_mail;
    private $_tel;
    private $_handicap;
    private $_statut;

    /**
     * Client constructor.
     * @param $_id_client
     * @param $_nom
     * @param $_prenom
     * @param $_mdp
     * @param $_mail
     * @param $_tel
     * @param $_handicap
     * @param $_statut
     */

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

    public function getIdClient(){ return $this->_idclient; }

    public function setIdClient($idclient){ $this->_idclient = $idclient; }

    public function getNom(){ return $this->_nom; }

    public function setNom($nom){ $this->_nom = $nom; }

    public function getPrenom(){ return $this->_prenom; }

    public function setPrenom($prenom){ $this->_prenom = $prenom; }

    public function getMdp(){ return $this->_mdp; }

    public function setMdp($mdp){ $this->_mdp = $mdp; }

    public function getMail(){ return $this->_mail; }

    public function setMail($mail){ $this->_mail = $mail; }

    public function getTel(){ return $this->_tel; }

    public function setTel($tel){ $this->_tel = $tel; }

    public function getHandicap(){ return $this->_handicap; }

    public function setHandicap($handicap){ $this->_handicap = $handicap; }

    public function getStatut(){ return $this->_statut; }

    public function setStatut($statut){ $this->_statut = $statut; }



}
