<?php


namespace app\model;
require_once("app/config/database.php");
use app\config\Database;
use PDO;
//Ecrire les lignes où apparaissent les différentes requêtes dans le PHP procédural + Enlever les lettres si possibles ou modifier la fonction du modèle
class model
{
    private $connexion;
    protected $table;

    public function __construct(){
        $db = new Database();
        $this->connexion = $db->getConnection();
    }

    public function read($id){
        $requete = "SELECT * FROM " . $this->table . " WHERE id = $id";
        $count = $this->connexion->query($requete);
        $resultat = $count->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
    }

    //Modifier toutes les requêtes pour enlever les lettres R pour Reservations et D pour Destination.
    //Ou rajouter derrière $this->table, $letter pour référencer la lettre derrière la table.
    public function find($data=array())
    {

        $conditions="1";
        $fields="*";
        $letter = "";
        $limit="";
        $order=$this->table.".id$this->table ASC"; //Rajout du $this->table derrière le .id
        $othertable="";
        if(isset($data["letter"])){$letter=$data["letter"];}
        if(isset($data["conditions"])){$conditions=$data["conditions"];}
        if(isset($data["fields"])){$fields=$data["fields"];}
        if(isset($data["limit"])){$limit="LIMIT".$data["limit"];}
        if(isset($data["order"])){$order=$data["order"];}
        if(isset($data["othertable"])){$othertable=$data["othertable"];}
        //if(isset($data["othertable"])){$othertable=','.$data["othertable"];}


        $sql="SELECT $fields FROM ". $this->table. " " . $letter . " ".$othertable." WHERE $conditions ORDER BY $order $limit";
        //echo $sql;
        $prepa=$this->connexion->prepare($sql);

        $prepa->execute();

        $data=$prepa->fetchAll(PDO::FETCH_ASSOC);


        return $data;

    }

    public function insert($data=array()){
        $columns="";
        $values = "";
        if(isset($data["columns"])){$columns=$data["columns"];}
        if(isset($data["values"])){$values=$data["values"];}
        $sql = "INSERT INTO " . $this->table . "($columns)" .  " VALUES " . "($values)";
        //echo $sql;
        $prepa=$this->connexion->prepare($sql);

        $prepa->execute();
        /* $req->execute(array(
            'data_colonne1' => $obj->data_colonne1,
            'data_colonne2' => $obj->data_colonne2,
            'data_colonne4' => $obj->data_colonne4
        ));
        */
        return $data;
    }

    public function newupdate($data){
        $letter = "";
        $fields = "";
        $conditions = "";
        if(isset($data["letter"])){$letter=$data["letter"];}
        if(isset($data["fields"])){$fields=$data["fields"];}
        if(isset($data["conditions"])){$conditions=$data["conditions"];}

        $sql = "UPDATE $this->table $letter SET " ;
        foreach($fields as $key => $value) {
            if(is_numeric($value)){
                $sql .= "$key = $value,";
            }else{
                $sql .= "$key = '$value',";
            }
        }
        $sql = substr($sql, 0, -1);
        $sql .= " WHERE $conditions";
        //echo $sql;
        $retour=$this->connexion->exec($sql);

        return $retour;
    }


    public function delete($data=array()){

        $conditions="1";

        if(isset($data["conditions"])){$conditions=$data["conditions"];}

        $sql = "DELETE FROM " . $this->table . " WHERE $conditions";
        echo $sql;
        $prepa=$this->connexion->prepare($sql);
        $prepa->execute();
        $data=$prepa->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }



}