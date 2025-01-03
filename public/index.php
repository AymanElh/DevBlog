<?php 
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Category;
use Config\Database;
use Classes\BaseModel;
use Classes\Article;
// require_once __DIR__ . '/../classes/BaseModel.php';

$conn = Database::connect();

$dbHandler = new BaseModel($conn);

if ($conn === null) {
    die('Database connection failed.');
}

$category = new Category($dbHandler);
// $category->createCategory('scinece');


$article = new Article($dbHandler);
// $article->createArticle('How to Create a Slug from an Article Title!', 'some content', '/uploads/image.png', 'Dev', 'scheduled', '2025-01-05', 1, ['php']);