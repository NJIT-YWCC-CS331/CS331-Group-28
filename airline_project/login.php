<?php
// login.php
include 'connection.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $errors[] = 'Please enter both username and password.';
    } else {
        // Check user in database
        $stmt = $conn->prepare("
            SELECT user_id, username, password, is_admin
            FROM users
            WHERE username = ?
            LIMIT 1
        ");
        $stmt->bind_param('s', $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $errors[] = 'User not found.';
        } else {
            // Compare plain passwords (ok for school project)
            if ($password !== $user['password']) {
                $errors[] = 'Incorrect password.';
            } else {
                // Login successful
                session_start();
                $_SESSION['user_id']   = $user['user_id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['is_admin']  = $user['is_admin'];

                if ($user['is_admin'] == 1) {
                    header('Location: admin_dashboard.php');
                    exit;
                } else {
                    header('Location: user_home.php');
                    exit;
                }
            }
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
        }
        .card {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 6px;
        }
        .card h2 {
            margin-top: 0;
        }
        .form-group {
            margin-bottom: 12px;
        }
        label {
            display: block;
            margin-bottom: 4px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .btn {
            background: #28a745;
            border: none;
            color: white;
            padding: 8px 14px;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn:hover {
            background: #218838;
        }
        .error {
            color: #b30000;
            margin-bottom: 4px;
        }
        .small-link {
            margin-top: 10px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h2>Login</h2>

        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $e): ?>
                <div class="error"><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form method="post" action="login.php">

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="small-link">
            Don't have an account?
            <a href="register.php">Register</a>
        </div>
    </div>
</div>
</body>
</html>
