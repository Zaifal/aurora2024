<?php
$host = "localhost";
$dbname = "aurora";
$username = "aurora";
$password = "@ur0r45TMK6j4y4";

try {
    // Connect to MySQL database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    var_dump($_POST);

    // Check if all necessary POST parameters are set
    if (isset($_POST['link'])) {

        // Retrieve POST data
        $link = $_POST['link'];

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO gauges (link) 
                                VALUES (:link)");

        // Bind the parameters
        $stmt->bindParam(':link', var: $link);

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
