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

    private function getCategoryId(string $cat) : array
    {
        $where = "name LIKE '$cat'";
        $result = $this->basemodel->selectRecords('categories', 'id', $where);   
        if(!$result) {
            return [];
        }
        return $result;
    }

    private function getTagId(string $tag) : array
    {
        $where = "name LIKE '$tag'";
        $result = $this->basemodel->selectRecords('tags', 'id', $where);
        if(!$result) {
            return [];
        }
        return $result;
    }

    public function createArticle(string $title, string $content, string $category, string $status, DateTime $scheduleDate) 
    {
        $categoryId = $this->getCategoryId($category);
        $data = [
            "title" => $title,
            "content" => $content,
            "category" => $categoryId,
            "status" => $status,
            "scheduleDate" => $scheduleDate
        ];
        $this->basemodel->insertRecord($this->table, $data);
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
