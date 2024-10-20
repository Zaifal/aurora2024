<?php
header('Content-Type: application/json'); // Mengatur header untuk JSON

// Sambungkan ke database
$conn = new mysqli('localhost', 'aurora', '@ur0r45TMK6j4y4', 'aurora');
// Cek koneksi
if ($conn->connect_error) {
    echo json_encode(array("error" => "Connection failed: " . $conn->connect_error));
    exit();
}

// Menggunakan prepared statement
$stmt = $conn->prepare("SELECT link FROM link_stream ORDER BY id DESC LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();


$stmt->close();
$conn->close();
?>