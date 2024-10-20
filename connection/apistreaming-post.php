<?php 
$host = "localhost";
$dbname = "aurora";
$username = "aurora";
$password = "@ur0r45TMK6j4y4";

try {
    // Connect to MySQL database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get the latest link
    $stmt = $conn->prepare("SELECT link FROM link_stream ORDER BY id DESC LIMIT 1");
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Output the link as JSON for the frontend to use
        echo json_encode($result);
    } else {
        echo json_encode(["link" => null]);
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null; // Close the database connection
?>
