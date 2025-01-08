<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../config/error_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;
use DateTime;
use Exception;

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



    public function createArticle(array $data, array $tags)
    {
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


    public function updateArticle(int $id, array $data, array $tags)
    {
        $result = $this->basemodel->updateRecord($this->table, $data, $id);

        if(!$result) {
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

    public function getAllArticles() : array
    {
        $result = $this->basemodel->selectRecords($this->table);
        if(!$result) {
            return [];
        }

        return $result;
    }

    public function getArticleTags(int $article_id) : array
    {
        $where = "article_id = $article_id";
        $result = $this->basemodel->selectRecords('article_tags', 'tag_id', $where);
        if(!$result) {
            return [];
        }
        return $result;
    }
}
