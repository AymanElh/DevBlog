<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/error_config.php';

use Classes\User;
use Classes\Category;
use Classes\Tag;

class Admin extends User
{
    private Category $categManagment;
    private Tag $tagManagment;

    function __construct(string $name, string $username, string $email, string $password_hash, Category $category, Tag $tag, string $bio = "", string $pic = "", string $role = "user")
    {
        parent::__construct($name, $username, $email, $password_hash, $bio, $pic, $role = "admin");
        $this->categManagment = $category;
        $this->tagManagment = $tag;
    }

    // Category managment
    public function createCategory(string $name)
    {
        $this->categManagment->createCategory($name);
    }
    public function deleteCategory(int $id)
    {
        $this->categManagment->deleteCategory($id);
    }
    public function updateCategory(int $id, string $name)
    {
        $this->categManagment->updateCategory($id, $name);
    }
    public function getAllCategories(): array
    {
        return $this->categManagment->getAllCategories();
    }


    // manage tags 
    public function createTag(string $name)
    {
        $this->tagManagment->createTag($name);
    }
    public function updateTag(int $id, string $name)
    {
        $this->tagManagment->updateTag($id, $name);
    }
    public function deleteTag(int $id)
    {
        $this->tagManagment->deleteTag($id);
    }


    // manage users
}
