<?php 
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Category;
use Config\Database;
use Classes\BaseModel;
use Classes\Article;
use Classes\Tag;
// require_once __DIR__ . '/../classes/BaseModel.php';

$conn = Database::connect();

$dbHandler = new BaseModel($conn);

if ($conn === null) {
    die('Database connection failed.');
}

$category = new Category($dbHandler);
// $category->createCategory('scinece');

// $mysql = (new Tag($dbHandler))-> createTag('MySQL');


$article = new Article($dbHandler);
// $article->createArticle('How to Create a Slug from an Article Title!', 'some content', '/uploads/image.png', 'Dev', 'scheduled', '2025-01-05', 1, ['php']);

// $article->updateArticle(
//     3, 
//     title: 'Updated Article Title', 
//     content: 'Updated content for the article.',
//     picture: 'updateimg.png',
//     category: 'Dev',
//     status: 'published',
//     scheduleDate: '2025-01-15',
//     tags: ['PHP', 'MySQL']
// );