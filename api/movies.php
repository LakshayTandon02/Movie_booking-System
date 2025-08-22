<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

// Get now playing movies
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type'])) {
    $type = $_GET['type'];
    
    if ($type === 'now_playing') {
        // In a real application, you would fetch from your database
        // For demo, we'll return sample data
        $movies = [
            [
                'id' => 1,
                'title' => 'Spiderman: No Way Home',
                'poster_path' => '/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg',
                'vote_average' => 8.4,
                'genre_ids' => [28, 12, 878]
            ],
            [
                'id' => 2,
                'title' => 'The Batman',
                'poster_path' => '/74xTEgt7R36Fpooo50r9T25onhq.jpg',
                'vote_average' => 8.2,
                'genre_ids' => [28, 80, 9648]
            ],
            // Add more movies as needed
        ];
        
        echo json_encode(['results' => $movies]);
    } elseif ($type === 'upcoming') {
        // Fetch upcoming movies
        $upcoming = [
            [
                'id' => 3,
                'title' => 'Avatar: The Way of Water',
                'poster_path' => '/t6HIqrRAclMCA60NsSmeqe9RmNV.jpg',
                'vote_average' => 0,
                'genre_ids' => [878, 12, 28]
            ],
            // Add more upcoming movies
        ];
        
        echo json_encode(['results' => $upcoming]);
    }
}
?>