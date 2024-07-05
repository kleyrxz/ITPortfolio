<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "session4";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID of the item to be removed
$id = intval($_POST['id']);

// SQL query to delete the record
$sql = "DELETE FROM orderitems WHERE ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

// Close the connection
$stmt->close();
$conn->close();
?>
