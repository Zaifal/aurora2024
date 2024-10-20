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
$stmt = $conn->prepare("SELECT balls FROM ball_counter ORDER BY id DESC LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();

// Mengecek apakah ada hasil
if ($result->num_rows > 0) {
    // Mengambil data sebagai associative array
    $data = $result->fetch_assoc();
    echo json_encode($data); // Mengembalikan hasil sebagai JSON
} else {
    echo json_encode(array("balls" => 0)); // Jika tidak ada hasil
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
