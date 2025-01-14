<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../config/error_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;
use Classes\BaseModel;
use PDO;


class Category 
{
    private BaseModel $dbHandler;
    private static $nbrOfCategories = 0;
    private $table = 'categories';

    function __construct(BaseModel $dbHandler) {
        // var_dump($dbHandler);
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
        // echo "<pre>";

        // var_dump($result[0]['name']);
        // echo "</pre>";

        if($result) { 
            return $result[0]['name'];
        }
        return "";
    }

    public function getCountCategories() : int 
    {
        $result = $this->dbHandler->selectRecords($this->table, 'COUNT(*) AS TotalCategories');
        return $result ? $result[0]['TotalCategories'] : 0;
    }

    public function getCategoryStats() : array
    {
        $query = "SELECT categories.name , COUNT(articles.id) AS totalArticles FROM categories LEFT JOIN articles ON articles.category_id = categories.id GROUP BY categories.id ORDER BY totalArticles DESC";
        $stmt = (Database::connect())->prepare($query);
        
        if($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];

    }
}