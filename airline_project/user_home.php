<?php
include 'auth_user.php'; // session_start + requires login
$username = htmlspecialchars($_SESSION['username'] ?? 'User');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>User Home</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="page">
    <div class="card">
      <h1>Welcome, <?= $username ?> (User)</h1>

      <div class="nav">
        <a href="profile.php">My Profile</a>
        <a href="search_flights.php">Search Flights</a>
        <a href="my_tickets.php">My Tickets</a>
        <a href="logout.php">Logout</a>
      </div>

      <p class="muted">
        Tip: Search flights → Book → View in My Tickets.
      </p>
    </div>
  </div>
</body>
</html>
