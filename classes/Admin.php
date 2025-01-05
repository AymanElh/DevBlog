<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/error_config.php';

use Classes\User;

class Admin extends User
{



    // manage users
    public function updateUser(int $id, array $data) : bool
    {
        return self::$basemodel->updateRecord(self::$table, $data, $id);
    }

    public function deleteUser(int $id) : bool
    {
        return self::$basemodel->deleteRecord(self::$table, $id);
    }

}
