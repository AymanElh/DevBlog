<?php

namespace Classes;

require_once __DIR__ . '/../config/error_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PDO;
use PDOException;
use Classes\BaseModel;


class Tag
{
    private static BaseModel $dbHandler;
    private static $table;
    private static $nbrOfTags = 0;

    function __construct(BaseModel $dbHandler)
    {
        self::$dbHandler = $dbHandler;
        self::$table = 'tags';
    }

    public static function createTag(string $name) : void
    {
        self::$dbHandler->insertRecord(self::$table, ['name' => $name]);
        self::$nbrOfTags++;
    }

    public static function deleteTag(int $id) : void
    {
        self::$dbHandler->deleteRecord(self::$table, $id);
        self::$nbrOfTags--;
    }

    public static function updateTag(int $id, string $name) : void
    {
        self::$dbHandler->updateRecord(self::$table, ['name' => $name], $id);
    }

    public static function getAllTags() : array
    {
        $result = self::$dbHandler->selectRecords(self::$table);
    
        return $result ?: [];
    }

    public static function getTagName(int $tag_id) : ?string
    {
        $where = "id = ?";
        $result = self::$dbHandler->selectRecords(self::$table, 'name', $where, [$tag_id]);
        return $result[0]['name'];
    }

    public static function getCountTags() : int 
    {
        $result = self::$dbHandler->selectRecords(self::$table, 'COUNT(*) AS TotalTags');
        return $result ? $result[0]['TotalTags'] : 0;
    }
}
