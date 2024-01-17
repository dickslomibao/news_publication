<?php 
    require_once "database.php";
 class Writers extends Database{


    function getAllPersonalAndAcountInfo(){
        $pdo = $this->getConnection();
        $sql = "SELECT personal_information.*,account_credentials.* from personal_information,account_credentials WHERE personal_information.id = account_credentials.owner_id and personal_information.birthdate != '0000-00-00' and  (`role` = 5 or `role` = 0) and validator = 0";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getSingleWriterInfo($username){
        $pdo = $this->getConnection();
        $sql = "SELECT * FROM `account_credentials` WHERE username = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$username]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    
 }


?>