<?php
header('Content-Type: application/json'); // Mengatur header untuk JSON

include 'connection.php'; // Menginclude file koneksi

$conn = getConnection(); // Dapatkan koneksi

// Query untuk mengambil gambar terbaru dari tabel surface
$sql = "SELECT image_data, image_type FROM underwater ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil data gambar
    $row = $result->fetch_assoc();
    $imageData = base64_encode($row['image_data']); // Encode gambar ke base64
    $imageType = $row['image_type']; // Ambil jenis gambar

    // Siapkan URL data gambar
    $imageSrc = 'data:' . $imageType . ';base64,' . $imageData;

    // Kembalikan JSON dengan data gambar
    echo json_encode(['image' => $imageSrc]);
} else {
    echo json_encode(['error' => 'No image found.']);
}

$conn->close();
?>
