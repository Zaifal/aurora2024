<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'speed_course_db');

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Query to fetch all images
$result = $conn->query("SELECT id, image_data, image_type FROM images");

$images = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Convert binary data to base64 string
        $images[] = [
            'id' => $row['id'], // Make sure to include the ID for deleting
            'data' => base64_encode($row['image_data']),
            'type' => $row['image_type']
        ];
    }
}

$conn->close();
echo json_encode($images);
?>
