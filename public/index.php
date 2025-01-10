<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;
use Classes\BaseModel;
use Classes\Article;

// Database connection
$conn = Database::connect();
$dbHandler = new BaseModel($conn);

// Fetch published articles
$articleModel = new Article($dbHandler);
$articles = $articleModel->getPublishedArticles();
// var_dump($articles);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevBlog - Home</title>
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

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="text-center font-weight-bold">Welcome to DevBlog</h1>
        <p class="text-center text-muted">Your go-to platform for the latest in development and tech.</p>

        <!-- Articles Section -->
        <div class="row">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <?=  $article['featured_image']; ?>
                            <img src="C:\Users\Youcode\Desktop\Briefs\Brief-10 DevBlog\handlers/../public/assets/img/Blank diagram.png" class="card-img-top" alt="Article Image" style="width: 300px; height: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                                <p class="card-text text-muted">
                                    <?= htmlspecialchars(substr($article['excerpt'], 0, 100)) ?>...
                                </p>
                                <a href="article.php?slug=<?= htmlspecialchars($article['slug']) ?>" class="btn btn-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">No articles available at the moment. Check back later!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-5">
        <div class="container text-center">
            <p class="text-muted mb-0">&copy; <?= date('Y') ?> DevBlog. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
