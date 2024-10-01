<?php
header('Content-Type: application/json'); // Mengatur header untuk JSON

// Sambungkan ke database
$conn = new mysqli('localhost', 'root', '', 'speed_course_db');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari tabel
$result = $conn->query("SELECT sog_knot, sog_kmh, cog_degree FROM gauges ORDER BY id DESC LIMIT 1");

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(array("error" => "No data found"));
}

$conn->close();
?>
