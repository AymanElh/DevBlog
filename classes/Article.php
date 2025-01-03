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

    private function getCategoryId(string $cat): ?int
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

    private function getSlug(string $title): string
    {
        $title = strtolower($title);
        $title = str_replace(' ', '-', $title);
        $title = preg_replace('/[^a-z0-9\-]/', '', $title);
        return $title;
    }

    public function createArticle(string $title, string $content, string $picture, string $category, string $status, string $scheduleDate, int $author_id, array $tags): bool
    {
        try {
            $categoryid = $this->getCategoryId($category);
            if ($categoryid === null) {
                throw new Exception("category id cannot be null");
            }
            $data = [
                "title" => $title,
                "slug" => $this->getSlug($title),
                "content" => $content,
                "featured_image" => $picture,
                "category_id" => $categoryid,
                "status" => $status,
                "scheduled_date" => $scheduleDate,
                "author_id" => $author_id
            ];
            $lastId = $this->basemodel->insertRecord($this->table, $data);

            foreach ($tags as $tag) {
                $this->basemodel->insertRecord('article_tags', ['article_id' => $lastId, 'tag_id' => $this->getTagId($tag)]);
            }
            return true;
        } catch (Exception $e) {
            error_log("Error creating the article: " . $e->getMessage());
            return false;
        }
    }


    public function updateArticle(int $id, string $title = null, string $content = null, string $picture = null, string $category = null, string $status = null, string $scheduleDate = null, array $tags = null): bool
    {
        try {
            $data = [];

            if ($title) {
                $data["title"] = $title;
                $data["slug"] = $this->getSlug($title);
            }
            if ($content) {
                $data["content"] = $content;
            }
            if ($picture) {
                $data["featured_image"] = $picture;
            }
            if ($category) {
                $data["category_id"] = $this->getCategoryId($category);
            }
            if ($status) {
                $data["status"] = $status;
            }
            if ($scheduleDate) {
                $data["scheduled_date"] = $scheduleDate;
            }

            if (!empty($data)) {
                $this->basemodel->updateRecord($this->table, $data, $id);
            }

            if ($tags) {
                $this->basemodel->deleteRecord('article_tags', $id, 'article_id');

                foreach ($tags as $tag) {
                    $this->basemodel->insertRecord('article_tags', ['article_id' => $id, 'tag_id' => $this->getTagId($tag)]);
                }
            }
        } catch (Exception $e) {
            error_log("Error updating the article" . $e->getMessage());
            return false;
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

    public static function getAllArticles() {}
}
