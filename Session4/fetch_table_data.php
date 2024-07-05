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

// Get the selected warehouse ID and stock status from the POST request
$selectedWarehouseID = $_POST['warehouseID'];
$selectedStockStatus = $_POST['stockStatus'];

// Modify the SQL query based on the selected warehouse and stock status
$query = "SELECT orderitems.ID AS OrderItemID, parts.ID AS PartID, parts.Name AS PartName, parts.MinimumAmount AS CurrentStock, 
          orderitems.Amount AS TotalAmount, orders.ID AS OrderID, orders.DestinationWarehouseID,
          orderitems.BatchNumber
          FROM parts
          LEFT JOIN orderitems ON parts.ID = orderitems.PartID
          LEFT JOIN orders ON orderitems.OrderID = orders.ID
          WHERE 1=1";

if ($selectedWarehouseID) {
    $query .= " AND orders.DestinationWarehouseID = " . intval($selectedWarehouseID);
}

if ($selectedStockStatus == 'receivedStock') {
    $query .= " AND parts.MinimumAmount > 0";
} elseif ($selectedStockStatus == 'outOfStock') {
    $query .= " AND parts.MinimumAmount = 0";
}

$query .= " ORDER BY orders.DestinationWarehouseID ASC";

$result = $conn->query($query);

if (!$result) {
    echo "<tr><td colspan='7'>Error fetching data: " . $conn->error . "</td></tr>";
} else {
    // Populate the table with data
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['OrderItemID'] . "</td>";  // This is the ID from orderitems table
        echo "<td class='hidden'>" . $row['OrderID'] . "</td>";
        echo "<td class='hidden'>" . $row['DestinationWarehouseID'] . "</td>";
        echo "<td>" . $row['PartName'] . "</td>";
        echo "<td>" . $row['CurrentStock'] . "</td>";
        echo "<td>" . $row['TotalAmount'] . "</td>";

        // Display button only if the part has a batch number
        if ($row['BatchNumber']) {
            echo "<td><button onclick='viewBatchNumbers(" . $row['OrderItemID'] . ")'>View Batch Numbers</button></td>";
        } else {
            echo "<td>No Batch Number</td>";
        }

        echo "</tr>";
    }
}

// Close the database connection
$conn->close();
?>

<script>
function viewBatchNumbers(orderItemId) {
    // Make an AJAX request to fetch the batch number
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "fetch_batch_number.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Display the batch number in an alert
            alert("Batch Number: " + xhr.responseText);
        }
    };
    xhr.send("orderItemId=" + orderItemId);
}
</script>
