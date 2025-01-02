<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../config/error_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PDO;
use PDOException;

class BaseModel
{
    private $db;

    function __construct($conn)
    {
        // var_dump($conn);
        $this->db = $conn;
    }

    public function insertRecord(string $table, array $data) : bool
    {
        // Use prepared statements to prevent SQL injection
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table($columns) VALUES($placeholders)";

        try {
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                return false;
            }

            return $stmt->execute(array_values($data));
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateRecord(string $table, array $data, int $id) : bool
    {

        // Use prepared statements to prevent SQL injection
        $args = [];
        foreach ($data as $key => $value) {
            $args[] = "$key = ?";
        }

        $sql = "UPDATE $table SET " . implode(',', $args) . " WHERE id = ?";

        try {
            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                error_log("error preparing statment: " . implode(', ', $this->db->errorInfo()));
                return false;
            }

            return $stmt->execute(array_merge(array_values($data), [$id]));
        } 
        catch (PDOException $e) {
            error_log("Error updating record: " . $e->getMessage());
            return false;
        }
    }

    public function deleteRecord(string $table, int $id) : bool
    {
        $sql = "DELETE FROM $table WHERE id = ?";

        try {
            $stmt = $this->db->prepare($sql);

            if(!$stmt) {
                error_log("error preparing statment: " . implode(', ', $this->db->errorInfo()));
                return false;
            }

            return $stmt->execute([$id]);
        }
        catch(PDOException $e) {
            error_log("Error deleting record: " . $e->getMessage());
            return false;
        }
    }

    public function selectRecords(string $table, string $columns = '*', string $where = null) : array|bool
    {
        $sql = "SELECT $columns FROM $table";

        if($where !== NULL) {
            $sql .= " WHERE $where";
        }

        try {
            $stmt = $this->db->prepare($sql);

            if(!$stmt) {
                error_log("Error preparing statment: " . implode(', ', $this->db->errorInfo()));
                return false;
            }

            if($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }

            return $result;
        }
        catch (PDOException $e) {
            error_log("Error selecting records: " . $e->getMessage());
            return false;
        }
    }
}
