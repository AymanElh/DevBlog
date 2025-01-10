<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../config/error_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;
use DateTime;
use Config\Database;
use Exception;
use PDO;

class Article
{
    // private string $title;
    // private string $content;
    // private string $category;
    // private string $status;
    // private DateTime $scheduleDate;
    // private Author $author;
    private static $views = 0;

    private BaseModel $basemodel;
    private string $table = 'articles';

    function __construct(BaseModel $basemodel)
    {
        $this->basemodel = $basemodel;
    }

    public function getCategoryId(string $cat): ?int
    {

        try {
            $where = "name LIKE '$cat'";
            $result = $this->basemodel->selectRecords('categories', 'id', $where);

            if (!$result) {
                return null;
            }
            return $result[0]['id'];
        } catch (Exception $e) {
            error_log("Can not get category id: " .  $e->getMessage());
            return null;
        }
    }

    private function getTagId(string $tag): ?int
    {
        try {
            $where = "name LIKE '$tag'";
            $result = $this->basemodel->selectRecords('tags', 'id', $where);
            if (!$result) {
                return null;
            }
            return $result[0]['id'];
        } catch (Exception $e) {
            error_log("Can not get tag id: " . $e->getMessage());
            return null;
        }
    }

    public static function getSlug(string $title): string
    {
        $title = strtolower($title);
        $title = str_replace(' ', '-', $title);
        $title = preg_replace('/[^a-z0-9\-]/', '', $title);
        return $title;
    }



    public function createArticle($title, $content, $filePath, $categoryId, $scheduledDate, $author, $tags)
    {

        $data = [
            'title' => $title,
            'content' => $content,
            'featured_image' => $filePath,
            'category_id' => $categoryId,
            // 'status' => $status,
            'scheduled_date' => $scheduledDate,
            'author_id' => $author,
            'slug' => $this->getSlug($title)
        ];

        $id = $this->basemodel->insertRecord($this->table, $data);

        if ($id === 0) {
            throw new Exception("Error inserting article");
        }

        if ($tags) {
            foreach ($tags as $tag) {
                $this->basemodel->insertRecord('article_tags', ['article_id' => $id, 'tag_id' => (int)$tag]);
            }
        }
    }



    public function updateArticle(string $title, string $content, string $filePath, int $categoryId, string $scheduledDate, int $author, int $id, array $tags)
    {

        $data = [
            'title' => $title,
            'content' => $content,
            'featured_image' => $filePath,
            'category_id' => $categoryId,
            'scheduled_date' => $scheduledDate,
            'author_id' => $author,
            'slug' => $this->getSlug($title),
        ];

        $result = $this->basemodel->updateRecord($this->table, $data, $id);

        if (!$result) {
            throw new Exception("Error updating Article");
        }

        if ($tags) {
            $this->basemodel->deleteRecord($this->table, $id, 'article_id');
            foreach ($tags as $tag) {
                $this->basemodel->insertRecord('article_tags', ['article_id' => $id, 'tag_id' => $this->getTagId($tag)]);
            }
        }
    }


    public function deleteArticle(int $id): bool
    {
        try {
            $this->basemodel->deleteRecord($this->table, $id);
            return true;
        } catch (Exception $e) {
            error_log("article can not be deleted: " . $e->getMessage());
            return false;
        }
    }

    public function getArticlesByAuthor(int $author_id): array
    {
        $where = "author_id = $author_id";
        return $this->basemodel->selectRecords($this->table, '*', $where);
    }

    public function getArticleById(int $article_id): array
    {
        $where = "id = $article_id";
        $result =  $this->basemodel->selectRecords($this->table, '*', $where);
        return $result ? $result[0] : [];
    }

    public function getAllArticles(): array
    {
        $result = $this->basemodel->selectRecords($this->table);
        if (!$result) {
            return [];
        }

        return $result;
    }

    public function getArticleTags(int $article_id): array
    {
        $where = "article_id = $article_id";
        $result = $this->basemodel->selectRecords('article_tags', 'tag_id', $where);
        if (!$result) {
            return [];
        }
        return $result;
    }

    public function getCountArticles(): int
    {
        $result = $this->basemodel->selectRecords($this->table, 'COUNT(*) AS TotalArticles');
        return $result ? $result[0]['TotalArticles'] : 0;
    }


    public static function topAuthors(): ?array
    {
        $query = "SELECT full_name, COUNT(articles.id) AS totalArticles, profile_picture_url FROM articles
                    JOIN users ON users.id = articles.author_id
                    WHERE users.role LIKE 'author'
                    GROUP BY author_id
                    ORDER BY totalArticles";

        $stmt = (Database::connect())->prepare($query);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }

        return $result ?: [];
    }

    public static function mostReadArticles(): ?array
    {
        $query = "SELECT title, created_at, featured_image, views FROM articles ORDER BY views DESC LIMIT 10";
        $stmt = (Database::connect())->prepare($query);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
        return $result ?: [];
    }

    public function getRecentArticles()
    {
        $query = "
        SELECT 
            articles.id AS id, 
            articles.title AS title, 
            articles.featured_image AS featured_image, 
            articles.created_at AS created_at, 
            articles.views, 
            authors.full_name AS author_name, 
            categories.name AS category_name,
            GROUP_CONCAT(tags.name SEPARATOR ',') AS tags
        FROM articles
        LEFT JOIN users AS authors ON articles.author_id = authors.id
        LEFT JOIN categories ON articles.category_id = categories.id
        LEFT JOIN article_tags ON articles.id = article_tags.article_id
        LEFT JOIN tags ON article_tags.tag_id = tags.id
        GROUP BY articles.id
        ORDER BY articles.created_at DESC
        LIMIT 5
    ";

        $stmt = (Database::connect())->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPublishedArticles()
    {
        $query = "SELECT * FROM articles WHERE status = 'published' ORDER BY scheduled_date DESC";
        $stmt = (Database::connect())->prepare($query);
        if($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }
}
