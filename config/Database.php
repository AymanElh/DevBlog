<?php 

namespace Config;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/error_config.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use PDO;
use PDOException;


class Database
{
    private static $conn = null;

    private function __construct() {}

    private static function getInstance() : Database
    {
        if(self::$conn === null) {
            return new Database;
        }

        return self::$conn;
    }

    public static function connect() 
    {
        if(self::$conn === null) {
            try {
                self::$conn = self::getInstance();
                self::$conn = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "connection failed: " . $e->getMessage();
            }
        }
        return self::$conn;
    }
}