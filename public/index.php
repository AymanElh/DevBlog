<?php 
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Category;
use Config\Database;
use Classes\BaseModel;
// require_once __DIR__ . '/../classes/BaseModel.php';

$conn = Database::connect();

$dbHandler = new BaseModel($conn);

if ($conn === null) {
    die('Database connection failed.');
}

$category = new Category($dbHandler);
$category->createCategory('Dev');

