<?php
$conn = new mysqli('localhost', 'root', '', 'moviebooking');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $res = $conn->query("SELECT * FROM users WHERE token='$token' LIMIT 1");
    if ($res->num_rows > 0) {
        $conn->query("UPDATE users SET verified=1, token='' WHERE token='$token'");
        echo "Email verified successfully! You can now login.";
    } else {
        echo "Invalid token.";
    }
}
?>
