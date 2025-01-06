<?php

namespace Handlers;

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Article;
use Classes\BaseModel;

session_start();

use Exception;


class ArticleHandler
{
    private BaseModel $basemodel;
    private Article $article;

    function __construct(BaseModel $basemodel)
    {
        $this->basemodel = $basemodel;
        $this->article = new Article($basemodel);
    }

    private function sanitizeInput($input): string
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $input;
    }

    public function addArticle()
    {
        if (isset($_POST['add-article']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $this->sanitizeInput($_POST['article-title']);
            $content = $this->sanitizeInput($_POST['article-content']);
            $category = $_POST['article-category'];
            $status = $_POST['article-status'];
            $scheduledDate = $_POST['schedule-date'];
            $author = $_SESSION['user_id'];
            $tags = $_POST['tags'];

            if (strlen($title) < 3 || strlen($content) < 100) {
                echo "title and content size don't match";
                return false;
            }


            $filePath = null;
            if (isset($_FILES['article-img']) && $_FILES['article-img']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['article-img'];

                $uploadDir = __DIR__ . '/../public/assets/img';
                $filePath = $uploadDir . basename($file['name']);
                if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                    return 'Error uploading the file.';
                }
            }

            $categoryId = $this->article->getCategoryId($category);
            if (!$category) {
                return "Invalid Category";
            }

            $slug = Article::getSlug($title);

            $data = [
                'title' => $title,
                'content' => $content,
                'image_path' => $filePath,
                'category_id' => $categoryId,
                'status' => $status,
                'scheduled_date' => $scheduledDate,
                'author_id' => $author,
                'slug' => $slug,
            ];

            try {
                $this->article->createArticle($data, $tags);
                return true;
            } catch (Exception $e) {
                error_log("error inserting the article: " . $e->getMessage());
                return false;
            }
        }
    }

    public function updateArticle($articleId) : bool
    {
        if (isset($_POST['update-article']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $this->sanitizeInput($_POST['article-title']);
            $content = $this->sanitizeInput($_POST['article-content']);
            $category = $_POST['category'];
            $status = $_POST['status'];
            $scheduledDate = $_POST['schedule-date'];
            $tags = $_POST['tags']; 

    
            if (strlen($title) < 3 || strlen($content) < 10) {
                return 'Title and Content must be at least 3 and 10 characters long, respectively.';
            }

            $filePath = null;
            if (isset($_FILES['article-img']) && $_FILES['article-img']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['article-img'];

                $uploadDir = __DIR__ . '/../public/assets/img';
                $filePath = $uploadDir . basename($file['name']);
                if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                    return 'Error uploading the file.';
                }
            }

            // Prepare data for article update
            $categoryId = $this->article->getCategoryId($category);
            if (!$categoryId) {
                return 'Invalid category.';
            }

            $slug = Article::getSlug($title);
            $data = [
                'title' => $title,
                'content' => $content,
                'image_path' => $filePath,
                'category_id' => $categoryId,
                'status' => $status,
                'scheduled_date' => $scheduledDate,
                'slug' => $slug,
            ];

            try {
                $this->article->updateArticle($articleId, $data, $tags);
                return true;
            } catch (Exception $e) {
                error_log('Error: ' . $e->getMessage());
                return false;
            }
        }
    }

    public function deleteArticle(int $articleId) : string
    {
        if (isset($_POST['delete-article']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->article->deleteArticle($articleId);
                return "Article deleted";
            } catch (Exception $e) {
                error_log('Error: ' . $e->getMessage());
                return "article deletion failed";
            }
        }
    }
}
