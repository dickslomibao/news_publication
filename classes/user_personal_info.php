<?php
require_once 'database.php';
class PersonalInformation extends Database
{

    private $id;
    private $firstname;
    private $middlename;
    private $lastname;
    private $birthdate;
    private $sex;
    private $mobilenumber;
    private $address;
    private $course;

    function initialize($data)
    {
        $this->firstname = $data[0];
        $this->middlename = $data[1];
        $this->lastname = $data[2];
        $this->birthdate = $data[3];
        $this->sex = $data[4];
        $this->mobilenumber = $data[5];
        $this->address = $data[6];
        $this->course = $data[7];
    }

    function setId($data)
    {
        $this->id = $data;
    }

    function insert()
    {
        $pdo = $this->getConnection();
        $sql = "INSERT INTO `personal_information`(`id`, `firstname`, `lastname`, `middlename`, `birthdate`, `sex`, `mobilenumber`, `address`, `course`) VALUES (?,?,?,?,?,?,?,?,?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $this->id,
            $this->firstname,
            $this->lastname,
            $this->middlename,
            $this->birthdate,
            $this->sex,
            $this->mobilenumber,
            $this->address,
            $this->course
        ]);
    }

    function getUsersAccountOnly()
    {
        $pdo = $this->getConnection();
        $sql = "SELECT personal_information.*,account_credentials.* from personal_information,account_credentials WHERE personal_information.id = account_credentials.owner_id and personal_information.middlename = '' and  (`role` = 2 or `role` = 5)";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function getUsersPersonalInfo($id)
    {
        $pdo = $this->getConnection();
        $sql = "SELECT * from personal_information where id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function userUpdate($data)
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE `personal_information` SET `firstname`=?,`lastname`=?,`sex`=?,`course`=? where id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(
            $data
        );
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function adminUpdate($data)
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE `personal_information` SET `firstname`=?,`middlename`=?,`lastname`=?,`birthdate`=?,`sex`=?,`mobilenumber`=?,`address`=?,`course`=? where id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(
            $data
        );
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
