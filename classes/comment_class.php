<?php
require_once 'database.php';
class Comment extends Database
{
    private $id;
    private $user_id;
    private $news_id;
    private $content;
    private $date;

    public function initialize($data)
    {
        $this->id = $data[0];
        $this->user_id = $data[1];
        $this->news_id = $data[2];
        $this->content = $data[3];
        $this->date = $data[4];
    }
    public function insert()
    {
        $pdo = $this->getConnection();
        $sql = "INSERT INTO `comments`(`id`, `content`, `owner_id`, `news_id`, `date`) VALUES (?,?,?,?,?)";
        $stmnt = $pdo->prepare($sql);
        $stmnt->execute([
            $this->id,
            $this->content,
            $this->user_id,
            $this->news_id,
            $this->date
        ]);
    }
    public function display($id, $limit)
    {
        $pdo = $this->getConnection();
        $sql = "SELECT comments.id, comments.content,comments.date,personal_information.id as owner_id,personal_information.course,personal_information.firstname,personal_information.lastname FROM comments,news,personal_information WHERE comments.owner_id = personal_information.id and news.id = comments.news_id and news.id = '$id' order BY comments.date ASC";
        $stmnt = $pdo->prepare($sql);
        $stmnt->execute();
        return $stmnt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComment($id, $ownerid)
    {
        $pdo = $this->getConnection();
        $sql = "SELECT * from comments where ID = ? and owner_id = ?";
        $stmnt = $pdo->prepare($sql);
        $stmnt->execute([
            $id,
            $ownerid,
        ]);
        return $stmnt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($content,$id, $ownerid)
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE `comments` SET content=? WHERE id = ? and owner_id = ?";
        $stmnt = $pdo->prepare($sql);
        $stmnt->execute([
            $content,
            $id,
            $ownerid,
        ]);
    }

    public function delete($id, $ownerid){
        $pdo = $this->getConnection();
        $sql = "DELETE FROM comments WHERE id = ? and owner_id = ?";
        $stmnt = $pdo->prepare($sql);
        $stmnt->execute([
            $id,
            $ownerid,
        ]);
    }
}
