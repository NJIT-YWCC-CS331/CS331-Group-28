<?php
include 'auth_admin.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 30px; }
    .card { max-width: 600px; border: 1px solid #ccc; padding: 20px; border-radius: 6px; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Admin)</h1>

    <p><a href="admin_users.php">View Users</a></p>
    <p><a href="admin_reservation.php">View Reservations</a></p>
    <p><a href="logout.php">Logout</a></p>
  </div>
</body>
</html>
