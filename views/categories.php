<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Handlers\CategoryHandler;
use Classes\BaseModel;
use Config\Database;
use Classes\Category;

$baseModel = new BaseModel(Database::connect());
$category = new Category($baseModel);

$categoryHandler = new CategoryHandler($category);
$categories = $categoryHandler->getAllCategories();
$categoryHandler->addCategory();
$categoryHandler->updateCategory();
$categoryHandler->deleteCategory();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template-->
    <link href="../public/assets/css/sb-admin-2.min.css" rel="stylesheet">
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
                        <h1 class="h3 mb-0 text-gray-800">Categories</h1>
                    </div>

                    <!-- Category Add Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add New Category</h6>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="category-name">Category Name</label>
                                    <input type="text" class="form-control" id="category-name" name="category-name" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="add-category">Add Category</button>
                            </form>
                        </div>
                    </div>


                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Categories List</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categories as $category) : ?>
                                                <tr>
                                                    <td><?= $category['id'] ?></td>
                                                    <td><?= $category['name'] ?></td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCategoryModal<?= $category['id']; ?>">
                                                            Edit
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteCategoryModal<?= $category['id']; ?>">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editCategoryModal<?= $category['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel<?= $category['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="" method="POST">
                                                                <input type="hidden" name="category_id" value="<?= $category['id']; ?>">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Category</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" value="<?= $category['id']; ?>">
                                                                    <div class="form-group">
                                                                        <label for="name">Category Name</label>
                                                                        <input type="text" class="form-control" id="name" name="name" value="<?= $category['name']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="update-category" class="btn btn-primary">Save Changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteCategoryModal<?= $category['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel<?= $category['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="" method="POST">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete Category</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete the category "<?= $category['name']; ?>"?
                                                                    <input type="hidden" name="category_id" value="<?= $category['id']; ?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="delete-category" class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include 'components/footer.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>

    <!-- Page level plugins -->
    <script src="../public/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../public/vendor/datatables/dataTables.bootstrap4.min.js"></script>


    <!-- Bootstrap core JavaScript-->
    <script src="../public/vendor/jquery/jquery.min.js"></script>
    <script src="../public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../public/assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../public/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../public/assets/js/js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>


</body>

</html>