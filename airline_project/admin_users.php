<?php
include 'auth_admin.php';
include 'connection.php';

$result = $conn->query("SELECT user_id, username, email, is_admin FROM users ORDER BY user_id ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Users</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        .container { max-width: 900px; margin: 0 auto; }
        .nav { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
<div class="container">

    <div class="nav">
        <a href="admin_dashboard.php">⬅ Admin Dashboard</a> |
        <a href="logout.php">Logout</a>
    </div>

    <h2>All Registered Users</h2>

    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['user_id']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= ($row['is_admin'] == 1) ? "Admin" : "User" ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

</div>
</body>
</html>
<?php $conn->close(); ?>
