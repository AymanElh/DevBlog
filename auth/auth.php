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

    private function validateSignupInput(string $name, string $username, string $email, string $password): string
    {
        if (empty($name) || empty($username) || empty($email) || empty($password)) {
            return "All fields are required.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email.";
        }
        if (strlen($password) < 6) {
            return "Password must be at least 6 characters long.";
        }
        return ""; 
    }


    public function signup(string $name, string $username, string $email, string $password, string $bio = "", string $pic = ""): string
    {

        $errors = $this->validateSignupInput($name, $username, $email, $password);

        if($errors) {
            return $errors;
        }

        if ($this->user->emailExist($email)) {
            return "Username or email already exist";
        }

        $password_hashed = password_hash($password, PASSWORD_ARGON2I);

        try {
            $result = $this->user->createUser($name, $username, $email, $password_hashed, $bio, $pic);
            return "Account created successfully";
        }
        catch(Exception $e) {
            error_log("Invalid sing up: " . $e->getMessage());
            return "Account createtion failed";
        }
    }

    private function validateLoginInput(string $email, string $password): string
    {
        if (empty($email) || empty($password)) {
            return "Email and password are required.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email.";
        }
        return "";
    }

    public function login(string $email, string $password): string
    {
        $errors = $this->validateLoginInput($email, $password);

        if($errors) {
            return $errors;
        }

        $user = User::getUser($email);
        if (!$user) {
            return "";
        }
        
        if (password_verify($password, $user[0]['password_hash'])) {
            $_SESSION['user'] = $user[0];

            return "Login added successfully";
        }
        return "";
    }

    public static function logout() 
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public static function checkAccess(array $roles = []) 
    {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if(empty($_SESSION['user'])) {
            header("Location: ../public/index.php");
            exit;
        }

        if(!empty($roles) && !in_array($_SESSION['user']['role'], $roles)) {
            header("Location: ../views/404.php");
            exit;
        }
    }
}
