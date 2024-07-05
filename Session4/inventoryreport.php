<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Session 4</title>
      <link rel="stylesheet" href="css/style2.css?v=<?php echo time(); ?>">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   </head>

   <body>

      <div class="container">
        <div class="title-container">
      <h4 style="margin-top:8px;margin-left: 10px;">Inventory Report</h4>
        </div>
        <div class="inside-container1">
        <label>Warehouse:</label>
        <label style="margin-left:300px">Inventory Type</label>
            <br>
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

    // SQL query to fetch data from warehouses table sorted by ID and Name
    $sql = "SELECT ID, Name FROM warehouses ORDER BY ID ASC, Name ASC";
    $result = $conn->query($sql);

    // Start the HTML output for the select element
    echo '<select name="warehouse" id="warehouseSelect">';
    
    // Add a separator line
    echo '<option value="">----------------</option>';
    
    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Loop through each row and create an option element
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["ID"] . '">' . $row["Name"] . '</option>';
        }
    } else {
        echo '<option value="">No warehouses found</option>';
    }
    
    // End the HTML output for the select element
    echo '</select>';
    
    // Close the database connection
    $conn->close();
    ?>

        <input type="radio" id="currentStock" name="stockStatus" value="currentStock" style="margin-left:110px;" checked>
        <label for="currentStock">Current Stock</label>
        
        <input type="radio" id="receivedStock" name="stockStatus" value="receivedStock" style="margin-left:10px;">
        <label for="receivedStock">Received Stock</label>
        
        <input type="radio" id="outOfStock" name="stockStatus" value="outOfStock" style="margin-left:10px;">
        <label for="outOfStock">Out of Stock</label>
<br><br>
<label>Result:</label>
        </div>

        <div class="inside-container2">
    <div class="table-container">
    <table id="inventoryTable">
        <thead>
            <tr>
                <th class='hidden'>ID</th>
                <th class='hidden'>OrderID</th>
                <th class='hidden'>WarehouseID</th>
                <th>Part Name</th>
                <th>Current Stock</th>
                <th>Received Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         
        </tbody>
    </table>
    <script>
    $(document).ready(function() {
        // Function to fetch and display data based on the selected warehouse
        function fetchTableData(warehouseID) {
            $.ajax({
                url: 'fetch_filtered_data.php', // URL to the PHP script
                type: 'POST',
                data: { warehouseID: warehouseID },
                success: function(data) {
                    $('#inventoryTable tbody').html(data); // Populate the table body with the returned data
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data: ' + error);
                }
            });
        }

        // Fetch initial data without any warehouse filter
        fetchTableData('');

        // Event listener for the warehouse select element
        $('#warehouseSelect').change(function() {
            var selectedWarehouseID = $(this).val();
            fetchTableData(selectedWarehouseID);
        });
    });
    </script>

    </div>

</div>
<button type="button" style="margin-left: 48px; margin-top: 330px; " id="cancel"  header="Location: index.php;">Cancel</button>
<script>
document.getElementById("cancel").addEventListener("click", function() {
    window.location.href = "index.php";
});
</script>
<script>
function viewBatchNumbers(partId) {
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
    xhr.send("partId=" + partId);
}
</script>

<script>
    $(document).ready(function() {
        function fetchTableData(warehouseID, stockStatus) {
            $.ajax({
                url: 'fetch_filtered_data.php',
                type: 'POST',
                data: { warehouseID: warehouseID, stockStatus: stockStatus },
                success: function(data) {
                    $('#inventoryTable tbody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data: ' + error);
                }
            });
        }

        // Fetch initial data without any warehouse filter
        fetchTableData('', 'currentStock');

        // Event listener for the warehouse select element
        $('#warehouseSelect').change(function() {
            var selectedWarehouseID = $(this).val();
            var selectedStockStatus = $('input[name="stockStatus"]:checked').val();
            fetchTableData(selectedWarehouseID, selectedStockStatus);
        });

        // Event listener for the stock status radio buttons
        $('input[name="stockStatus"]').change(function() {
            var selectedWarehouseID = $('#warehouseSelect').val();
            var selectedStockStatus = $(this).val();
            fetchTableData(selectedWarehouseID, selectedStockStatus);
        });
    });
    </script>

</div>

</div>



</body>
</html>