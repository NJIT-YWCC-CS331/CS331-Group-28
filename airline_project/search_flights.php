<?php
include 'auth_user.php';
include 'connection.php';

$from = trim($_GET['from'] ?? '');
$to = trim($_GET['to'] ?? '');
$airline = trim($_GET['airline'] ?? '');

$sql = "
SELECT 
    f.flight_number,
    a.name AS airline_name,
    f.departure_airport_code,
    f.arrival_airport_code,
    f.departure_time,
    f.arrival_time,
    f.duration_minutes
FROM flight f
JOIN airline_company a ON a.airline_id = f.airline_id
WHERE 1=1
";

$params = [];
$types = "";

// add filters dynamically
if ($from !== '') {
    $sql .= " AND f.departure_airport_code = ? ";
    $params[] = strtoupper($from);
    $types .= "s";
}
if ($to !== '') {
    $sql .= " AND f.arrival_airport_code = ? ";
    $params[] = strtoupper($to);
    $types .= "s";
}
if ($airline !== '') {
    $sql .= " AND a.name LIKE ? ";
    $params[] = "%" . $airline . "%";
    $types .= "s";
}

$sql .= " ORDER BY f.departure_time ASC ";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Search Flights</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; }
        .container { max-width: 900px; margin: 0 auto; }
        .nav { margin-bottom: 15px; }
        .card { border: 1px solid #ccc; padding: 16px; border-radius: 6px; margin-bottom: 15px; }
        input { padding: 8px; margin-right: 8px; }
        .btn { padding: 8px 14px; border: none; background: #007bff; color: #fff; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #0066d1; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f5f5f5; }
        .small { color: #555; font-size: 0.9em; }
    </style>
</head>
<body>
<div class="container">

    <div class="nav">
        <a href="user_home.php">⬅ Back to Home</a> |
        <a href="profile.php">My Profile</a> |
        <a href="logout.php">Logout</a>
    </div>

    <div class="card">
        <h2>Search Flights</h2>
        <form method="get" action="search_flights.php">
            <label>From (airport code):</label>
            <input type="text" name="from" placeholder="JFK" value="<?= htmlspecialchars($from) ?>" maxlength="10">

            <label>To:</label>
            <input type="text" name="to" placeholder="LHR" value="<?= htmlspecialchars($to) ?>" maxlength="10">

            <label>Airline:</label>
            <input type="text" name="airline" placeholder="SkyHigh" value="<?= htmlspecialchars($airline) ?>" maxlength="120">

            <button class="btn" type="submit">Search</button>
        </form>
        <div class="small">Tip: Try From=JFK, To=LHR (based on your sample data).</div>
    </div>

    <div class="card">
        <h3>Results</h3>
        <table>
            <tr>
                <th>Flight #</th>
                <th>Airline</th>
                <th>From</th>
                <th>To</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Duration (min)</th>
                <th>Action</th>
            </tr>
            <?php if ($result->num_rows === 0): ?>
                <tr><td colspan="8">No flights found.</td></tr>
            <?php else: ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['flight_number']) ?></td>
                        <td><?= htmlspecialchars($row['airline_name']) ?></td>
                        <td><?= htmlspecialchars($row['departure_airport_code']) ?></td>
                        <td><?= htmlspecialchars($row['arrival_airport_code']) ?></td>
                        <td><?= htmlspecialchars($row['departure_time']) ?></td>
                        <td><?= htmlspecialchars($row['arrival_time']) ?></td>
                        <td><?= htmlspecialchars($row['duration_minutes']) ?></td>
                        <td>
                            <a href="book_flight.php?flight_number=<?= urlencode($row['flight_number']) ?>">
                                Book
                            </a>
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
