<?php


namespace app\controller;
require_once("app/model/ClientModel.php");
use app\model\ClientModel;


class controllerClient{
    private $model;

    public function __construct(){
        $this->model =new ClientModel();
        //$this->view=new View();

        //echo "controllerVoyage ville";
    }

    //Client -- register.php

    public function insertClient($nom ,$prenom, $mdp, $mail, $tel, $handicap){
        $this->model->NewClient($nom, $prenom, $mdp, $mail, $tel, $handicap);
    }

    public function recupId($mail, $mdp){
        $content = $this->model->FindClient($mail, $mdp);
        return $content;
    }

    //Client -- mon_profil.php

    //This function is used in register.php
    public function searchClientWithMail($mail){
        $content = $this->model->EmailAlreadyExists($mail);
        return $content;
    }

    public function UpdateWithoutPasswordFields($nom, $prenom, $mail, $tel, $id){
        $this->model->UpdateClientWithoutPassword($nom, $prenom, $mail, $tel, $id);
    }

    public function MdpExistsInDatabase($id){
        $content = $this->model->RecupPassword($id);
        return $content;
    }

    public function UpdateWithPasswordFields($nom, $prenom, $mdp, $mail, $tel, $id){
        $this->model->UpdateClientWithPassword($nom, $prenom, $mdp, $mail, $tel, $id);
    }

    //Client -- appelHeader.php

    public function PersonalClientHeader($nom, $prenom, $mail){
        return $this->model->PersonalTextHeader($nom, $prenom, $mail);
    }

}