<?php
header('Content-Type: application/json');
include 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if(!$name || !$email || !$password) {
        echo json_encode(['status'=>false, 'message'=>'All fields are required!']);
        exit;
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM user WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
        echo json_encode(['status'=>false, 'message'=>'Email already registered!']);
        exit;
    }
    $stmt->close();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    if($stmt->execute()){
        echo json_encode(['status'=>true, 'message'=>'Registration successful!']);
    } else {
        echo json_encode(['status'=>false, 'message'=>'Registration failed, try again.']);
    }
    $stmt->close();
    $conn->close();
}
?>
