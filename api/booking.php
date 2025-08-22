<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'config.php';

// Create a new booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validate required fields
        $required_fields = ['movie_id', 'theater_id', 'showtime', 'seats', 'user_name', 'user_email', 'user_phone'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                http_response_code(400);
                echo json_encode(['error' => "Missing required field: $field"]);
                exit();
            }
        }
        
        // Generate booking reference
        $booking_ref = 'BK' . strtoupper(uniqid());
        
        // Calculate total price
        $price_per_ticket = 200; // Base price
        $total_price = $data['seats'] * $price_per_ticket;
        
        // In a real application, you would save to database here
        // For now, we'll return a mock response
        
        echo json_encode([
            'success' => true,
            'booking_id' => rand(1000, 9999),
            'booking_ref' => $booking_ref,
            'movie' => 'Sample Movie',
            'theater' => 'Sample Theater',
            'showtime' => $data['showtime'],
            'seats' => $data['seats'],
            'total_price' => $total_price,
            'customer_name' => $data['user_name'],
            'customer_email' => $data['user_email']
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
}

// Get booking details
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        if (isset($_GET['ref'])) {
            // Get booking by reference
            $booking_ref = $_GET['ref'];
            
            // Mock booking data
            $booking = [
                'booking_ref' => $booking_ref,
                'movie_title' => 'Sample Movie',
                'theater_name' => 'Sample Theater',
                'show_time' => '2023-12-25 18:30:00',
                'num_seats' => 2,
                'total_price' => 400,
                'customer_name' => 'John Doe',
                'customer_email' => 'john@example.com',
                'status' => 'confirmed'
            ];
            
            echo json_encode(['booking' => $booking]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Missing reference parameter']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
}
?>