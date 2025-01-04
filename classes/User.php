<?php

declare(strict_types=1);

namespace Classes;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/error_config.php';

use Exception;

class User 
{
    protected string $name;
    protected string $username;
    protected string $email;
    protected string $password_hash;
    protected string $bio;
    protected string $pic;
    protected string $role;


    function __construct(string $name, string $username, string $email, string $password_hash, string $bio = "", string $pic = "", string $role = "user")
    {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->bio = $bio;
        $this->pic = $pic;
        $this->role = $role;
    }


    // setters
    public function setName(string $name) 
    {
        $this->name = $name;
    }
    public function setUsername(string $username) 
    {
        $this->username = $username;
    }
    public function setEmail(string $email) 
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email");
        }
        $this->email = $email;
    }
    public function setPassword(string $password) 
    {
        $this->password_hash = password_hash($password, PASSWORD_BCRYPT);
    }
    public function setBio(string $bio) 
    {
        $this->bio = $bio;
    }
    public function setPic(string $pic) 
    {
        $this->pic = $pic;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }

    // getters
    public function getName() : string
    {
        return $this->name;
    }
    public function getUsername() : string
    {
        return $this->username;
    }
    public function getEmail() : string
    {
        return $this->email;
    }
    public function getPasswordHash() : string
    {
        return $this->password_hash;
    }
    public function getBio() : string 
    {
        return $this->bio;
    }
    public function getPic() : string
    {
        return $this->pic;
    }
    public function getRole() : string
    {
        return $this->role;
    }

    public function verifyPassword(string $password) : bool
    {
        return password_verify($password, $this->password_hash);
    }


}
