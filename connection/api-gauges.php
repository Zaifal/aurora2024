<?php
// Konfigurasi koneksi database
$host = "localhost";
$dbname = "aurora";
$username = "aurora";
$password = "@ur0r45TMK6j4y4";

// Buat koneksi MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Periksa apakah request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan semua parameter POST tersedia
    if (
        isset($_POST['sog_knot']) && isset($_POST['sog_kmh']) &&
        isset($_POST['cog_degree']) && isset($_POST['lat']) && isset($_POST['lon'])
    ) {
        // Ambil data dari POST
        $sog_knot = $_POST['sog_knot'];
        $sog_kmh = $_POST['sog_kmh'];
        $cog_degree = $_POST['cog_degree'];
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];

        // Siapkan query SQL untuk menambahkan data
        $sql = "INSERT INTO gauges (lat, lon, sog_knot, sog_kmh, cog_degree) VALUES (?, ?, ?, ?, ?)";

        // Gunakan prepared statement untuk menghindari SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddddd", $lat, $lon, $sog_knot, $sog_kmh, $cog_degree);

        // Eksekusi statement dan periksa apakah berhasil
        if ($stmt->execute()) {
            echo json_encode(["message" => "Data gauge added successfully."]);
        } else {
            echo json_encode(["error" => "Error inserting data: " . $stmt->error]);
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo json_encode(["error" => "Missing required POST parameters"]);
    }
}

// Tutup koneksi
$conn->close();
?>
