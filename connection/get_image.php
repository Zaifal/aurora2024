<?php
// Mengatur header untuk mengizinkan akses dari sumber yang berbeda (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: image/png"); // Atur tipe konten menjadi PNG

// Menghubungkan ke database
$conn = new mysqli('localhost', 'root', '', 'speed_course_db');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID gambar dari URL
$id = intval($_GET['id']); // Pastikan ID aman
$result = $conn->query("SELECT image_data, image_type FROM images WHERE id = $id");

if ($row = $result->fetch_assoc()) {
    header("Content-Type: " . $row['image_type']); // Atur header untuk tipe gambar
    echo $row['image_data']; // Mengirim data gambar sebagai biner
} else {
    http_response_code(404); // Mengatur kode respon ke 404 jika gambar tidak ditemukan
    echo "Image not found.";
}

$conn->close();
?>
