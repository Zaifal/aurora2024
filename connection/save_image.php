<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'speed_course_db');

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Ambil data JSON dari permintaan
$data = json_decode(file_get_contents("php://input"));

if (json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(['success' => false, 'message' => 'Invalid JSON input']));
}

// Ekstrak gambar dari data
$image = $data->image;

// Menghapus header data URL
$image = str_replace('data:image/png;base64,', '', $image);
$image = str_replace(' ', '+', $image);
$image = base64_decode($image);

// Simpan format gambar
$image_type = 'image/png';

// Siapkan pernyataan untuk menyimpan gambar sebagai BLOB
$stmt = $conn->prepare("INSERT INTO images (image_data, image_type) VALUES (?, ?)");
$stmt->bind_param("bs", $image, $image_type);
$stmt->send_long_data(0, $image);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Image saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error saving image: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
