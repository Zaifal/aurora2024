<?php
function getConnection() {
    $conn = new mysqli('localhost', 'aurora', '', 'speed_course_db');

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
