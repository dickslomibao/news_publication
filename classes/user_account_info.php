<?php 
    require_once 'database.php';
    class AccountInformation extends Database{

        private $owner_id;
        private $username;
        private $email;
        private $password;
        private $profilepic;
        private $status;
        private $role;
        private $validator;
        function initialize($data){
            $this->username = $data[0];
            $this->email = $data[1];
            $this->password = $data[2];
        }
        function setOwnerid($data){
            $this->owner_id = $data;
        }
        function setProfilePic($data){
            $this->profilepic = $data;
        }
        function setRole($data){
            $this->role = $data;
        }
        function setStatus($data){
            $this->status = $data;
        }
        function setValidator($data){
            $this->validator = $data;
        }
        function insert(){
            $pdo = $this->getConnection();
            $sql = "INSERT INTO `account_credentials`(`owner_id`, `username`, `email`, `password`, `profilepic`,`status`,`role`,`validator`) VALUES (?,?,?,?,?,?,?,?)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                $this->owner_id,
                $this->username,
                $this->email,
                $this->password,
                $this->profilepic,
                $this->status,
                $this->role,
                $this->validator
            ]);
        }

        function restrict($id,$stats){
            $pdo = $this->getConnection();
            $sql = "UPDATE `account_credentials` SET `role` = ? where `owner_id` = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                $stats,
                $id,
            ]);
            return $statement->rowCount();
        }

        function getUsersAccountINfo($id){
            $pdo = $this->getConnection();
            $sql = "SELECT * from account_credentials where owner_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute([$id]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        function changePass($pass,$id){
            $pdo = $this->getConnection();
            $sql = "UPDATE `account_credentials` SET `password`= ? WHERE owner_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                $pass,
                $id
            ]);
        }
        function userUpdate($data){
            $pdo = $this->getConnection();
            $sql = "UPDATE `account_credentials` SET `username`=?,`email`=? where  owner_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute(
                $data
            );
        }

    }
