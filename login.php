<?php
header('Content-Type: application/json');
include 'db.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if(!$email || !$password) {
        echo json_encode(['status'=>false, 'message'=>'All fields are required!']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, name, password FROM user WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows == 0){
        echo json_encode(['status'=>false, 'message'=>'Email not registered!']);
        exit;
    }

    $stmt->bind_result($id, $name, $hashedPassword);
    $stmt->fetch();

    if(password_verify($password, $hashedPassword)){
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        echo json_encode(['status'=>true, 'message'=>'Login successful!']);
    } else {
        echo json_encode(['status'=>false, 'message'=>'Incorrect password!']);
    }

    $stmt->close();
    $conn->close();
}
?>
