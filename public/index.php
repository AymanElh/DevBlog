<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Category;
use Config\Database;
use Classes\BaseModel;
use Classes\Article;
use Classes\Tag;
use Classes\User;
use Classes\Admin;
use Classes\Author;
use Auth\Auth;
// require_once __DIR__ . '/../classes/BaseModel.php';

// $conn = Database::connect();

// $dbHandler = new BaseModel($conn);

// if ($conn === null) {
//     die('Database connection failed.');
// }

// $category = new Category($dbHandler);
// // $category->createCategory('scinece');

// // $mysql = (new Tag($dbHandler))-> createTag('MySQL');


// $article = new Article($dbHandler);
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

// $article->deleteArticle(4);


// $user = new User($dbHandler);

// $userData = [
//     'John Doe',
//     'john_doe',
//     'john@example.com',
//     password_hash('password123', PASSWORD_BCRYPT), 
// ];

// $userId = $user->createUser(...$userData);

// echo $userId;

// $auth = new Auth($basemodel);

// $result = $auth->signup("yassine", "username", "yassin@gmail.com", "123456");
// print_r($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevBlog Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
        <div class="container">
            <!-- Navbar brand -->
            <a class="navbar-brand font-weight-bold" href="#">DevBlog</a>

            <!-- Toggler/collapsing button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <!-- Login button -->
                    <li class="nav-item">
                        <a href="../views/login.php" class="btn btn-outline-primary mr-2">Login</a>
                    </li>
                    <!-- Sign Up button -->
                    <li class="nav-item">
                        <a href="../views/signup.php" class="btn btn-primary">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>