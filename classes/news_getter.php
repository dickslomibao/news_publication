<?php

require_once "database.php";
class Newslist  extends Database
{

    function getSingleOnlySaveNews($id)
    {
        $pdo = $this->getConnection();
        $sql = "SELECT * from news where id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getSingleBreakingNews()
    {
        $pdo = $this->getConnection();
        $sql = "SELECT news.id, news.title as newstitle, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_published,news.image FROM news, personal_information, categories WHERE news.author_id = personal_information.id and categories.id = news.category and news.status = 1 and `breaking-news` = 1 ORDER BY news.date_published DESC limit 1";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getAllPublishedNews()
    {
        $pdo = $this->getConnection();
        $sql = "SELECT news.id, news.title as newstitle, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_published,news.image FROM news, personal_information, categories WHERE news.author_id = personal_information.id and categories.id = news.category and news.status = 1 ORDER BY news.date_published DESC";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getFeaturedNews($except)
    {
        $pdo = $this->getConnection();
        $sql = "SELECT news.id, news.title as newstitle, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_published,news.image FROM news, personal_information, categories WHERE news.author_id = personal_information.id and categories.id = news.category and news.status = 1 and `featured-news` = 1 and news.id != ? ORDER BY news.date_published DESC limit 4 ";
        $statement = $pdo->prepare($sql);
        $statement->execute([$except]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getallForFeaturedNews()
    {
        $pdo = $this->getConnection();
        $sql = "SELECT news.id, news.title as newstitle, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_published,news.image FROM news, personal_information, categories WHERE news.author_id = personal_information.id and categories.id = news.category and news.status = 1 and `featured-news` = 1 ORDER BY news.date_published";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getLatestPost($except)
    {
        $pdo = $this->getConnection();
        $sql = "SELECT news.id, news.title as newstitle, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_published,news.image FROM news, personal_information, categories WHERE news.author_id = personal_information.id and categories.id = news.category and news.status = 1 and `featured-news` = 0 and news.id != ? ORDER BY news.date_published DESC limit 4 ";
        $statement = $pdo->prepare($sql);
        $statement->execute([$except]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getAllNews()
    {
        $pdo = $this->getConnection();
        $sql = "SELECT news.id, news.title as newstitle, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_published,news.image FROM news, personal_information, categories WHERE news.author_id = personal_information.id and categories.id = news.category and news.status = 1 and `featured-news` = 0 ORDER BY news.date_published DESC";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getSingleNewsInfo($id)
    {
        try {
            $pdo = $this->getConnection();
            $sql = "SELECT news.id, news.title as newstitle, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_published,news.image FROM news, personal_information, categories WHERE news.author_id = personal_information.id and categories.id = news.category and news.status = 1 and news.id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute([$id]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    function getAllUnPublishedNews()
    {
        $pdo = $this->getConnection();
        $sql = "SELECT news.id, news.title as newstitle, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_created,news.remarks FROM news, personal_information, categories WHERE news.author_id = personal_information.id and categories.id = news.category and news.status = 0 ORDER BY news.date_created DESC";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getPopularNews()
    {
        $pdo = $this->getConnection();
        $sql = "SELECT newsid, COUNT(*) as total from views GROUP BY newsid ORDER BY total desc limit 3";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    function getViewsOfSingleNews($id)
    {
        $pdo = $this->getConnection();
        $sql = "SELECT COUNT(*) as total from views where newsid = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['total'];
    }
    function getNewsOfCategory($id,$except)
    {
        $pdo = $this->getConnection();
        $sql = "SELECT news.id, news.title as newstitle, categories.title as category, CONCAT(personal_information.firstname, ' ', personal_information.middlename, ' ',personal_information.lastname) as fullname, news.date_published,news.image FROM news, personal_information, categories WHERE news.author_id = personal_information.id and categories.id = news.category and news.status = 1 and news.category = ? and news.id != ? ORDER BY news.date_published DESC";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id,$except]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
