<?php
include 'db.php';

// Get JSON data
$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode(["success"=>false, "message"=>"No data received"]);
    exit;
}

// Extract values
$name            = $data['name'];
$email           = $data['email'];
$phone           = $data['phone'];
$movie_id        = $data['movie_id'];
$movie_title     = $data['movie_title'];
$poster          = $data['poster'];
$theater_name    = $data['theater_name'];
$theater_location= $data['theater_location'];
$showtime        = $data['showtime'];
$seats           = $data['seats'];
$total_amount    = $data['total_amount'];

// Example insert query
$stmt = $conn->prepare("INSERT INTO bookings 
    (name,email,phone,movie_id,movie_title,poster,theater_name,theater_location,showtime,seats,total_amount) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?)");

$stmt->bind_param("sssissssssi", $name,$email,$phone,$movie_id,$movie_title,$poster,$theater_name,$theater_location,$showtime,$seats,$total_amount);

if($stmt->execute()){
    echo json_encode(["success"=>true, "message"=>"Booking successful"]);
}else{
    echo json_encode(["success"=>false, "message"=>"DB error: ".$stmt->error]);
}
