<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/error_config.php';


use Classes\BaseModel;

class User
{
    protected static BaseModel $basemodel;
    protected static string $table;

    function __construct(BaseModel $basemodel)
    {
        self::$basemodel = $basemodel;
        self::$table = 'users';
    }

    public function createUser(string $name, string $username, string $email, string $password_hash, string $bio = "", string $pic = "", string $role = "guest"): int
    {
        $data = [
            "full_name" => $name,
            "username" => $username,
            "email" => $email,
            "password_hash" => $password_hash,
            "bio" => $bio,
            "profile_picture_url" => $pic,
            "role" => $role
        ];
        return self::$basemodel->insertRecord(self::$table, $data);
    }

    public function updateProfile(int $id, array $data): bool
    {
        return self::$basemodel->updateRecord(self::$table, $data, $id);
    }

    public function usernameExist($username): bool
    {
        $where = "username = $username";
        $result = self::$basemodel->selectRecords(self::$table, '*', $where);
        return $result ? true : false;
    }

    public function emailExist($email): bool
    {
        $where = "email = $email";
        $result = self::$basemodel->selectRecords(self::$table, '*', $where);
        return $result ? true : false;
    }

    public static function getUser(string $email): array
    {
        $where = "email = '$email'";
        $email = self::$basemodel->selectRecords(self::$table, '*', $where);
        return $email ?: [];
    }

    public static function getCountUsers() : int 
    {
        $result = self::$basemodel->selectRecords(self::$table, 'COUNT(*) AS TotalUsers');
        return $result ? $result[0]['TotalUsers'] : 0;
    }
}
