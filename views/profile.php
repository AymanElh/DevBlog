<?php 
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\BaseModel;
use Classes\User;
use Config\Database;

if (!empty($_SESSION['user'])) {
    $userEmail = $_SESSION['user']['email'];
}

$user = (new User(new BaseModel(Database::connect())))->getUser($userEmail);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .profile-header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .profile-header p {
            margin: 5px 0 0;
            color: #777;
        }

        .profile-details {
            margin-bottom: 30px;
        }

        .profile-details h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
        }

        .profile-details p {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .profile-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .profile-actions .btn {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <img src="https://via.placeholder.com/150" alt="Profile Picture">
            <h2><?= htmlspecialchars($user[0]['full_name']) ?></h2>
            <p><?= htmlspecialchars($user[0]['email']) ?></p>
        </div>

        <!-- Profile Details -->
        <div class="profile-details">
            <h3>About</h3>
            <p><?= htmlspecialchars($user[0]['bio']) ?></p>

            <h3>Role</h3>
            <p><?= htmlspecialchars($user[0]['role']) ?></p>

            <h3>Phone</h3>
            <p>+123-456-7890</p>
        </div>

        <!-- Profile Actions -->
        <div class="profile-actions">
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user[0]['full_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user[0]['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="+123-456-7890" required>
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3"><?= htmlspecialchars($user[0]['bio']) ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update-profile" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        Are you sure you want to delete this profile? This action cannot be undone.
                        <input type="hidden" name="user_id" value="123"> <!-- Replace with dynamic ID -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="delete-profile" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>