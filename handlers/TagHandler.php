<?php

namespace Handlers;

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Tag;


class TagHandler
{
    private Tag $tag;

    function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    private function sanitizeInput($input): string
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $input;
    }

    public function addTag(): bool
    {

        if (isset($_POST['add-tag']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $this->sanitizeInput($_POST['tag-name']);

            // check the category
            if (strlen($name) < 3) {
                return false;
            }

            // create category
            $this->tag->createTag($name);
            header("Location: ../views/tags.php");
        }
        return true;
    }

    public function updateTag(): bool
    {

        if (isset($_POST['update-tag']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->sanitizeInput($_POST['name']);

            $tag_id = $_POST['tag_id'];
            if (strlen($name) < 3) {
                return false;
            }

            $this->tag->updateTag($tag_id, $name);
            header("Location: ../views/tags.php");
        }


        return true;
    }

    public function deleteTag()
    {
        if (isset($_POST['delete-tag']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $tag_id = (int)$_POST['tag_id'];

            $this->tag->deleteTag($tag_id);
            header("Location: ../views/tags.php");
        }
    }

    public function getAllTags()
    {
        $result = $this->tag->getAllTags();
        return $result;
    }
}
