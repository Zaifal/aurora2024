<?php
// Koneksi database

$host = "localhost";
$dbname = "aurora";
$username = "aurora";
$password = "@ur0r45TMK6j4y4";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Tambah data ke database (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'];

    if ($table == 'gauges') {
           // Check if all required parameters are set
       if (isset($_POST['sog_knot'], $_POST['sog_kmh'], $_POST['cog_degree'], $_POST['lat'], $_POST['lon'])) {
           $sog_knot = floatval($_POST['sog_knot']);
           $sog_kmh = floatval($_POST['sog_kmh']);
           $cog_degree = floatval($_POST['cog_degree']);
           $lat = floatval($_POST['lat']);
           $lon = floatval($_POST['lon']);

        // Prepare and execute SQL statement
           $sql = "INSERT INTO gauges (sog_knot, sog_kmh, cog_degree, lat, lon) VALUES (:sog_knot, :sog_kmh, :cog_degree, :lat, :lon)";
           $stmt = $pdo->prepare($sql);
           $stmt->bindParam(':sog_knot', $sog_knot);
           $stmt->bindParam(':sog_kmh', $sog_kmh);
           $stmt->bindParam(':cog_degree', $cog_degree);
           $stmt->bindParam(':lat', $lat);
           $stmt->bindParam(':lon', $lon);

           if ($stmt->execute()) {
               echo json_encode(["message" => "Data added successfully."]);
           } else {
               echo json_encode(["error" => "Failed to add data."]);
           }
    } else {
        echo json_encode(["error" => "Missing required parameters."]);
           }
    }
    elseif ($table == 'surface' || $table == 'underwater') {
        // Untuk gambar
        if (isset($_FILES['image_data'])) {
            $image_data = file_get_contents($_FILES['image_data']['tmp_name']);
            $image_type = $_FILES['image_data']['type'];

            $sql = "INSERT INTO $table (image_data, image_type) VALUES (:image_data, :image_type)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':image_data', $image_data, PDO::PARAM_LOB);
            $stmt->bindParam(':image_type', $image_type);
            $stmt->execute();

            echo json_encode(["message" => "Image uploaded successfully to $table."]);
        } else {
            echo json_encode(["error" => "No image uploaded."]);
        }
    }
}

// Ambil data dari database (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $table = $_GET['table'];

    if ($table == 'gauge') {
        $sql = "SELECT * FROM gauge";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } elseif ($table == 'surface' || $table == 'underwater') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT image_data, image_type FROM $table WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $image = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($image) {
                header('Content-Type: ' . $image['image_type']);
                echo $image['image_data'];
            } else {
                echo json_encode(["error" => "Image not found."]);
            }
        } else {
            echo json_encode(["error" => "ID is required."]);
        }
    }
}
?>
