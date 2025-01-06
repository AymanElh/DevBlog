<?php

namespace Auth;

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\User;
use Exception;

session_start();

class Auth
{
    private User $user;

    function __construct($basemodel)
    {
        $this->user = new User($basemodel);
    }


    public function signup(string $name, string $username, string $email, string $password, string $bio = "", string $pic = ""): string
    {
        if ($this->user->usernameExist($username) || $this->user->emailExist($email)) {
            return "Username or email already exist";
        }

        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        try {
            $this->user->createUser($name, $username, $email, $password_hashed, $bio, $pic);
            return "Account created successfully";
        }
        catch(Exception $e) {
            error_log("Invalid sing up: " . $e->getMessage());
            return "Account not created";
        }
    }

    public function login(string $email, string $password): string
    {
        $user = User::getUser($email);
        if (!$user) {
            return "No user fount with this email";
        }
        if (password_verify($password, $user[0]['password_hash'])) {
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['role'] = $user[0]['role'];

            return "Login added successfully";
        }
        return "Invalid password";
    }

    public function logout() 
    {
        session_unset();
        session_destroy();
    }
}
