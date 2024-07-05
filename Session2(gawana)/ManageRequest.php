<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session 2</title>


    <style>
        * {
            user-select: none;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            height: 100vh;
            margin: 0;
        }


        .container {
            height: 710px;
            width: 950px;
            background-color: #72A0C1;
            border: 1px solid black;
            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
        }

        .Textcontainer {
            position: relative;
            left: 20px;
            top: 10px;

        }

        .inside-container1 {
            height: 50px;
            width: 900px;
            background-color: #B9D9EB;
            border: 3px solid whitesmoke;
            position: relative;
            top: 5%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;

        }

        .Getdata {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            position: relative;
            top: 15px;
            left: 50px;
        }

        .Getdata input {
            font-weight: bold;
            font-size: 14px;
            background: none;
        }

        .Getdata label {
            font-size: 13px;
        }

        .inside-container1 input {
            border: 0;
            outline: none;
            cursor: default;
        }

        .inside-container2 {
            height: 200px;
            width: 900px;
            background-color: #B9D9EB;
            border: 3px solid whitesmoke;
            position: relative;
            top: 15%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
            margin-top: 10px;
        }

        .EMreport {
            display: grid;
            grid-template-columns: 45% 50%;
            gap: 20px;
            padding-bottom: 10px;
        }

        .inside-container3 {
            height: 200px;
            width: 900px;
            background-color: #B9D9EB;
            border: 3px solid whitesmoke;
            position: relative;
            top: 16%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .upper {
            padding-bottom: 20px;
        }

        .Button button {
            display: inline-block;
            padding: 7px 17px;
            background-color: white;
            text-align: center;
            text-decoration: none;
            border: 1px solid whitesmoke;
            cursor: pointer;
            width: 150px;
            border-radius: 10px;

        }

        .request button:hover {
            background-color: green;
            color: white;
        }

        .cancel button:hover {
            background-color: red;
            color: white;
        }


        .request {
            position: relative;
            top: 20px;
            left: 315px;
        }

        .cancel {
            position: relative;
            top: -10px;
            left: 515px;
        }

        .scroll-table {
            width: 100%;
            border-collapse: collapse;
            font-size: small;
            border-radius: 10px;

        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;

        }

        th {
            background-color: #002147;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }


        tr.selected {
            background-color: lightblue;
        }

        select {
            padding: 4px;
            font-size: 12px;
            border: 1px solid #ccc;
            background-color: #E1EBEE;
            color: #333;
            width: 280px;
            border-radius: 10px;
        }

        select option {
            padding: 8px;
            font-size: 12px;
            color: #333;

        }

        textarea {
            padding-top: 10px;
            width: 740px;
            height: 80px;
            resize: none;
            margin-left: 108px;
            border-radius: 10px;
            background-color: #E1EBEE;
        }

        input[type="date"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            width: 200px;
        }


        .hidden {
            display: none;
        }

        .upper input[type="button"] {
            background-color: #4CAF50;
            color: white;
            padding: 5px 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }
        .upper input[type="button"]:hover {
            background-color: #45a049;

        }

        a {
            cursor: pointer;
            text-decoration: underline;
            color: blue;
        }
    </style>


</head>

<?php
$conn = new mysqli("localhost", "root", "", "session2");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$departments = [];
$sqlDepartments = "SELECT id, name FROM departments";
$resultDepartments = $conn->query($sqlDepartments);
if ($resultDepartments->num_rows > 0) {
    while ($row = $resultDepartments->fetch_assoc()) {
        $departments[] = $row;
    }
}

$departmentlocs = [];
$sqlDepartmentlocs = "SELECT id, name FROM locations";
$resultDepartmentlocs = $conn->query($sqlDepartmentlocs);
if ($resultDepartmentlocs->num_rows > 0) {
    while ($row = $resultDepartmentlocs->fetch_assoc()) {
        $departmentlocs[] = $row;
    }
}

$theParts = [];
$sqltheParts = "SELECT id, name FROM parts";
$resultTheParts = $conn->query($sqltheParts);
if ($resultTheParts->num_rows > 0) {
    while ($row = $resultTheParts->fetch_assoc()) {
        $theParts[] = $row;
    }
}

if (isset($_GET['AssetID'])) {
    $ID = $_GET['AssetID'];
    $sql = "SELECT emergencymaintenances.*, assets.*, changedparts.* 
    FROM `assets` 
    LEFT JOIN `emergencymaintenances` ON assets.ID = emergencymaintenances.AssetID
    LEFT JOIN `changedparts` ON emergencymaintenances.ID = changedparts.EmergencyMaintenanceID
    WHERE assets.ID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $AssetSN = $row['AssetSN'];
        $AssetName = $row['AssetName'];
        $DepartmentLocationID = $row['DepartmentLocationID'];
        $Amount = $row['Amount'];
        $PartID = $row['PartID'];
        $EMStartDate = $row['EMStartDate'];
        $EMReportDate = $row['EMReportDate'];
        $EMEndDate = $row['EMEndDate'];
        $DescriptionEmergency = $row['DescriptionEmergency'];
        $OtherConsiderations = $row['OtherConsiderations'];
        $sql = "SELECT * FROM `departmentlocations` WHERE `ID`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $DepartmentLocationID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $DepartmentID = $row['DepartmentID'];
            $LocationID = $row['LocationID'];
        }
    }
}
?>

