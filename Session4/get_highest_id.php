<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "session4";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to fetch the highest ID from the orders table
$sql = "SELECT MAX(ID) AS highest_id FROM orders";
$result = $connection->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    // Get the highest ID and return it as a response
    echo $row['highest_id'];
} else {
    // Handle the case where the query fails or returns no results
    echo "Error fetching highest ID";
}

// Close connection
$connection->close();
?>
