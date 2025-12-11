<?php
include 'auth_admin.php';
include 'connection.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$sql = "
SELECT
    t.ticket_number,
    t.user_id,
    u.username,
    u.email,
    t.flight_number,
    a.name AS airline_name,
    f.departure_airport_code,
    f.arrival_airport_code,
    f.departure_time,
    f.arrival_time,
    t.seat_number,
    t.travel_class,
    t.status,
    t.booking_date
FROM ticket t
LEFT JOIN users u ON u.user_id = t.user_id
JOIN flight f ON f.flight_number = t.flight_number
JOIN airline_company a ON a.airline_id = f.airline_id
ORDER BY t.booking_date DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Reservations</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .nav { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; vertical-align: top; }
        th { background: #f5f5f5; }
        .small { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
<div class="container">

    <div class="nav">
        <a href="admin_dashboard.php">⬅ Admin Dashboard</a> |
        <a href="logout.php">Logout</a>
    </div>

    <h2>All Reservations / Tickets</h2>
    <div class="small">Includes all bookings (Booked/Checked-in/Cancelled).</div>

    <table>
        <tr>
            <th>Ticket #</th>
            <th>User</th>
            <th>Flight</th>
            <th>Route</th>
            <th>Airline</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Seat/Class</th>
            <th>Status</th>
            <th>Booked At</th>
        </tr>

        <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="10">No reservations found.</td></tr>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['ticket_number']) ?></td>
                    <td>
                        <?= htmlspecialchars($row['username'] ?? 'N/A') ?><br>
                        <span class="small"><?= htmlspecialchars($row['email'] ?? '') ?></span>
                    </td>
                    <td><?= htmlspecialchars($row['flight_number']) ?></td>
                    <td><?= htmlspecialchars($row['departure_airport_code']) ?> → <?= htmlspecialchars($row['arrival_airport_code']) ?></td>
                    <td><?= htmlspecialchars($row['airline_name']) ?></td>
                    <td><?= htmlspecialchars($row['departure_time']) ?></td>
                    <td><?= htmlspecialchars($row['arrival_time']) ?></td>
                    <td><?= htmlspecialchars($row['seat_number']) ?> / <?= htmlspecialchars($row['travel_class']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['booking_date']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>

</div>
</body>
</html>
<?php $conn->close(); ?>