<body>

    <div class="container">
        <div class="Textcontainer">
            <h4>Selected Asset:</h4>
        </div>
        <div class="inside-container1">
            <div class="Getdata">
                <div class="griddata">
                    <label>Asset SN:</label>
                    <input type="text" name="asset_sn" id="asset_sn" value="<?php echo $AssetSN; ?>" readonly>
                </div>
                <div class="griddata">
                    <label>Asset Name:</label>
                    <input type="text" name="asset_name" id="asset_name" value="<?php echo $AssetName; ?>" readonly>
                </div>
                <div class="griddata">
                    <label>Department:</label>
                    <?php
                    foreach ($departments as $departmentSel) {
                        if ($departmentSel['id'] == $DepartmentID) {
                            $departmentName = $departmentSel['name'];
                            break;
                        }
                    } ?>
                    <input type="text" name="asset_department" id="asset_department" value="<?php echo $departmentName; ?>" readonly>
                </div>
            </div>
        </div>

        <div class="Textcontainer">
            <h4>Asset EM Report:</h4>
        </div>

        <div class="inside-container2">
            <form method="post">

                <div class="EMreport">
                    <div class="Textcontainer">
                        <label for="prioritySelect">Start Date:</label>
                        <input type="date" id="startDate" name="date" value="<?php echo $EMStartDate; ?>" readonly>
                    </div>
                    <div class="Textcontainer">
                        <label for="prioritySelect" style="margin-left:100px;"> Completed On:</label>
                        <input type="date" id="endDate" name="endDate">
                    </div>
                </div>
                <div class="Textcontainer">
                    <label for="prioritySelect">Technician Note:</label>
                </div><br>
                <textarea id="technicianNote" name="technicianNote" rows="4" cols="50"></textarea>
        </div>
        <div class="Textcontainer">
            <h4>Replacement Parts:</h4>
        </div>
        <div class="inside-container3">
            <div class="Textcontainer">
                <div class="upper">
                    <label>Part Name:</label>

                    <?php

                    $servername = "localhost";
                    $username = "root"; 
                    $password = ""; 
                    $database = "Session2";

                    $connection = new mysqli($servername, $username, $password, $database);

                    if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                    }

                    $sql = "SELECT ID, Name FROM parts";
                    $result = $connection->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<select name="parts">';
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['ID'] . '">' . $row['Name'] . '</option>';
                        }
                        echo '</select>'; 
                    } else {
                        echo "0 results";
                    }

                    $connection->close();
                    ?>

                    <label style="margin-left:20px;">Amount:</label>
                    <input type="number" name="amount" style="width: 100px;" id="amount" value="1">
                    <input type="button" value="+ Add to List" style="margin-left: 50px;" onclick="addToTable()">

                </div>


            </div>
            <table id="partTable" class="scroll-table">
                <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th>Part Name</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>

        </div>

        <div class="Button">
            <input type="hidden" id="partDataInput" name="partData">
            <div class="request">
                <button type="submit" id="request">Submit</button>
            </div>
            <div class="cancel">
                <button type="button" id="cancel" header="Location: ListRequest.php;">Cancel</button>
            </div>
        </div>
        </form>

    </div>


    <script>
        document.getElementById("cancel").addEventListener("click", function() {

            window.location.href = "ListRequest.php";
        });
        var partData = []; 
        function addToTable() {

            var partSelect = document.querySelector('select[name="parts"]');
            var partId = partSelect.value; 
            var partName = partSelect.options[partSelect.selectedIndex].textContent; 
            var amount = document.querySelector('input[name="amount"]').value;

            console.log("Part ID: " + partId + ", Amount: " + amount);

            partData.push({
                partId: partId,
                amount: amount
            });

            var tableBody = document.querySelector('#partTable tbody');
            var newRow = document.createElement('tr');
            var partIdCell = document.createElement('td');
            partIdCell.textContent = partId;
            partIdCell.style.display = 'none';
            var partNameCell = document.createElement('td');
            partNameCell.textContent = partName;
            var amountCell = document.createElement('td');
            amountCell.textContent = amount;
            var deleteCell = document.createElement('td');
            var deleteButton = document.createElement('a');
            deleteButton.textContent = 'Delete';
            deleteButton.addEventListener('click', function() {
                newRow.remove();
                partData.splice(partData.findIndex(row => row.partId === partId), 1);
                document.getElementById('partDataInput').value = JSON.stringify(partData);
            });
            deleteCell.appendChild(deleteButton);
            newRow.appendChild(partIdCell);
            newRow.appendChild(partNameCell);
            newRow.appendChild(amountCell);
            newRow.appendChild(deleteCell);
            tableBody.appendChild(newRow);
            document.getElementById('partDataInput').value = JSON.stringify(partData);
        }
    </script>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "session2";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_GET['ID'];

        $endDate = $_POST['endDate'];
        $formattedEndDate = date("Y/m/d", strtotime($endDate)); 
        $technicianNote = $_POST['technicianNote'];

        $updateQuery = "UPDATE emergencymaintenances SET EMEndDate = '$formattedEndDate', EMTechnicianNote = '$technicianNote' WHERE ID = $id";

        $updateResult = $connection->query($updateQuery);
        if (!$updateResult) {
            echo "Error updating emergencymaintenances table: " . $connection->error;
        }

        $partData = json_decode($_POST['partData'], true);

        if ($partData === null) {
            echo "Error decoding JSON data.";
        } else {
            foreach ($partData as $part) {
                $partID = $part['partId'];
                $amount = $part['amount'];


                $insertQuery = "INSERT INTO changedparts (EmergencyMaintenanceID, PartID, Amount) VALUES ($id, $partID, $amount)";


                $insertResult = $connection->query($insertQuery);
                if (!$insertResult) {
                    echo "Error inserting data into changeparts table: " . $connection->error;
                }
            }
            echo '<script>alert("Request successfully managed. Redirecting back to the table.");</script>';
            echo '<script>window.location.href = "ListRequest.php";</script>';
            exit();
        }
    }

    $connection->close();
    ?>



</body>

</html>