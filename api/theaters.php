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

// Get theaters based on location
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $lat = isset($_GET['lat']) ? floatval($_GET['lat']) : 12.9716;
        $lng = isset($_GET['lng']) ? floatval($_GET['lng']) : 77.5946;
        $movie_id = isset($_GET['movie_id']) ? intval($_GET['movie_id']) : null;
        
        // Sample data - in real application, you would query the database
        $theaters = [
            [
                'id' => 1,
                'name' => 'PVR Cinemas: Forum Mall',
                'address' => 'Koramangala, Bangalore',
                'distance' => '2.3 km',
                'price' => 180,
                'coordinates' => ['lat' => 12.9352, 'lng' => 77.6245]
            ],
            [
                'id' => 2,
                'name' => 'INOX: Garuda Mall',
                'address' => 'Magrath Road, Bangalore',
                'distance' => '3.7 km',
                'price' => 200,
                'coordinates' => ['lat' => 12.9716, 'lng' => 77.5946]
            ]
        ];
        
        echo json_encode(['theaters' => $theaters]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
}

// Handle theater search
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $query = isset($data['query']) ? $data['query'] : '';
    
    // Sample theater data
    $allTheaters = [
        [
            'id' => 1,
            'name' => 'PVR Cinemas: Forum Mall',
            'address' => 'Koramangala, Bangalore',
            'distance' => '2.3 km',
            'price' => 180
        ],
        [
            'id' => 2,
            'name' => 'INOX: Garuda Mall',
            'address' => 'Magrath Road, Bangalore',
            'distance' => '3.7 km',
            'price' => 200
        ]
    ];
    
    // Filter theaters based on search query
    if (!empty($query)) {
        $filteredTheaters = array_filter($allTheaters, function($theater) use ($query) {
            return stripos($theater['name'], $query) !== false || 
                   stripos($theater['address'], $query) !== false;
        });
        echo json_encode(['theaters' => array_values($filteredTheaters)]);
    } else {
        echo json_encode(['theaters' => $allTheaters]);
    }
}
?>