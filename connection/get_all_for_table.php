<?php
header('Content-Type: application/json');
include 'connection.php';

$conn = getConnection();

// Query mengambil data sesuai urutan di database (terbaru di bawah)
$sql = "
    SELECT 
        g.waktu, g.lat, g.lon, g.sog_knot, g.sog_kmh, g.cog_degree,
        s.id AS surface_id, u.id AS underwater_id
    FROM gauges g
    LEFT JOIN surface s ON g.waktu = s.waktu
    LEFT JOIN underwater u ON g.waktu = u.waktu
    ORDER BY g.waktu ASC
";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $row['surface_image'] = $row['surface_id'] 
        ? "get_image.php?id={$row['surface_id']}" 
        : '';
    $row['underwater_image'] = $row['underwater_id'] 
        ? "get_image.php?id={$row['underwater_id']}" 
        : '';
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
