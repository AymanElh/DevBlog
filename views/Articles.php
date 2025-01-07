<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;
use Classes\Category;
use Classes\Tag;
use Classes\Article;
use Config\Database;
use Handlers\CategoryHandler;
use Handlers\TagHandler;
use Handlers\ArticleHandler;

$baseModel = new BaseModel(Database::connect());

$categoryHandler = new CategoryHandler(new Category($baseModel));
$categories = $categoryHandler->getAllCategories();

$tagHandler = new TagHandler(new Tag($baseModel));
$tags = Tag::getAllTags();

$articleHandler = new ArticleHandler(new Article($baseModel));
$articles = $articleHandler->getAllArticles();

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
                                        // var_dump($tags);
                                    ?>
                                        <td><?= $count++ ?></td>
                                        <td><?= htmlspecialchars($article['title']) ?></td>
                                        <td><?= htmlspecialchars($article['category_id']) ?></td>
                                        <td><?= implode(' ', $tags) ?></td>
                                        <td><?= htmlspecialchars($article['author_id']) ?></td>
                                        <td><?= htmlspecialchars($article['scheduled_date']) ?></td>
                                        <td><?= htmlspecialchars($article['status']) ?></td>
                                        <td><?= htmlspecialchars($article['views']) ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editArticleModal<?= $article['id']; ?>">Edit</button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteArticleModal<?= $article['id']; ?>">Delete</button>
                                        </td>
                                    <?php endforeach; ?>



                                </tbody>
                            </table>
                        </div>
                    </div>

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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addArticleModalLabel">Add New Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="../handlers/ArticleHandler.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="article-title">Title</label>
                            <input type="text" class="form-control" id="article-title" name="title" required>
                        </div>
                        <div class="form-group ">
                            <label for="article-content">Content</label>
                            <textarea class="form-control" id="article-content" name="content" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="article-image" class="form-label">Upload Article Image</label>
                            <div class="custom-file-upload">
                                <input type="file" id="article-image" class="form-control d-none" name="article-image" accept="image/*" required>
                                <label for="article-image" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-upload"></i> Choose Image
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category-id">Category</label>
                            <select class="form-control" id="category-id" name="category_id" required>
                                <option value="" disabled selected>Select Category</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['name'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tags-select">Tags</label>
                            <select class="form-select" multiple aria-label="multiple select example">
                                <option selected>Open this select menu</option>
                                <?php foreach ($tags as $tag) : ?>
                                    <option value="<?= $tag['name'] ?>"><?= $tag['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="publish-date" class="form-label">Publish Date</label>
                            <input type="date" id="publish-date" class="form-control" name="publish_date" required>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="add-article">Add Article</button>
                    </div>
                </form>
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