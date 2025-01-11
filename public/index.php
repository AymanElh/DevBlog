<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;
use Classes\BaseModel;
use Classes\Article;
use Handlers\UserHandler;

session_start();
// Database connection
$conn = Database::connect();
$dbHandler = new BaseModel($conn);

// Fetch published articles
$articleModel = new Article($dbHandler);
$articles = $articleModel->getPublishedArticles();
// var_dump($articles);
UserHandler::logout();
// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";

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
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm py-3">
        <div class="container">
            <!-- Navbar brand -->
            <a style="font-size: 24px;" class="navbar-brand font-weight-bold text-primary" href="#">DevBlog</a>

            <!-- Toggler/collapsing button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if (!empty($_SESSION['user'])) : ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="../views/profile.php" class="nav-link">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="../views/dashboard.php" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                <?php else : ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="../views/login.php" class="btn btn-outline-primary mr-2">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="../views/signup.php" class="btn btn-primary">Sign Up</a>
                        </li>
                    </ul>
                <?php endif; ?>
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
                            <?= $article['featured_image']; ?>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="?action=logout">Logout</a>
                </div>
            </div>
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