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

// Check if PartID is sent via POST
if (isset($_POST['partId'])) {
    $partId = $_POST['partId'];

    // Prepare SQL statement to fetch BatchNumbers for the selected PartID
    $sql = "SELECT DISTINCT BatchNumber FROM orderitems WHERE PartID = $partId";

    // Execute SQL statement
    $result = $connection->query($sql);

    // Array to store BatchNumbers
    $batchNumbers = array();

    if ($result->num_rows > 0) {
        // Fetch and store BatchNumbers in the array
        while ($row = $result->fetch_assoc()) {
            $batchNumbers[] = $row['BatchNumber'];
        }
    }

    // Return BatchNumbers as JSON response
    echo json_encode($batchNumbers);
} else {
    // Return error message if PartID is not provided
    echo "Error: PartID not provided";
}

// Close connection
$connection->close();
?>
