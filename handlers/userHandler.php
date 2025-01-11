<?php

namespace Handlers;

require_once __DIR__ . '/../vendor/autoload.php';

use Config\Database;
use Classes\BaseModel;
use Classes\User;
use Auth\Auth;


class UserHandler
{
    private BaseModel $basemodel;
    private User $user;

    public function __construct()
    {
        $this->basemodel = new BaseModel(Database::connect());
        $this->user = new User($this->basemodel);
    }

    public function changeUserRole(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user-role'])) {
            $userId = (int)$_POST['user_id'];
            $newRole = $_POST['user-role'];
            var_dump($newRole);
            $this->basemodel->updateRecord('users', ['role' => $newRole], $userId);
        }
        header("Location: ../views/users.php");
    }

    public function updateUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-user'], $_POST['user_id'])) {
            $userId = (int)$_POST['user_id'];
            $data = [
                'full_name' => $_POST['full_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'bio' => $_POST['bio'] ?? '',
            ];

            $isUpdated = $this->user->updateProfile($userId, $data);
            if ($isUpdated) {
                echo "User updated successfully!";
            } else {
                echo "Failed to update user.";
            }
            header("Location: ../views/users.php");
        }
    }

    public function deleteUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-user'])) {
            $userId = (int)$_POST['user_id'];
            // var_dump($userId);
            // die();
            $result = $this->basemodel->deleteRecord('users', $userId, 'id');
            if ($result) {
                echo "User deleted successfully!";
            } else {
                echo "Failed to delete user.";
            }
        }
        header("Location: ../views/users.php");
    }

    public static function logout(): void
    {
        if (isset($_GET['action']) && $_GET['action'] === 'logout') {
            Auth::logout();
            header("Location: ../public/index.php");
            exit();
        }
    }
}
