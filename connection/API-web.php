<?php
header('Content-Type: application/json');

// Cek apakah request menggunakan metode POST dan parameter tersedia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sog_knot']) && isset($_POST['sog_kmh']) && isset($_POST['cog_degree']) && isset($_POST['lat']) && isset($_POST['lon'])) {
        // Ambil data POST
        $sog_knot = floatval($_POST['sog_knot']);
        $sog_kmh = floatval($_POST['sog_kmh']);
        $cog_degree = floatval($_POST['cog_degree']);
        $lat = floatval($_POST['lat']);
        $lon = floatval($_POST['lon']);
        
        // Buat respons JSON yang akan dikirim ke web
        $response = [
            'sog_knot' => $sog_knot,
            'sog_kmh' => $sog_kmh,
            'cog_degree' => $cog_degree,
            'lat' => $lat,
            'lon' => $lon,
            'message' => 'Data received successfully'
        ];

        // Kirim JSON ke frontend
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Missing required parameters']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
