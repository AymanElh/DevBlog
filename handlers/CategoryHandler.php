<?php

namespace Handlers;

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Category;


class CategoryHandler
{
    private Category $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }


    public function addCategory() : string
    {

        $name = $_POST['category-name'];

        $name = trim($name);
        $name = stripslashes($name);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        if (isset($_POST['add-category']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // check the category
            if (strlen($name) < 3) {
                return "Name is not valid";
            }

            // create category
            $this->category->createCategory($name);
            header("Location: ../views/categories.php");
            // return "Category added";
        }
        return "added";
    }

    public function updateCategory()
    {
        
        if (isset($_POST['update-category']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            
            
            $name = $_POST['name'];
            $category_id = (int)$_POST['category_id'];

            // echo "<pre>";
            // var_dump($category_id, $name);
            // echo "</pre>";
            // die();
    
            $name = trim($name);
            $name = stripslashes($name);
            $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');


            if (strlen($name) < 3) {
                echo "Category name is invalid";
                header("Location: ../views/categories.php");
            }

            $this->category->updateCategory($category_id, $name);
            header("Location: categories.php");
        }
    }

    public function deleteCategory()
    {

        if (isset($_POST['delete-category']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if(!isset($_POST['category_id']) && empty($_POST['category_id'])) {
                echo "error on category id";
                die();
            }
            
            $category_id = (int)$_POST['category_id'];

            if ($category_id <= 0) {
                echo "Error: Invalid category ID.";
                return;
            }

            $result = $this->category->deleteCategory($category_id);
                header("Location: ../views/categories.php");
        }
    }

    public function getAllCategories()
    {
        $result = $this->category->getAllCategories();
        return $result;
    }
}
