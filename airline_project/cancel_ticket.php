<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'auth_user.php';
include 'connection.php';

$user_id = (int)($_SESSION['user_id'] ?? 0);
$ticket_number = (int)($_GET['ticket_number'] ?? 0);

if ($user_id <= 0 || $ticket_number <= 0) {
    header("Location: my_tickets.php");
    exit;
}

// Make sure the ticket belongs to this logged-in user
$check = $conn->prepare("SELECT status FROM ticket WHERE ticket_number = ? AND user_id = ? LIMIT 1");
$check->bind_param("ii", $ticket_number, $user_id);
$check->execute();
$row = $check->get_result()->fetch_assoc();
$check->close();

if (!$row) {
    $conn->close();
    die("Ticket not found or you don't have permission.");
}

if ($row['status'] !== 'Cancelled') {
    // Update ticket status to Cancelled
    $upd = $conn->prepare("UPDATE ticket SET status = 'Cancelled' WHERE ticket_number = ? AND user_id = ?");
    $upd->bind_param("ii", $ticket_number, $user_id);
    $upd->execute();
    $upd->close();

    // Optional log
    try {
        $res = $conn->query("SELECT COALESCE(MAX(change_id), 400) + 1 AS next_id FROM update_record");
        $next_id = (int)$res->fetch_assoc()['next_id'];

        $now = date("Y-m-d H:i:s");
        $remarks = "Cancelled by user (web app)";

        $ins = $conn->prepare("
            INSERT INTO update_record (change_id, ticket_number, change_date, new_status, remarks)
            VALUES (?, ?, ?, 'Cancelled', ?)
        ");
        $ins->bind_param("iiss", $next_id, $ticket_number, $now, $remarks);
        $ins->execute();
        $ins->close();
    } catch (Throwable $e) {
        // ignore
    }
}

$conn->close();
header("Location: my_tickets.php");
exit;
