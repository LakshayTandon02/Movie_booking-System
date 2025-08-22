<?php
// get_bookings.php
header('Content-Type: application/json');
include 'db.php'; // your DB connection

$sql = "SELECT * FROM bookings ORDER BY booking_date DESC";
$result = $conn->query($sql);

$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

echo json_encode($bookings);
$conn->close();
?>
