<?php
header('Content-Type: application/json');
include 'connection.php';

$conn = getConnection();

$sql = "
    SELECT id, 'surface' AS type, waktu, CONCAT('get_image.php?id=', id) AS image_url FROM surface
    UNION ALL
    SELECT id, 'underwater' AS type, waktu, CONCAT('get_image.php?id=', id) AS image_url FROM underwater
    ORDER BY waktu ASC
";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
