<?php
include 'auth_user.php';
include 'connection.php';

$user_id = (int)$_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT 
        t.ticket_number,
        t.flight_number,
        t.booking_date,
        t.seat_number,
        t.travel_class,
        t.status,
        a.name AS airline_name,
        f.departure_airport_code,
        f.arrival_airport_code,
        f.departure_time,
        f.arrival_time
    FROM ticket t
    JOIN flight f ON f.flight_number = t.flight_number
    JOIN airline_company a ON a.airline_id = f.airline_id
    WHERE t.user_id = ?
    ORDER BY t.booking_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Tickets</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .nav { margin-bottom: 15px; }
        .card { border: 1px solid #ccc; padding: 16px; border-radius: 6px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; vertical-align: top; }
        th { background: #f5f5f5; }
        .small { color: #666; font-size: 0.9em; }
        .btn { padding: 6px 10px; border-radius: 4px; text-decoration: none; border: 1px solid #ccc; }
        .btn-danger { color: #b30000; }
        .btn-danger:hover { background: #ffe5e5; }
    </style>
</head>
<body>
<div class="container">

    <div class="nav">
        <a href="user_home.php">⬅ Home</a> |
        <a href="search_flights.php">Search Flights</a> |
        <a href="profile.php">My Profile</a> |
        <a href="logout.php">Logout</a>
    </div>

    <div class="card">
        <h2>My Tickets</h2>
        <div class="small">Showing bookings for: <b><?= htmlspecialchars($_SESSION['username']) ?></b></div>
    </div>

    <div class="card">
        <table>
            <tr>
                <th>Ticket #</th>
                <th>Flight</th>
                <th>Route</th>
                <th>Airline</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Seat / Class</th>
                <th>Status</th>
                <th>Booked</th>
                <th>Action</th>
            </tr>

            <?php if ($result->num_rows === 0): ?>
                <tr>
                    <td colspan="10">No tickets yet. Book a flight from <a href="search_flights.php">Search Flights</a>.</td>
                </tr>
            <?php else: ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ticket_number']) ?></td>
                        <td><?= htmlspecialchars($row['flight_number']) ?></td>
                        <td><?= htmlspecialchars($row['departure_airport_code']) ?> → <?= htmlspecialchars($row['arrival_airport_code']) ?></td>
                        <td><?= htmlspecialchars($row['airline_name']) ?></td>
                        <td><?= htmlspecialchars($row['departure_time']) ?></td>
                        <td><?= htmlspecialchars($row['arrival_time']) ?></td>
                        <td><?= htmlspecialchars($row['seat_number']) ?> / <?= htmlspecialchars($row['travel_class']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['booking_date']) ?></td>
                        <td>
                            <?php if ($row['status'] !== 'Cancelled'): ?>
                                <a class="btn btn-danger" href="cancel_ticket.php?ticket_number=<?= urlencode($row['ticket_number']) ?>"
                                   onclick="return confirm('Cancel this ticket?');">
                                    Cancel
                                </a>
                            <?php else: ?>
                                <span class="small">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </table>
    </div>

</div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
