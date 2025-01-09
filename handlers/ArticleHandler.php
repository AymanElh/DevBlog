<?php

namespace Handlers;

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Article;
use Classes\BaseModel;
use Classes\Tag;

session_start();

use Exception;


class ArticleHandler
{
    private Article $article;

    function __construct(Article $article)
    {
        $this->article = $article;
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
            $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

            // $status = $_POST['article-status'];
            $scheduledDate = $_POST['schedule-date'];
            // $articleDescription = $_POST['article-description'];
            $author = $_SESSION['user']['id'];

            // if (strlen($title) < 3 || strlen($content) < 100) {
            //     echo $title . '<br>'; 
            //     echo $content;
            //     echo "title and content size don't match";
            //     return false;
            // }


            $filePath = null;
            if (isset($_FILES['article-img']) && $_FILES['article-img']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['article-img'];

                $uploadDir = __DIR__ . '/../public/assets/img/';
                $filePath = $uploadDir . basename($file['name']);
                if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                    return 'Error uploading the file.';
                }
            }
        
            $categoryId = $this->article->getCategoryId($category);
            if (!$category) {
                return "Invalid Category";
            }


            

            try {
                $this->article->createArticle($title, $content, $filePath, $categoryId, $scheduledDate, $author, $tags);
                header("Location: ../views/articles.php");
            } catch (Exception $e) {
                error_log("error inserting the article: " . $e->getMessage());
                return false;
            }
        }
    }

    public function updateArticle($articleId): bool
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

    public function deleteArticle(int $articleId): string
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

    public function getAllArticles(): array
    {
        return $this->article->getAllArticles();
    }

    public function getArticleTags(int $article_id): array
    {
        $result =  $this->article->getArticleTags($article_id);
        // echo "<pre>";
        // var_dump($result[0]['tag_id']);
        // echo "</pre>";
        foreach ($result as $tag) {
            $tags[] = Tag::getTagName((int)$tag['tag_id']);
        }
        // var_dump($tags);

        return $tags;
    }
}
