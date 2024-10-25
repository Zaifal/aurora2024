<?php
header('Content-Type: application/json');
include 'connection.php';

$conn = getConnection();

// Query mengambil data sesuai urutan di database (terbaru di bawah)
$sql = "
    SELECT 
        g.waktu, g.lat, g.lon, g.sog_knot, g.sog_kmh, g.cog_degree
    FROM gauges g
    ORDER BY g.waktu ASC
";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
