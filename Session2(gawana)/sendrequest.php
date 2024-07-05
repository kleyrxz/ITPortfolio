<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session 2</title>

    <link rel="icon" href="pictures/dcsa.ico" type="image/x-icon">

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
            height: 610px;
            width: 950px;
            background-color: #72A0C1;
            border: 1px solid black;
            position: fixed;
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
            height: 100px;
            width: 900px;
            background-color: #B9D9EB;
            border: 1px solid black;
            position: relative;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;

        }

        .Getdata {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            position: relative;
            top: 5px;
            left: 50px;
        }

        .Getdata input {
            font-weight: bold;
            font-size: 15px;
            background: none;
        }

        .Getdata label {
            font-size: 14px;
        }

        .inside-container2 {
            height: 300px;
            width: 900px;
            background-color: #B9D9EB;
            border: 1px solid black;
            position: relative;
            top: 27%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
        }

        button {
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

        .Request {
            position: relative;
            top: 40px;
            left: 275px;
        }

        .Cancel {
            position: relative;
            left: 475px;
            top: 10px;
        }



        .Request button:hover {
            background-color: green;
            color: white;
        }

        .Cancel button:hover {
            background-color: red;
            color: white;
        }



        select {
            padding: 4px;
            font-size: 16px;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #333;
            width: 120px;
            border-radius: 10px;
            background-color: #E1EBEE;
        }

        select option {
            padding: 8px;
            font-size: 16px;
            background-color: #fff;
            color: #333;
            border-radius: 10px;
        }

        textarea {
            width: 675px;
            height: 80px;
            resize: none;
            margin-left: 108px;
            background-color: #E1EBEE;
            border-radius: 10px;
        }

        .inside-container1 input {
            border: 0;
            outline: none;
            cursor: default;
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

$thePriority = [];
$sqlthePriority = "SELECT id, name FROM priorities";
$resultThePriority = $conn->query($sqlthePriority);
if ($resultThePriority->num_rows > 0) {
    while ($row = $resultThePriority->fetch_assoc()) {
        $thePriority[] = $row;
    }
}

if (isset($_GET['AssetID'])) {
    $ID = $_GET['AssetID'];
    $sql = "SELECT emergencymaintenances.*, assets.* 
    FROM `assets` 
    LEFT JOIN `emergencymaintenances` ON assets.ID = emergencymaintenances.AssetID
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
        $PriorityID = $row['PriorityID'];
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
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $assetID = $_POST['AssetID'];
    $priorityID = $_POST['PriorityID'];
    $descriptionEmergency = $_POST['DescriptionEmergency']; 
    $otherConsiderations = $_POST['OtherDescription']; 
    $emReportDate = date('Y-m-d'); 
    $emStartDate = $emReportDate; 


    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "session2";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO emergencymaintenances (AssetID, PriorityID, DescriptionEmergency, OtherConsiderations, EMReportDate, EMStartDate) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $assetID, $priorityID, $descriptionEmergency, $otherConsiderations, $emReportDate, $emStartDate);

    if ($stmt->execute()) {
        echo "<script>alert('Successfully Send Request!')</script>";
        header("refresh:1;url=AssetsList.php");
        echo "<script> window.location.href = 'Assetslist.php' </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<body>

    <div class="container">
        <div class="Textcontainer">
            <h3>Selected Asset</h3>
        </div>
        <div class="inside-container1">
            <br><br>
            <form method="post">
                <div class="Getdata">
                    <input type="hidden" name="AssetID" value="<?php echo htmlspecialchars($_GET['AssetID']); ?>">
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
            <h3>Request Report</h3>
        </div>
        <div class="inside-container2">
            <div class="Textcontainer">
                <label for="prioritySelect">Select Priority:</label>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "session2";

                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $query = "SELECT ID, Name FROM priorities";

                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    echo '<select name="PriorityID" id="prioritySelect">';
                    echo '<option value="">---</option>'; 

                    while ($row = $result->fetch_assoc()) {

                        echo '<option value="' . $row['ID'] . '">' . $row['Name'] . '</option>';
                    }

                    echo '</select>';
                } else {

                    echo "No priorities found";
                }

                $conn->close();
                ?>
            </div> <br>

            <div class="Textcontainer">
                <label> Description of Emergency:</label>
                <textarea id="descriptionemergency" name="DescriptionEmergency" rows="4" cols="50"></textarea>
            </div><br>
            <div class="Textcontainer">
                <label> Other Description:</label>
                <textarea id="otherdescription" name="OtherDescription" rows="4" cols="50"></textarea>
            </div>
            <div class="Request">
                <button type="submit">Send Request</button>
            </div>
            <div class="Cancel">
                <button type="button" onclick="goToAssetList()">Cancel</button>
            </div>
        </div>

        </form>
        <script>
            function goToAssetList() {
                window.location.href = "Assetslist.php";
            }
        </script>



    </div>



</body>

</html>