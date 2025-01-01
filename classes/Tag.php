<?php

// namespace Class;

require_once __DIR__ . '/../config/error_config.php';
require_once __DIR__ . '/../classes/DatabaseHandler.php';


class Tag
{
    private DatabaseHandler $dbHandler;
    private $table = 'tags';
    private static $nbrOfTags = 0;

    function __construct(DatabaseHandler $dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }

    public function createTag(string $name) : void
    {
        $this->dbHandler->insertRecord($this->table, ['name' => $name]);
        self::$nbrOfTags++;
    }

    public function deleteTag(int $id) : void
    {
        $this->dbHandler->deleteRecord($this->table, $id);
        self::$nbrOfTags--;
    }

    public function updateTag(int $id, string $name) : void
    {
        $this->dbHandler->updateRecord($this->table, ['name' => $name], $id);
    }

    public function getAllTags() : array
    {
        $result = $this->dbHandler->selectRecords($this->table);
    
        return $result ?: [];
    }
}
