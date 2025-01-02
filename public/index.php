<?php 
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Category;
use Config\Database;
use Classes\BaseModel;
// require_once __DIR__ . '/../classes/BaseModel.php';

$conn = new Database;
$db = new BaseModel($conn);

$category = new Category($db);

$category->createCategory("Dev");

$result = $category->getAllCategories();

echo "<pre>";
print_r($result);
echo "</pre>";