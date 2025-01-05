<?php

declare(strict_types=1);

namespace Auth;

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;
use Classes\User;

class Signup
{
    private BaseModel $basemodel;
    private User $newUser;

    function __construct(BaseModel $basemodel) 
    {
        $this->basemodel = $basemodel;
        $this->newUser = new User($basemodel);
    }

    public function signup(string $name, string $username, string $email, string $password, string $bio = "", string $pic = "") : bool
    {
        if($this->newUser->usernameExist($username) || $this->newUser->emailExist($email)) {
            return false;
        }

        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        return$this->newUser->createUser($name, $username, $email, $password_hashed, $bio, $pic, 'guest');
    }

}