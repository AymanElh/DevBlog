<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../config/error_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;
use DateTime;

class Article
{
    private string $title;
    private string $content;
    private string $category;
    private string $status;
    private DateTime $scheduleDate;
    // private Author $author;
    private static $views = 0;

    private BaseModel $basemodel;
    private string $table = 'articles';

    function __construct(BaseModel $basemodel)
    {
        $this->basemodel = $basemodel;
    }

    private function getCategoryId(string $cat) : int
    {
        $where = "name LIKE '$cat'";
        $result = $this->basemodel->selectRecords('categories', 'id', $where);   
        if(!$result) {
            return [];
        }
        return $result[0]['id'];
    }

    private function getTagId(string $tag) : int
    {
        $where = "name LIKE '$tag'";
        $result = $this->basemodel->selectRecords('tags', 'id', $where);
        if(!$result) {
            return [];
        }
        return $result[0]['id'];
    }

    private function getSlug(string $title) : string
    {
        $title = strtolower($title);
        $title = str_replace(' ' , '-', $title);
        $title = preg_replace('/[^a-z0-9\-]/', '', $title); 
        return $title;
    }

    public function createArticle(string $title, string $content, string $picture, string $category, string $status, string $scheduleDate, int $author_id, array $tags) 
    {
        $data = [
            "title" => $title,
            "slug" => $this->getSlug($title),
            "content" => $content,
            "featured_image" => $picture,
            "category_id" => $this->getCategoryId($category),
            "status" => $status,
            "scheduled_date" => $scheduleDate,
            "author_id" => $author_id
        ];
        $lastId = $this->basemodel->insertRecord($this->table, $data);
        echo "Last inserted id: $lastId";
        foreach($tags as $tag) {
            $this->basemodel->insertRecord('article_tags', ['article_id' => $lastId, 'tag_id' => $this->getTagId($tag)]);
        }
        
    }

    public function updateArticle()
    {

    }

    public function deleteArticle() 
    {

    }

    public static function getAllArticles()
    {
        
    }
}
