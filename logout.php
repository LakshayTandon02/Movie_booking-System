<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'moviebooking');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE email='$email' LIMIT 1");
    if ($res->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email not registered']);
        exit;
    }

    $user = $res->fetch_assoc();
    if (!$user['verified']) {
        echo json_encode(['status' => 'error', 'message' => 'Please verify your email first']);
        exit;
    }

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
    }
}
?>
