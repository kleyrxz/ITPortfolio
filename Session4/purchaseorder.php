<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Session 4</title>
      <link rel="stylesheet" href="css/style1.css?v=<?php echo time(); ?>">
      <link rel="icon" href="pictures/dcsa.ico" type="image/x-icon">
   </head>

   <body>
    <form method="post">
      <div class="container">
        <div class="title-container">
      <h4 style="margin-top:8px;margin-left: 10px;">Purchase Order</h4>
        </div>
        <div class="inside-container1">
            <label>Suppliers:</label>
            <label style="margin-left:300px">Warehouse:</label> <br>

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

// SQL query to fetch data from suppliers table
$sql = "SELECT ID, Name FROM suppliers";
$result = $conn->query($sql);

// Start the HTML output
echo '<select name="supplier">';

// Check if the query returned any rows
if ($result->num_rows > 0) {
    // Loop through each row and create an option element
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row["ID"] . '">' . $row["Name"] . '</option>';
    }
} else {
    echo '<option value="">No suppliers found</option>';
}

// End the HTML output
echo '</select>';

// Close the database connection
$conn->close();
?>

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

// SQL query to fetch data from warehouses table
$sql = "SELECT ID, Name FROM warehouses";
$result = $conn->query($sql);

// Start the HTML output
echo '<select name="warehouse" style="margin-left: 100px;">';

// Check if the query returned any rows
if ($result->num_rows > 0) {
    // Loop through each row and create an option element
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row["ID"] . '">' . $row["Name"] . '</option>';
    }
} else {
    echo '<option value="">No warehouses found</option>';
}

// End the HTML output
echo '</select>';

// Close the database connection
$conn->close();
?>

<br><br>
<label>Date:</label>
<input type="date" id="datePost" name="datePost" style="margin-left: 11px; width: 225px;" required>
        </div>

        <div class="inside-container2">
        <label>&nbsp Part Name:</label>
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

// SQL query to fetch data from the 'parts' table
$sql = "SELECT ID, Name FROM parts";
$result = $connection->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    echo '<select name="parts" id="parts">'; // Start select element
    while ($row = $result->fetch_assoc()) {
        // Output an option for each row in the result set
        echo '<option value="' . $row['ID'] . '">' . $row['Name'] . '</option>';
    }
    echo '</select>'; // End select element
} else {
    echo "0 results"; // Output if no rows are found
}

// Close connection
$connection->close();
?>

<label>Batch Number</label>
<input type="text" id="batchNumberResult" name="batchNumberResult" style="width:100px;" maxlength="8" disabled>
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#parts').change(function() {
        var partId = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'fetch_batch_number_status.php',
            data: { id: partId },
            success: function(response) {
                if (response == 0) {
                    $('#batchNumberResult').prop('disabled', true);
                    $('#batchNumberResult').val('');
                } else {
                    $('#batchNumberResult').prop('disabled', false);
                }
            }
        });
    });
});
</script>
<label style="margin-left:13px;">Amount:</label>
<input type="number" name="amount" style="width: 50px;" id="amount">
<input type="button" value="+ Add to List" style="margin-left: 50px;" onclick="addToTable()">


<table id="partTable">
    <thead>
        <tr>
            <th class="hidden">ID</th>
            <th>Part Name</th>
            <th>Batch Number</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
    </div>

<br><br><br><br><br><br><br>
    <input type="hidden" id="partDataInput" name="partData">
    <button type="submit" style="margin-left: 285px;" id="request">Submit</button>
    <button type="button" style="margin-left: 10px; " id="cancel"  header="Location: index.php;">Cancel</button>

      </div>

<script>
document.getElementById("cancel").addEventListener("click", function() {
    window.location.href = "index.php";
});

var partData = []; // Array to store part IDs and amounts

