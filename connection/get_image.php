<?php
include 'connection.php';

$conn = getConnection();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mengambil gambar dari database (surface atau underwater)
$sql = "SELECT image_data, image_type FROM (
            SELECT id, image_data, image_type FROM surface
            UNION ALL
            SELECT id, image_data, image_type FROM underwater
        ) AS images WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($imageData, $imageType);
$stmt->fetch();

if ($imageData) {
    header("Content-Type: $imageType");
    echo $imageData;
} else {
    http_response_code(404);
    echo "Image not found.";
}

$stmt->close();
$conn->close();
?>
