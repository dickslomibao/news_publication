<?php
require_once "database.php";

class Category extends Database
{
    private $id;
    private $title;
    private $descriptions;

    function setId($id){
        $this->id = $id;
    }
    function setTitle($title)
    {
        $this->title = $title;
    }
    function setDesc($descriptions)
    {
        $this->descriptions = $descriptions;
    }
    function insert(){
        $pdo = $this->getConnection();
        $sql = "INSERT INTO `categories`(`title`, `description`) VALUES (?,?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$this->title,$this->descriptions]); 
    }
    function delete(){
        $pdo = $this->getConnection();
        $sql = "DELETE FROM `categories` WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$this->id]);
    }
    function getCategoryList()
    {
        $pdo = $this->getConnection();
        $query = "SELECT * FROM categories ORDER BY id DESC";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getSingleCategory($id)
    {
        $pdo = $this->getConnection();
        $query = "SELECT * FROM categories where id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function update($data)
    {
        $pdo = $this->getConnection();
        $query = "UPDATE `categories` SET `title`=?,`description`=? WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute($data);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
