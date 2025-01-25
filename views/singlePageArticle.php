<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;
use Classes\BaseModel;
use Classes\Article;
use Classes\Category;
use Classes\Tag;
use Classes\User;

session_start();

$db = new BaseModel(Database::connect());
$categrory = new Category($db);
$tag = new Tag($db);

$user = new User($db);

if (isset($_GET['id'])) {
    $articleId = (int)$_GET['id'];
    $articleclass = new Article($db);
    $article = $articleclass->getArticleById($articleId);
    $tags = $articleclass->getArticleTags($articleId);

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .article-content {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid" style="width: 80vw;">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center gap-5" href="../public/index.php">
                <img src="../public/assets/img/image.png" alt="DevBlog Logo" style="width: 50px; height: auto;">
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
                                    <a href="../views/dashboard.php" class="nav-link ">Dashboard</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <a href="./login.php" class="btn btn-primary">Login</a>
                        <a href="./signup.php" class="btn btn-primary">Signup</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="article-content">
            <h1><?= $article['title'] ?></h1>
            <p class="text-muted">Published on <?= $article['created_at'] ?> by <?= $user->getAuthorName($article['author_id']) ?></p>
            <img src="../public/assets/img/<?= $article['featured_image'] ?>" alt="Article Image" class="img-fluid mb-4">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos nulla molestiae temporibus repudiandae totam consequuntur possimus. Quis doloremque quasi unde laborum facere voluptate, quidem porro at distinctio maiores repellendus! Perferendis.
                Modi at assumenda recusandae quisquam ratione ab, amet itaque repellendus dicta animi optio cum consectetur perferendis ipsam similique sint reiciendis, laborum velit ex minus et? Consequatur ullam laudantium reiciendis similique?
                Deserunt ipsam doloribus tenetur, accusantium, eum facilis dolor aperiam commodi natus consequuntur animi, consequatur maxime nostrum eius repellendus asperiores dicta reiciendis. Tempore adipisci delectus incidunt voluptas porro? Illo, tempora voluptates.
                Dicta ab voluptates, similique porro repellat praesentium nisi asperiores facilis? Vitae dignissimos, quam sunt accusamus aliquam eaque nulla praesentium magnam sit officia, necessitatibus similique saepe sed quisquam veniam soluta error?
                A deleniti voluptas repellendus sequi iusto qui, harum obcaecati ab explicabo ullam laboriosam animi praesentium eaque iste cumque in! Fugiat numquam nam, cum voluptatem ratione modi perferendis eum odio consectetur.
                Soluta voluptas quas doloremque mollitia, velit necessitatibus, omnis minus vel tempora, harum fugiat aspernatur in perferendis quaerat quibusdam iure odit nulla distinctio maxime? Fugit maiores, adipisci soluta debitis quibusdam minima!
                Ex, reprehenderit? Nisi provident beatae perferendis illo sunt ad, pariatur quaerat numquam laudantium iste sequi nulla corporis exercitationem temporibus quia, sapiente debitis tenetur laboriosam ea eveniet at ut. Quaerat, nostrum.
                Laudantium, consequatur, ducimus aut dignissimos similique neque vel cupiditate accusamus facere ab, eveniet non vero blanditiis sequi? Est praesentium mollitia minus distinctio sint, excepturi rem dolorum fugit et facere. Distinctio.
                A explicabo vel tenetur architecto, adipisci commodi ut, beatae cum tempore maxime fugit vitae eos, nostrum excepturi qui odio nulla placeat error. Hic dicta molestias repudiandae aliquam voluptatum delectus. Optio.
                Quis nisi minus eius quibusdam libero repudiandae voluptatibus consequuntur sapiente asperiores excepturi architecto blanditiis unde, ipsam cupiditate recusandae impedit odit atque dignissimos perferendis ab harum corrupti. Architecto saepe praesentium quas?</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>