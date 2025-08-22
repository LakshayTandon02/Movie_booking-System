<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

// Get theaters based on location
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
    $lng = isset($_GET['lng']) ? floatval($_GET['lng']) : null;
    $movie_id = isset($_GET['movie_id']) ? intval($_GET['movie_id']) : null;
    
    try {
        // Base query
        $sql = "SELECT t.*, 
                (6371 * acos(cos(radians(:lat)) * cos(radians(latitude)) * 
                cos(radians(longitude) - radians(:lng)) + sin(radians(:lat)) * 
                sin(radians(latitude)))) AS distance 
                FROM theaters t";
        
        // If movie_id is provided, join with show_times to find theaters showing this movie
        if ($movie_id) {
            $sql = "SELECT DISTINCT t.*, 
                    (6371 * acos(cos(radians(:lat)) * cos(radians(latitude)) * 
                    cos(radians(longitude) - radians(:lng)) + sin(radians(:lat)) * 
                    sin(radians(latitude)))) AS distance 
                    FROM theaters t
                    INNER JOIN theater_screens ts ON t.id = ts.theater_id
                    INNER JOIN show_times st ON ts.id = st.theater_screen_id
                    WHERE st.movie_id = :movie_id AND st.show_time >= NOW()";
        }
        
        $sql .= " HAVING distance < 50 ORDER BY distance LIMIT 10";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':lat', $lat, PDO::PARAM_STR);
        $stmt->bindParam(':lng', $lng, PDO::PARAM_STR);
        
        if ($movie_id) {
            $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $theaters = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format the response
        $formattedTheaters = [];
        foreach ($theaters as $theater) {
            $formattedTheaters[] = [
                'id' => $theater['id'],
                'name' => $theater['name'],
                'address' => $theater['address'] . ', ' . $theater['city'] . ', ' . $theater['state'],
                'distance' => round($theater['distance'], 1) . ' km',
                'calculated_distance' => round($theater['distance'], 1)
            ];
        }
        
        echo json_encode(['theaters' => $formattedTheaters]);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

// Handle theater search
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $query = isset($data['query']) ? $data['query'] : '';
    $city = isset($data['city']) ? $data['city'] : '';
    
    try {
        $sql = "SELECT * FROM theaters WHERE 1=1";
        $params = [];
        
        if (!empty($query)) {
            $sql .= " AND (name LIKE :query OR address LIKE :query)";
            $params[':query'] = '%' . $query . '%';
        }
        
        if (!empty($city)) {
            $sql .= " AND city = :city";
            $params[':city'] = $city;
        }
        
        $sql .= " LIMIT 10";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $theaters = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['theaters' => $theaters]);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>