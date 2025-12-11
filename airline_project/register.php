<?php
// register.php
include 'connection.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm_password'] ?? '');

    // Basic validation
    if ($username === '') {
        $errors[] = 'Username is required.';
    }
    if ($email === '') {
        $errors[] = 'Email is required.';
    }
    if ($password === '') {
        $errors[] = 'Password is required.';
    }
    if ($password !== '' && $password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
       
        
        $stmt = $conn->prepare("
            INSERT INTO users (username, email, password, is_admin)
            VALUES (?, ?, ?, 0)
        ");
        if (!$stmt) {
            $errors[] = 'Prepare failed: ' . $conn->error;
        } else {
            $stmt->bind_param('sss', $username, $email, $password);

            if ($stmt->execute()) {
                $success = 'Registration successful. You can now log in.';
                // Clear form fields
                $username = $email = '';
            } else {
                // Handle duplicate username or email
                if ($conn->errno === 1062) {
                    if (str_contains($conn->error, 'username')) {
                        $errors[] = 'That username is already taken.';
                    } elseif (str_contains($conn->error, 'email')) {
                        $errors[] = 'That email is already registered.';
                    } else {
                        $errors[] = 'Username or email already exists.';
                    }
                } else {
                    $errors[] = 'Database error: ' . $conn->error;
                }
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
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
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .btn {
            background: #007bff;
            border: none;
            color: white;
            padding: 8px 14px;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn:hover {
            background: #0066d1;
        }
        .messages {
            margin-bottom: 12px;
        }
        .error {
            color: #b30000;
            margin-bottom: 4px;
        }
        .success {
            color: #008000;
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
        <h2>User Registration</h2>

        <div class="messages">
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $e): ?>
                    <div class="error"><?= htmlspecialchars($e) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($success !== ''): ?>
                <div class="success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
        </div>

        <form method="post" action="register.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    value="<?= isset($username) ? htmlspecialchars($username) : '' ?>"
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"
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

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    required
                >
            </div>

            <button type="submit" class="btn">Register</button>
        </form>

        <div class="small-link">
            Already have an account?
            <a href="login.php">Log in</a>
            (we will build this next).
        </div>
    </div>
</div>
</body>
</html>
