<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Session4";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_POST['id'])) {
    $partId = intval($_POST['id']);

    // SQL query to fetch BatchNumberHasRequired value for the selected part
    $sql = "SELECT BatchNumberHasRequired FROM parts WHERE ID = ?";
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $partId);
        $stmt->execute();
        $stmt->bind_result($BatchNumberHasRequired);
        $stmt->fetch();
        
        // Output the result
        echo $BatchNumberHasRequired;
        
        $stmt->close();
    }
}

$connection->close();
?>
