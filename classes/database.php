<?php 

class Database{

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "gazsent";
    private $connection;

    function __construct()
    {
        try{
            $this->connection = new PDO(
                "mysql:host=$this->host;dbname=$this->db",
                $this->user,
                $this->pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            return $this->connection;
        }catch(PDOException $ex){
            echo "Error: " . $ex->getMessage();
        }
    }

    function getConnection(){
        return $this->connection;
    }

    function closeConnection(){
        $this->connection = null;
    }
}



?>