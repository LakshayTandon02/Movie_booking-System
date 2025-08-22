<?php
$host = "localhost";
$db = "movie_booking";
$user = "root";   // your XAMPP MySQL username
$pass = "";       // your MySQL password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
