<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../config/error_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;


class Category 
{
    private BaseModel $dbHandler;
    private static $nbrOfCategories = 0;
    private $table = 'categories';

    function __construct(BaseModel $dbHandler) {
        var_dump($dbHandler);
        $this->dbHandler = $dbHandler;
    }

    public function createCategory(string $name) : void
    {
        $this->dbHandler->insertRecord($this->table, ['name' => $name]);
        self::$nbrOfCategories++;
    }

    public function deleteCategory(int $id) : void
    {
        $this->dbHandler->deleteRecord($this->table, $id);
        self::$nbrOfCategories--;
    }

    public function updateCategory(int $id, string $name) : void 
    {
        $this->dbHandler->updateRecord($this->table, ['name' => $name], $id);
    }

    public function getAllCategories() : array
    {
        $result = $this->dbHandler->selectRecords($this->table);
        if(!$result) {
            return [];
        }
        return $result;
    }

    public static function getTotalNumberOfCategories() : int
    {
        return self::$nbrOfCategories;
    }

    public function getCategoryName(int $category_id) : string
    {
        $where = "id = $category_id";
        $result = $this->dbHandler->selectRecords($this->table, 'name', $where);
        if($result) { 
            return $result[0]['name'];
        }
        return "";
    }
}