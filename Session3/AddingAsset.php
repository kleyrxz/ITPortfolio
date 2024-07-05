<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'session3';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function generateAssetSN($DepartmentLocationID, $AssetGroupID, $conn) {
    $sql = "SELECT AssetSN FROM assets 
    WHERE DepartmentLocationID = 13 AND AssetGroupID = 5 
    ORDER BY AssetSN DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result(); 
    if ($result->num_rows == 0) {
        $serialNumber = "0001";
    } else {
        $row = $result->fetch_assoc();
        $lastSerialNumber = $row['AssetSN'];
        $lastSerialNumber = substr($lastSerialNumber, 8); 
        $lastSerialNumber = intval($lastSerialNumber); 
        $serialNumber = sprintf("%04d", $lastSerialNumber + 1); 
    }   
    $AssetSN = $DepartmentLocationID . "/0" . $AssetGroupID . "/" . $serialNumber;
    return $AssetSN; // Corrected variable name
}

// Check if assetName is set in the POST data
if(isset($_POST["assetName"])) {
    $assetName = $_POST["assetName"];
    $DepartmentLocationID = 13;
    $EmployeeID = 69;
    $AssetGroupID = 5;
    $AssetSN = generateAssetSN($DepartmentLocationID, $AssetGroupID, $conn); // Corrected variable name

    // Prepare and execute the SQL query
    $sql = "INSERT INTO assets (AssetSN, AssetName, DepartmentLocationID, EmployeeID, AssetGroupID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $AssetSN, $assetName, $DepartmentLocationID, $EmployeeID, $AssetGroupID); // Corrected variable name

    if ($stmt->execute()) {
        echo "Asset was added to the list.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Return an error message if assetName is not set
    echo "Error: assetName is not set.";
}

$conn->close();
?>
