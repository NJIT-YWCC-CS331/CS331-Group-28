<?php
// connection.php
// Include this file at the top of any page that needs DB access.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$user = 'root';        // default XAMPP user
$pass = '';            // default XAMPP password (empty)
$db   = 'airline_db';  // the database you just created

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
?>