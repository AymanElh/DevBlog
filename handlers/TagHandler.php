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


    public function addTag($name) : bool
    {
        $name = trim($name);
        $name = stripslashes($name);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        if(isset($_POST['add-tag']) && $_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // check the category
            if(strlen($name) < 3) {
                return false;
            }

            // create category
            $this->tag->createTag($name);
            return true;
        }
    }

    public function updateTag($name) : bool
    {
        $name = trim($name);
        $name = stripslashes($name);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

        if(isset($_POST['update-tag']) && $_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $tag_id = $_POST['tag_id'];
            if(strlen($name) < 3) {
                return false;
            }

            $this->tag->updateTag($tag_id, $name);
        }
    }

    public function deleteTag($id)
    {
        if(isset($_POST['delete-category']) && $_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $tag_id = $_POST['tag_id'];

            $this->tag->deleteTag($tag_id);
        }
    }
}