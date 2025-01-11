<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;
use Classes\BaseModel;
use Classes\Article;
use Classes\User;
use Handlers\UserHandler;

session_start();
// Database connection
$conn = Database::connect();
$dbHandler = new BaseModel($conn);
$user = new User($dbHandler);

// Fetch published articles
$articleModel = new Article($dbHandler);
$articles = $articleModel->getPublishedArticles();
// echo "<pre>";
// var_dump($articles);
// echo "</pre>";
UserHandler::logout();
// var_dump($_SESSION);

$keyword = isset($_GET['search-bar']) ? trim($_GET['search-bar']) : "";

if(!empty($keyword)) {
    $articles = $articleModel->searchArticles($keyword);

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevBlog - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            max-width: 600px;
            margin: 20px auto;
        }

        .article-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .article-card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid" style="width: 80vw;">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="./assets/img/image.png" alt="DevBlog Logo" style="width: 50px; height: auto;">
                <h1 class="ms-2 mb-0">DevBlog</h1>
            </a>

            <!-- Toggle Button for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex gap-2">
                    <?php if (!empty($_SESSION['user'])): ?>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="../views/profile.php" class="nav-link">Profile</a>
                            </li>
                            <?php if ($_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'author') : ?>
                                <li class="nav-item">
                                    <a href="../views/dashboard.php" class="nav-link">Dashboard</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <a href="../views/login.php" class="btn btn-outline-primary">Login</a>
                        <a href="../views/signup.php" class="btn btn-primary">Signup</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="?action=logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="container search-bar">
        <form class="d-flex" method="GET">
            <input class="form-control me-2" type="search" name="search-bar" placeholder="Search articles..." aria-label="Search">
            <button class="btn btn-outline-success" name="search-btn" type="submit">Search</button>
        </form>
    </div>

    <!-- Article Cards -->
    <div class="container my-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Example Article Card 1 -->
            <?php
            if (!empty($articles)) :
                foreach ($articles as $article) :
            ?>
                    <div class="col">
                        <div class="card article-card h-100">
                            <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Article Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($article['content']) ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><?= User::getAuthorName($article['author_id']) ?></small>
                                    <small class="text-muted"><?= $article['created_at'] ?></small>
                                </div>
                                <a href="../views/singlePageArticle.php/?id=<?= $article['id']; ?>" class="btn btn-primary mt-3">Read More</a>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
            ?>

        </div>
    </div>

    <!-- Footer -->
    <?php include("../views/components/footer.php"); ?>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


</body>

</html>