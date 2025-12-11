<?php
include 'auth_user.php';
include 'connection.php';

$user_id = (int)$_SESSION['user_id'];
$flight_number = (int)($_GET['flight_number'] ?? 0);

if ($flight_number <= 0) {
    die("Invalid flight number.");
}

// Get flight info (for display)
$stmt = $conn->prepare("
    SELECT f.flight_number, a.name AS airline_name,
           f.departure_airport_code, f.arrival_airport_code,
           f.departure_time, f.arrival_time
    FROM flight f
    JOIN airline_company a ON a.airline_id = f.airline_id
    WHERE f.flight_number = ?
    LIMIT 1
");
$stmt->bind_param("i", $flight_number);
$stmt->execute();
$flight = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$flight) {
    die("Flight not found.");
}

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seat_number  = trim($_POST['seat_number'] ?? '');
    $travel_class = trim($_POST['travel_class'] ?? 'Economy');

    if ($seat_number === '') {
        $errors[] = "Seat number is required.";
    }

    // prevent duplicate booking (same user for same flight)
    if (empty($errors)) {
        $check = $conn->prepare("SELECT ticket_number FROM ticket WHERE user_id = ? AND flight_number = ? LIMIT 1");
        $check->bind_param("ii", $user_id, $flight_number);
        $check->execute();
        $exists = $check->get_result()->fetch_assoc();
        $check->close();

        if ($exists) {
            $errors[] = "You already booked this flight.";
        }
    }

    if (empty($errors)) {
        // Generate a new ticket_number safely 
        $res = $conn->query("SELECT COALESCE(MAX(ticket_number), 200) + 1 AS next_ticket FROM ticket");
        $next_ticket = (int)$res->fetch_assoc()['next_ticket'];

        $booking_date = date("Y-m-d H:i:s");
        $status = "Booked";

        // passenger_id is part of original schema; we can set it NULL IF allowed.
        
        $passenger_id = NULL;

        $ins = $conn->prepare("
            INSERT INTO ticket (ticket_number, passenger_id, flight_number, booking_date, seat_number, travel_class, status, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        
        $ins->bind_param("iiissssi",
            $next_ticket,
            $passenger_id,
            $flight_number,
            $booking_date,
            $seat_number,
            $travel_class,
            $status,
            $user_id
        );

        if ($ins->execute()) {
            $success = "Booking successful! Your ticket number is: " . $next_ticket;
        } else {
            $errors[] = "Booking failed: " . $conn->error;
        }
        $ins->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Book Flight</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        .container { max-width: 700px; margin: 0 auto; }
        .nav { margin-bottom: 15px; }
        .card { border: 1px solid #ccc; padding: 16px; border-radius: 6px; margin-bottom: 15px; }
        .error { color: #b30000; margin-bottom: 6px; }
        .success { color: #008000; margin-bottom: 6px; }
        input, select { padding: 8px; margin-top: 6px; width: 100%; box-sizing: border-box; }
        .btn { padding: 8px 14px; border: none; background: #28a745; color: #fff; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        .btn:hover { background: #218838; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
<div class="container">

    <div class="nav">
        <a href="search_flights.php">⬅ Back to Search</a> |
        <a href="user_home.php">Home</a> |
        <a href="my_tickets.php">My Tickets</a> |
        <a href="logout.php">Logout</a>
    </div>

    <div class="card">
        <h2>Book Flight #<?= htmlspecialchars($flight['flight_number']) ?></h2>
        <p><span class="label">Airline:</span> <?= htmlspecialchars($flight['airline_name']) ?></p>
        <p><span class="label">Route:</span> <?= htmlspecialchars($flight['departure_airport_code']) ?> → <?= htmlspecialchars($flight['arrival_airport_code']) ?></p>
        <p><span class="label">Departure:</span> <?= htmlspecialchars($flight['departure_time']) ?></p>
        <p><span class="label">Arrival:</span> <?= htmlspecialchars($flight['arrival_time']) ?></p>
    </div>

    <div class="card">
        <h3>Booking Details</h3>

        <?php foreach ($errors as $e): ?>
            <div class="error"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post">
            <label>Seat Number</label>
            <input type="text" name="seat_number" placeholder="12A" required>

            <label>Travel Class</label>
            <select name="travel_class">
                <option value="Economy">Economy</option>
                <option value="Business">Business</option>
                <option value="First">First</option>
            </select>

            <button class="btn" type="submit">Confirm Booking</button>
        </form>
    </div>

</div>
</body>
</html>
<?php $conn->close(); ?>
