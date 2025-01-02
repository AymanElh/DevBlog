<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/error_config.php';
require_once __DIR__ . '/../classes/DatabaseHandler.php';


class Category 
{
    private DatabaseHandler $dbHandler;
    private static $nbrOfCategories = 0;
    private $table = 'categories';

    function __construct(DatabaseHandler $dbHandler) {
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
}