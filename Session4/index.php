<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Session 4</title>
      <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
        function removeItem(button) {
            var row = button.parentNode.parentNode;
            var orderItemId = row.firstElementChild.textContent.trim();

            if (confirm('Are you sure you want to remove this item?')) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "remove_item.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        if (xhr.responseText === 'success') {
                            row.parentNode.removeChild(row);
                        } else {
                            alert('Error removing item');
                        }
                    }
                };
                xhr.send("id=" + orderItemId);
            }
        }
    </script>
   </head>
   



   <body>

   <div class="container">
      <h4 style="margin-top:12px; margin-left:12px;">Inventory Management</h4>
      <div class="nav-bar">
        <button id="purchaseOrderButton"><span class="underline">P</span>urchase Order Management</button>
        <button id="warehouseManagerButton"><span class="underline">W</span>arehouse Management</button>
        <button id="inventoryReportButton"><span class="underline">I</span>nventory Report</button>
     </div>
         <div class="inside-container">
    <div class="table-container"> 
         <table id="myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Part Name</th>
                <th>Transaction Type</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
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

// SQL query to fetch data with sorting
$sql = "SELECT
            orderitems.ID AS ID,
            parts.Name AS PartName,
            transactiontypes.Name AS TransactionType,
            orders.Date AS Date,
            orderitems.Amount AS Amount,
            IFNULL(sourceWarehouse.Name, '') AS Source,
            IFNULL(destinationWarehouse.Name, '') AS Destination
        FROM
            orderitems
        JOIN
            parts ON orderitems.PartID = parts.ID
        JOIN
            orders ON orderitems.OrderID = orders.ID
        LEFT JOIN
            warehouses AS sourceWarehouse ON orders.SourceWarehouseID = sourceWarehouse.ID
        LEFT JOIN
            warehouses AS destinationWarehouse ON orders.DestinationWarehouseID = destinationWarehouse.ID
        JOIN
            transactiontypes ON orders.TransactionTypeID = transactiontypes.ID
        ORDER BY 
            CASE 
                WHEN transactiontypes.Name = 'Purchase Order' THEN 0
                ELSE 1
            END,
            orders.Date ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='display:none;'>" . $row["ID"] . "</td>";
        echo "<td>" . $row["PartName"] . "</td>";
        echo "<td>" . $row["TransactionType"] . "</td>";
        echo "<td>" . $row["Date"] . "</td>";
        if ($row["TransactionType"] === "Purchase Order") {
            echo "<td style='background-color: LimeGreen;'>" . $row["Amount"] . "</td>";
        } else {
            echo "<td>" . $row["Amount"] . "</td>";
        }
        echo "<td>" . $row["Source"] . "</td>";
        echo "<td>" . $row["Destination"] . "</td>";
        echo "<td><button id='editbutton'>Edit</button>
        <button onclick='removeItem(this)'>Remove</button></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>

                </tbody>
            </table>
</div>
        </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('th').click(function() {
            var table = $(this).parents('table').eq(0);
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
            this.asc = !this.asc;
            if (!this.asc) { rows = rows.reverse(); }
            for (var i = 0; i < rows.length; i++) { table.append(rows[i]); }
        });
        function comparer(index) {
            return function(a, b) {
                var valA = getCellValue(a, index), valB = getCellValue(b, index);
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
            };
        }
        function getCellValue(row, index) { return $(row).children('td').eq(index).text(); }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const purchaseOrderButton = document.getElementById('purchaseOrderButton');
    const warehouseManagerButton = document.getElementById('warehouseManagerButton');
    const inventoryReportButton = document.getElementById('inventoryReportButton');

    function goToPurchaseOrder() {
    // AJAX request to fetch the highest ID from the database
    $.ajax({
        url: 'get_highest_id.php', // PHP script to fetch the highest ID
        type: 'GET',
        success: function(data) {
            // Parse the response as an integer
            var highestId = parseInt(data);
            if (!isNaN(highestId)) {
                // Increment the highest ID by 1
                var nextId = highestId + 1;
                // Redirect to the purchase order page with the next ID in the URL
                window.location.href = 'purchaseorder.php?ID=' + nextId;
            } else {
                // Handle the case where the response is not a valid number
                console.error('Failed to parse highest ID from response: ' + data);
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX errors
            console.error('Error fetching highest ID: ' + error);
        }
    });
}
function goToWarehouseManager() {
    // AJAX request to fetch the highest ID from the database
    $.ajax({
        url: 'get_highest_id.php', // PHP script to fetch the highest ID
        type: 'GET',
        success: function(data) {
            // Parse the response as an integer
            var highestId = parseInt(data);
            if (!isNaN(highestId)) {
                // Increment the highest ID by 1
                var nextId = highestId + 1;
                // Redirect to the purchase order page with the next ID in the URL
                window.location.href = 'warehousemanager.php?ID=' + nextId;
            } else {
                // Handle the case where the response is not a valid number
                console.error('Failed to parse highest ID from response: ' + data);
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX errors
            console.error('Error fetching highest ID: ' + error);
        }
    });
}
    function goToInventoryReport() {
        window.location.href = 'inventoryreport.php';
    }
    // Handle button click
    purchaseOrderButton.addEventListener('click', goToPurchaseOrder);
    warehouseManagerButton.addEventListener('click', goToWarehouseManager);

    inventoryReportButton.addEventListener('click', goToInventoryReport);
    // Handle key press 
    document.addEventListener('keydown', function(event) {
        if (event.key === 'p' || event.key === 'P') {
            goToPurchaseOrder();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'w' || event.key === 'W') {
            goToWarehouseManager();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'i' || event.key === 'I') {
            goToInventoryReport();
        }
    });
});
</script>

</body>
</html>