function addToTable() {
    // Get selected part ID, name, and amount
    var partSelect = document.querySelector('select[name="parts"]');
    var partId = partSelect.value; // PartID from the value attribute
    var batchNumber = document.querySelector('input[name="batchNumberResult"]').value;
    var partName = partSelect.options[partSelect.selectedIndex].textContent; // Part name from the selected option's text content
    var amount = document.querySelector('input[name="amount"]').value;

    // Log the row data to the console
    console.log("Part ID: " + partId + ", BatchNumber: " + batchNumber + ", Amount: " + amount);
    
    // Push the part ID and amount to the array
    partData.push({ partId: partId, batchNumber: batchNumber, amount: amount });
    
    // Get table body
    var tableBody = document.querySelector('#partTable tbody');
    
    // Create new row
    var newRow = document.createElement('tr');
    
    // Create cells for part ID, name, and amount
    var partIdCell = document.createElement('td');
    partIdCell.textContent = partId;
    partIdCell.style.display = 'none';
    var partNameCell = document.createElement('td');
    partNameCell.textContent = partName;
    var batchNumberCell = document.createElement('td');
    batchNumberCell.textContent = batchNumber;
    var amountCell = document.createElement('td');
    amountCell.textContent = amount;
    
    // Create delete button cell
    var deleteCell = document.createElement('td');
    var deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.addEventListener('click', function() {
        // Remove the row when delete button is clicked
        newRow.remove();
        // Remove the deleted row data from partData array
        partData.splice(partData.findIndex(row => row.partId === partId), 1);
        // Update the hidden input field with the updated partData array
        document.getElementById('partDataInput').value = JSON.stringify(partData);
    });
    deleteCell.appendChild(deleteButton);
    
    // Append cells to new row
    newRow.appendChild(partIdCell);
    newRow.appendChild(partNameCell);
    newRow.appendChild(batchNumberCell);
    newRow.appendChild(amountCell);
    newRow.appendChild(deleteCell);
    
    // Append new row to table body
    tableBody.appendChild(newRow);

    // Update the hidden input field with the updated partData array
    document.getElementById('partDataInput').value = JSON.stringify(partData);
    // Clear the input fields
    document.querySelector('input[name="batchNumberResult"]').value = '';
    document.querySelector('input[name="amount"]').value = '';
}

</script>
</form>
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $date = $_POST['datePost'];
    $supplier = $_POST['supplier'];
    $warehouse = $_POST['warehouse'];

    // Decode the JSON string into an associative array
    $partData = json_decode($_POST['partData'], true);

    // Check if decoding was successful
    if ($partData === null) {
        // Handle the error (e.g., invalid JSON string)
        echo "Error decoding JSON data.";
    } else {
        // Insert query for orders table
        $insertOrderQuery = "INSERT INTO orders (TransactionTypeID, SupplierID, DestinationWarehouseID, Date) 
                            VALUES (1, $supplier, $warehouse, '$date')";

        // Execute the insert query for orders table
        $insertOrderResult = $connection->query($insertOrderQuery);
        if (!$insertOrderResult) {
            echo "Error inserting data into orders table: " . $connection->error;
        } else {
            // Get the ID of the inserted order
            $orderId = $connection->insert_id;

            // Iterate over each part in the $partData array
            foreach ($partData as $part) {
                // Access partId and amount for each part
                $partID = $part['partId'];
                $batchNumber = $part['batchNumber'];
                $amount = $part['amount'];

                // Insert query for orderitems table
                $insertQuery = "INSERT INTO orderitems (OrderID, PartID, BatchNumber, Amount) 
                                VALUES ($orderId, $partID, '$batchNumber', $amount)";

                // Execute the insert query for orderitems table
                $insertResult = $connection->query($insertQuery);
                if (!$insertResult) {
                    echo "Error inserting data into orderitems table: " . $connection->error;
                }
            }

            // Redirect to index.php if successful
            echo '<script>alert("Request successfully managed. Redirecting back to the table.");</script>';
            echo '<script>window.location.href = "index.php";</script>';
            exit();
        }
    }
}

// Close connection
$connection->close();
?>




</body>
</html>