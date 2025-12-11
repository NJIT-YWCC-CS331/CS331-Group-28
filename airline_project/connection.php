<?php
// connection.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$user = 'root';        // default XAMPP user
$pass = '';            // default XAMPP password (empty)
$db   = 'airline_db';  // the database to connect too

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
?>