<?php
function getConnection() {
    $conn = new mysqli('localhost', 'aurora', '@ur0r45TMK6j4y4', 'aurora');

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
