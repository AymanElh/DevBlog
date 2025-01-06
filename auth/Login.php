<?php

declare(strict_types=1);

namespace Auth;

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;
use Classes\User;

class Login
{

    public function login(string $email, string $password): bool
    {
        $user = User::getUser($email);
        if (password_verify($password, $user[0]['password_hash'])) {
            session_start();
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['role'] = $user[0]['role'];

            return true;
        }
        return false;
    }
}
