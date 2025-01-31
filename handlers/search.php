<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Article;
use Classes\BaseModel;
use Config\Database;

$article = new Article(new BaseModel(Database::connect()));

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : "";

// if (!empty($keyword)) {
    $articles = $article->searchArticles($keyword);
    // dump($articles);   
// }


header("Content-Type: application/json");
echo json_encode($articles);

