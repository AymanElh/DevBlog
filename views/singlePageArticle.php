<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Config\Database;
use Classes\BaseModel;
use Classes\Article;
use Classes\User;

$user = new User(new BaseModel(Database::connect()));

$articleId = $_GET['id'];

$article = (new Article(new BaseModel(Database::connect())))->getArticleById($articleId);


if(!$article) {
    header("Location: 404.php");
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
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .article-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .article-image {
            width: 100px;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
            background-color: red;
        }

        .article-title {
            margin-top: 20px;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .article-meta {
            color: #6c757d;
            margin-bottom: 20px;
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
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

    <!-- Article Content -->
    <div class="article-container">
        <img src="<?= $article['featured_image'] ?>" alt="Article Image" class="article-image">
        <h1 class="article-title"><?= $article['title'] ?></h1>
        <div class="article-meta">
            By <?= $user->getAuthorName($article['author_id']) ?> | <?= date('M d, Y', strtotime($article['created_at'])) ?>
        </div>
        <div class="article-content">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis accusamus, id fugit sed unde nemo quisquam libero, natus eos tenetur itaque vero velit architecto. Praesentium aspernatur nulla excepturi voluptate similique.
            Est ipsam architecto rem. Facere ab nobis iste unde et animi? Quod tenetur eligendi, debitis, deserunt cum quae, aperiam distinctio odit molestiae nam ea blanditiis dolor necessitatibus. Sunt, nostrum tenetur?
            Cum commodi officiis animi, laboriosam illum sapiente est tenetur, labore, quod aperiam nostrum neque rem ullam! Perspiciatis fuga dolorum nesciunt, quam natus quasi minus facere laborum. Quidem eligendi beatae culpa.
            Autem veniam enim aut minus illum architecto vero, eligendi nostrum omnis laboriosam reiciendis culpa quae? Commodi magni totam nobis dolor similique ipsam possimus. Facilis cupiditate cumque dolorum excepturi amet molestias?
            Fugit voluptatum provident, itaque corporis libero in inventore error vel sint, omnis praesentium nobis distinctio necessitatibus pariatur odit! Inventore facilis blanditiis ipsam earum fuga ex maxime suscipit molestiae quibusdam laborum.
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>