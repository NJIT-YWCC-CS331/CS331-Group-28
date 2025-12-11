<?php
include 'connection.php';

$sql = "SELECT flight_number, departure_airport_code, arrival_airport_code FROM flight";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Flights</title>
</head>
<body>
    <h1>Flights from Database</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Flight #</th>
            <th>From</th>
            <th>To</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['flight_number']) ?></td>
                <td><?= htmlspecialchars($row['departure_airport_code']) ?></td>
                <td><?= htmlspecialchars($row['arrival_airport_code']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>