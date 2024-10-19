<?php
$host = "localhost";
$dbname = "aurora";
$username = "aurora";
$password = "@ur0r45TMK6j4y4";

try {
    // Connect to MySQL database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if all necessary POST parameters are set
    if (
        isset($_POST['sog_knot']) && isset($_POST['sog_kmh']) &&
        isset($_POST['cog_degree']) && isset($_POST['lat']) && isset($_POST['lon'])) {

        // Retrieve POST data
        $sog_knot = $_POST['sog_knot'];
        $sog_kmh = $_POST['sog_kmh'];
        $cog_degree = $_POST['cog_degree'];
        $lat = $_POST['lat'];
        $lon = $_POST['lon'];

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO gauges (id, sog_knot, sog_kmh, cog_degree, lat, lon) 
                                VALUES (NULL, :sog_knot, :sog_kmh, :cog_degree, :lat, :lon)");

        // Bind the parameters
        $stmt->bindParam(':sog_knot', $sog_knot);
        $stmt->bindParam(':sog_kmh', $sog_kmh);
        $stmt->bindParam(':cog_degree', $cog_degree);
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lon', var: $lon);

        // Execute the statement
        $stmt->execute();
        echo "New record created successfully";
    } else {
        echo "Error: Missing required POST parameters";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close the database connection
?>
