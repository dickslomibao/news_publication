<?php
require_once 'database.php';
class News extends Database
{
    private $id;
    private $title;
    private $category;
    private $content;
    private $author;
    private $status;
    private $date;
    private $breaking;
    private $featured;
    private $image;
    function setId($data)
    {
        $this->id = $data;
    }
    function setTitle($data)
    {
        $this->title = $data;
    }
    function setCategory($data)
    {
        $this->category = $data;
    }
    function setContent($data)
    {
        $this->content = $data;
    }
    function setAuthor($data)
    {
        $this->author = $data;
    }
    function setStatus($data)
    {
        $this->status = $data;
    }
    function setDate($data)
    {
        $this->date = $data;
    }
    function setBreaking($data)
    {
        $this->breaking = $data;
    }
    function seFeatured($data)
    {
        $this->featured = $data;
    }
    function setImage($data)
    {
        $this->image = $data;
    }
    function insert()
    {
        date_default_timezone_set('Asia/Manila');
        $pdo = $this->getConnection();
        $sql = "INSERT INTO `news`(`id`, `title`, `category`, `description`, `author_id`,`date_published`, `status`,`breaking-news`, `featured-news`,`image`,`remarks`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $this->id,
            $this->title,
            $this->category,
            $this->content,
            $this->author,
            $this->date,
            $this->status,
            $this->breaking,
            $this->featured,
            $this->image,
            'For validation'
        ]);
    }

    function comfirmNews($data)
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE `news` SET `remarks`='Ready to publish' WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $data
        ]);
    }

    function setBreakingNews($data)
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE `news` SET `breaking-news`=1 WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $data
        ]);
    }
    function setRemarks($data)
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE `news` SET `remarks`=? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute($data);
    }
    function updateSaveNewsAndPublished()
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE `news` SET `title`=?,`category`=?,`description`=?,`date_published`=?,`status`=?,`breaking-news`=?,`featured-news`=?, `image` = ?, `remarks`= ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $this->title,
            $this->category,
            $this->content,
            $this->date,
            $this->status,
            $this->breaking,
            $this->featured,
            $this->image,
            'published',
            $this->id,
            
        ]);
    }
    function updateSaveNews()
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE `news` SET `title`=?,`category`=?,`description`=?, `image`=?,`remarks`= ?  WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $this->title,
            $this->category,
            $this->content,
            $this->image,
            'For validation',
            $this->id,
           
        ]);
    }
    function unpublishedNews()
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE `news` SET status=0, remarks = ? where id= ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'For validation',
            $this->id,
        ]);
    }
    function publishedNews()
    {
        date_default_timezone_set('Asia/Manila');
        $pdo = $this->getConnection();
        $sql = "UPDATE `news` SET status=1 , date_published = ?, remarks = ? where id= ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            date("Y-m-d H:i:s"),
            'published',
            $this->id
        ]);
    }
    function deleteNews()
    {
        $pdo = $this->getConnection();
        $sql = "DELETE FROM news where id= ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            $this->id,
        ]);
    }
}
