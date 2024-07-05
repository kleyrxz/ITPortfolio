<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "session4";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the order item ID from the AJAX request
$orderItemId = intval($_POST['orderItemId']);

// Query to fetch the batch number from orderitems table
$query = "SELECT BatchNumber FROM orderitems WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $orderItemId);
$stmt->execute();
$stmt->bind_result($batchNumber);
$stmt->fetch();

// Close the statement and connection
$stmt->close();
$conn->close();

// Output the batch number
echo $batchNumber ?: 'No Batch Number';
?>
