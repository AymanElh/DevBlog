<?php

declare(strict_types=1);

namespace Auth;

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;
use Classes\User;


class Logout
{
    public function logout() 
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: ../public/index.php");
    }
}