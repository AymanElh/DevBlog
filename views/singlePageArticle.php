<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;
use Classes\BaseModel;
use Classes\Article;
use Classes\Category;
use Classes\Tag;
use Classes\User;

$db = new BaseModel(Database::connect());
$categrory = new Category($db);
$tag = new Tag($db);

$user = new User($db);

if (isset($_GET['id'])) {
    $articleId = (int)$_GET['id'];
    $articleclass = new Article($db);
    $article = $articleclass->getArticleById($articleId);
    $tags = $articleclass->getArticleTags($articleId);
    // var_dump($article);
    $articleclass->incrementViews($articleId);
} else {
    header("Location: 404.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article['title'] ?> - DevBlog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../public/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .article-info {
            margin-bottom: 20px;
            font-size: 0.9em;
            color: #6c757d;
        }

        .article-info span {
            margin-right: 15px;
        }

        .article-info span:not(:last-child)::after {
            content: "|";
            margin-left: 15px;
            color: #ccc;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="../public/index.php">
                <img src="../../public/assets/img/image.png" alt="DevBlog Logo" style="width: 50px; height: auto;">
                <h1 class="ms-2 mb-0">DevBlog</h1>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><?= $article['title'] ?></h2>
                        <div class="article-info">
                            <span>Author: <?= $user->getAuthorName($article['author_id']) ?></span>
                            <span>Category: <?= $categrory->getCategoryName($article['category_id']) ?></span>
                            <span>Tags: </span>
                            <?php foreach($tags as $tag) : ?>
                                <span><?= Tag::getTagName($tag['tag_id'])  ?></span>
                            <?php endforeach; ?>
                            <span>Views: <?= $article['views'] ?></span>
                            <span>Date: <?= date('F j, Y', strtotime($article['created_at'])) ?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae similique velit magni iste, alias, dolores consectetur ab quis voluptatem adipisci dolorem rem repellat. Aliquam ullam ad nisi facere sequi rem.
                            Totam rem mollitia atque nemo nobis commodi, itaque dignissimos cupiditate fugit ad magnam voluptate at deserunt nulla explicabo eos est beatae praesentium voluptatum exercitationem minus libero quidem fuga necessitatibus! Fugiat!
                            Nostrum quos neque commodi nihil in delectus labore corporis excepturi sunt vitae! Natus sunt esse animi! Assumenda ullam ut neque dolores? Culpa numquam accusamus optio quisquam porro iure velit excepturi.
                            Nulla harum ad autem sunt tempora voluptate voluptates ipsum ab voluptatem, deleniti beatae deserunt quos nam accusantium aspernatur corrupti debitis accusamus. Consequatur quia repellat dignissimos excepturi quos officia dicta quis.
                            Quo repellat cupiditate qui error ex assumenda vitae? Ad, distinctio hic! Quos sequi suscipit veritatis consequatur! Quis veniam dolorum impedit, voluptas ullam consequatur, provident consectetur laudantium dolores commodi eveniet totam!
                            Mollitia ducimus ea sapiente saepe minus modi veniam quidem nisi cupiditate, amet totam repudiandae laudantium beatae quo accusamus similique, est alias ipsum iste magnam eius nemo. Repudiandae error tempore ducimus!
                            Rem magnam id temporibus facere dolorem? Repellat sed, consectetur, incidunt alias quo ipsam asperiores nisi cumque eos recusandae, ipsum deserunt ratione magnam reiciendis omnis esse neque. Quibusdam commodi nesciunt fuga?
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>