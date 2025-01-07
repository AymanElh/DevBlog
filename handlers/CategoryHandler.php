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


    public function addCategory() : bool
    {

        $name = $_POST['category-name'];

        $name = trim($name);
        $name = stripslashes($name);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        if(isset($_POST['add-category']) && $_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // check the category
            if(strlen($name) < 3) {
                return false;
            }

            // create category
            $this->category->createCategory($name);
            return true;
        }
    }

    public function updateCategory() : bool
    {
        $name = $_POST['category-name'];

        $name = trim($name);
        $name = stripslashes($name);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        if(isset($_POST['update-category']) && $_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $category_id = $_POST['category_id'];
            if(strlen($name) < 3) {
                return false;
            }

            $this->category->updateCategory($category_id, $name);
        }
    }

    public function deleteCategory()
    {

        if(isset($_POST['delete-category']) && $_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $category_id = $_POST['category_id'];

            $this->category->deleteCategory($category_id);
        }
    }

    public function getAllCategories() 
    {
        $result = $this->category->getAllCategories();
        return $result;
    }
}