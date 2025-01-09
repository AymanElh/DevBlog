<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;
use Classes\Category;
use Classes\Tag;
use Classes\Article;
use Config\Database;
use Classes\User;
use Handlers\CategoryHandler;
use Handlers\TagHandler;
use Handlers\ArticleHandler;
use Auth\Auth;

$baseModel = new BaseModel(Database::connect());

$auth = new Auth($baseModel);
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $auth->logout();
    header("Location: login.php");
    exit();
}

$user = new User($baseModel);
$category = new Category($baseModel);
$categoryHandler = new CategoryHandler($category);
$categories = $categoryHandler->getAllCategories();

$tagHandler = new TagHandler(new Tag($baseModel));
$allTags = Tag::getAllTags();


$articleHandler = new ArticleHandler(new Article($baseModel));
$articles = $articleHandler->getAllArticles();
$articleHandler->addArticle();
$articleHandler->deleteArticle();
$articleHandler->updateArticle();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom styles for this template-->
    <link href="../public/assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


</head>

<body>

    <div id="wrapper">

        <?php include './components/sidebar.php'; ?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './components/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Articles</h1>
                        <!-- Add Article Button -->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addArticleModal">Add Article</button>
                    </div>

                    <!-- Articles List -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Article List</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Tags</th>
                                        <th>Author</th>
                                        <th>Schedule date</th>
                                        <th>Status</th>
                                        <th>Views</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($articles as $article) :
                                        $tags = $articleHandler->getArticleTags($article['id']);

                                    ?>
                                        <tr>
                                            <td><?= $count++ ?></td>
                                            <td><?= htmlspecialchars($article['title']) ?></td>
                                            <td>Science</td>
                                            <td><?= implode(' ', $tags) ?></td>
                                            <td><?= User::getAuthorName($article['author_id']) ?></td>
                                            <td><?= htmlspecialchars($article['scheduled_date']) ?></td>
                                            <td><?= htmlspecialchars($article['status']) ?></td>
                                            <td><?= htmlspecialchars($article['views']) ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editArticleModal<?= $article['id']; ?>">Edit</button>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteArticleModal<?= $article['id']; ?>">Delete</button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="editArticleModal<?= $article['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editArticleModalLabel<?= $article['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editArticleModalLabel<?= $article['id'] ?>">Edit Article</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                                            <!-- Title -->
                                                            <div class="form-group">
                                                                <label for="articleTitle<?= $article['id'] ?>">Title</label>
                                                                <input type="text" class="form-control" id="articleTitle<?= $article['id'] ?>" name="title" value="<?= htmlspecialchars($article['title']) ?>" required>
                                                            </div>
                                                            <!-- Content -->
                                                            <div class="form-group">
                                                                <label for="articleContent<?= $article['id'] ?>">Content</label>
                                                                <textarea class="form-control" id="articleContent<?= $article['id'] ?>" name="content" rows="5" required><?= htmlspecialchars($article['content']) ?></textarea>
                                                            </div>
                                                            <!-- Category -->
                                                            <div class="form-group">
                                                                <label for="articleCategory<?= $article['id'] ?>">Category</label>
                                                                <select class="form-control" id="articleCategory<?= $article['id'] ?>" name="category" required>
                                                                    <?php foreach ($categories as $category): ?>
                                                                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $article['category_id'] ? 'selected' : '' ?>>
                                                                            <?= htmlspecialchars($category['name']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <!-- Tags -->
                                                            <div class="form-group">
                                                                <label for="articleTags<?= $article['id'] ?>">Tags</label>
                                                                <select class="form-control" id="articleTags<?= $article['id'] ?>" name="tags[]" multiple>
                                                                    <?php foreach ($allTags as $tag): ?>
                                                                        <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $tags) ? 'selected' : '' ?>>
                                                                            <?= htmlspecialchars($tag['name']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <!-- Image -->
                                                            <div class="form-group">
                                                                <label for="articleImage<?= $article['id'] ?>">Image</label>
                                                                <input type="file" class="form-control" id="articleImage<?= $article['id'] ?>" name="image" accept="image/*">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="update-article" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="deleteArticleModal<?= $article['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteArticleModalLabel<?= $article['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteArticleModalLabel<?= $article['id'] ?>">Delete Article</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="">
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this article?
                                                            <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="delete-article" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </tbody>
                </table>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include './components/footer.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>

    <!-- Modal Form for Adding an Article -->
    <div class="modal fade" id="addArticleModal" tabindex="-1" role="dialog" aria-labelledby="addArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addArticleModalLabel">Add New Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="articleTitle">Title</label>
                            <input type="text" class="form-control" id="articleTitle" name="article-title" placeholder="Enter article title" required>
                        </div>
                        <!-- Content -->
                        <div class="form-group">
                            <label for="articleContent">Content</label>
                            <textarea class="form-control" id="articleContent" name="article-content" rows="5" placeholder="Enter article content" required></textarea>
                        </div>
                        <!-- Category -->
                        <div class="form-group">
                            <label for="articleCategory">Category</label>
                            <select class="form-control" id="articleCategory" name="article-category" required>
                                <option value="" disabled selected>Select category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['name']); ?>">
                                        <?= htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Tags -->
                        <div class="form-group">
                            <label for="articleTags">Tags</label>
                            <select class="form-control" id="articleTags" name="tags[]" multiple>
                                <?php foreach ($allTags as $tag): ?>
                                    <option value="<?= $tag['id'] ?>"><?= $tag['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">Hold Ctrl (or Cmd) to select multiple tags.</small>
                        </div>
                        <!-- Image -->
                        <div class="form-group">
                            <label for="articleImage">Image</label>
                            <input type="file" class="form-control" id="article-image" name="article-img" accept="image/*">
                        </div>
                        <!-- Scheule date -->
                        <div class="form-group">
                            <label for="articleImage">Date</label>
                            <input type="date" class="form-control" id="schedule-date" name="schedule-date" accept="image/*">
                        </div>
                        <!-- Description -->
                        <!-- <div class="form-group">
                            <label for="articleDescription">Description</label>
                            <textarea class="form-control" id="articleDescription" name="article-description" rows="3" placeholder="Short description of the article"></textarea>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="add-article" class="btn btn-primary">Add Article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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


    <!-- Bootstrap core JavaScript-->
    <script src="../public/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Page level plugins -->
    <script src="../public/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../public/vendor/jquery/jquery.min.js"></script>


    <!-- Core plugin JavaScript-->
    <script src="../public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../public/assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../public/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../public/assets/js/js/demo/datatables-demo.js"></script>

</body>

</html>