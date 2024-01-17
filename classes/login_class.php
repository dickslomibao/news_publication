<?php 
require_once "database.php";
class Login extends Database{
    private $username;
    private $password;

    function setUsername($data){
        $this->username = $data;
    }
    function setPassword($data){
        $this->password = $data;
    }

    function authenticate(){
        $pdo = $this->getConnection();
        $sql = "SELECT * FROM `account_credentials` where username = ? and password = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $this->username,
            $this->password,
        ]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function validateFirstTime(){
        $pdo = $this->getConnection();
        $sql = "SELECT * FROM `account_credentials` where username = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $this->username,
        ]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function changePass(){
        $pdo = $this->getConnection();
        $sql = "UPDATE `account_credentials` SET `password`= ?, `status` = ? WHERE username = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $this->password,
            1,
            $this->username
        ]);
    }
}

?>