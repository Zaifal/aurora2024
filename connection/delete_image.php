<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'speed_course_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the image ID from the query parameters
$imageId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($imageId > 0) {
    // Prepare the SQL statement to delete the image
    $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
    $stmt->bind_param("i", $imageId);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Image deleted successfully.']);
    } else {
        echo json_encode(['error' => 'Failed to delete image.']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid image ID.']);
}

$conn->close();
?>
