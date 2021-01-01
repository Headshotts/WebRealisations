<?php
    namespace app\config;
    use PDO;
    use PDOException;

    class Database{

        private $host;
        private $db_name;
        private $username;
        private $password;
        private $conn;

        public function __construct(){
            $this->host = "localhost";
            $this->db_name = "voyages";
            $this->username = "root";
            $this->password = "";
            $this->conn = $this->getConnection(); //Rajoutée
        }

        public function getConnection(){

            $this->conn = null;

            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }


?>