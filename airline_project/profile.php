<?php
include 'auth_user.php';
include 'connection.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT user_id, username, email, is_admin FROM users WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();

if (!$user) {
    die("User not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        .container { max-width: 600px; margin: 0 auto; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 6px; }
        .row { margin-bottom: 10px; }
        .label { font-weight: bold; display: inline-block; width: 120px; }
        a { text-decoration: none; }
        .nav { margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">

    <div class="nav">
        <a href="user_home.php">⬅ Back to Home</a> |
        <a href="logout.php">Logout</a>
    </div>

    <div class="card">
        <h2>My Profile</h2>

        <div class="row">
            <span class="label">User ID:</span>
            <?= htmlspecialchars($user['user_id']) ?>
        </div>

        <div class="row">
            <span class="label">Username:</span>
            <?= htmlspecialchars($user['username']) ?>
        </div>

        <div class="row">
            <span class="label">Email:</span>
            <?= htmlspecialchars($user['email']) ?>
        </div>

        <div class="row">
            <span class="label">Role:</span>
            <?= ($user['is_admin'] == 1) ? "Admin" : "User" ?>
        </div>
    </div>

</div>
</body>
</html>