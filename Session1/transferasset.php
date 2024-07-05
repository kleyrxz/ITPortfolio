<head>
    <link rel="stylesheet" href="css/transferasset.css">
</head>
<?php
// Database connection
include "connection/connection.php";


// Check connection
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

$assetGroups = [];
$sqlAssetGroups = "SELECT id, name FROM assetgroups";
$resultAssetGroups = $conn->query($sqlAssetGroups);
if ($resultAssetGroups->num_rows > 0) {
    while ($row = $resultAssetGroups->fetch_assoc()) {
        $assetGroups[] = $row;
    }
}

$locations = [];
$SqlLocations = "SELECT id, name FROM locations";
$resultlocations = $conn->query($SqlLocations);
if ($resultAssetGroups->num_rows > 0) {
    while ($row = $resultlocations->fetch_assoc()) {
        $locations[] = $row;
    }
}


$Employees = [];
$SqlEmployees = "SELECT id, firstname, lastname FROM employees";
$resultEmployees = $conn->query($SqlEmployees);
if ($resultAssetGroups->num_rows > 0) {
    while ($row = $resultEmployees->fetch_assoc()) {
        $Employees[] = $row;
    }
}


$query = "SELECT * FROM assets";
$result = mysqli_query($conn, $query);

if ($result) {
    // Get the number of rows
    $row_count = mysqli_num_rows($result);

    $row_count = $row_count + 1;
} else {
    echo "Error executing query: " . mysqli_error($conn);
}


///////////GET

if (isset($_GET['ID'])) {

    $ID = $_GET['ID'];

    $sql =  mysqli_query($conn, "SELECT departmentlocations.*, departments.*, assets.*
    FROM assets
    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
    JOIN departments ON departmentlocations.DepartmentID = departments.ID
    JOIN locations ON departmentlocations.LocationID = locations.ID
    WHERE assets.ID = $ID");

    $edit = mysqli_fetch_array($sql);
}



$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session 1</title>

</head>

<body>


    <!--Porttrait-->

    <div class="Porttrait">
        <form action="" id="myForm" method="post" enctype="multipart/form-data">
            <div class="container1">
                <div class="Assetinfo">
                    <div class="header">
                        <h4>Asset Transfer</h4>
                    </div>
                    <div class="header">
                        <a href="session1.php">Back</a>
                    </div>
                </div>

                <div class="line">
                    <label for="Asset">Selected Asset</label><br>
                    <hr>
                </div>
                <div class="container-input">
                    <div class="assetname">
                        <label for="Asset">Asset Name</label><br><br>
                        <input id="Asset" type="text" name="ID" value="<?php echo $edit['ID']; ?>" hidden>
                        <input id="Asset" type="text" name="AssetName" value="<?php echo $edit['AssetName']; ?>" disabled>
                    </div>
                    <div class="assetname">
                        <label for="Asset">Current Department</label><br><br>
                        <select name="DepartmentID" style="width: 100%;" disabled>
                            <option value="">Department</option>
                            <?php foreach ($departments as $department) : ?>
                                <option value="<?php echo $department["id"]; ?>" <?php if (isset($edit["DepartmentID"]) && $edit["DepartmentID"] == $department["id"]) {
                                                                                        echo "Selected";
                                                                                    } ?>> <?php echo $department["name"]; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="assetname">
                        <label for="Asset">Asset SN</label><br><br>
                        <input id="Asset" type="text" name="AssetName" value="<?php echo $edit['AssetSN']; ?>" disabled>
                    </div>
                </div>
                <div class="line">
                    <label for="Asset">Destination Department</label><br>
                    <hr>
                </div>
                <div class="container-input">
                    <div class="assetname">
                        <select name="DistinationDepartmentID" style="width: 100%;">
                            <option value="">Distination Department</option>
                            <?php foreach ($departments as $department) :
                                // remove from option
                                if (isset($edit["DepartmentID"]) && $edit["DepartmentID"] == $department["id"]) {
                                    continue;
                                }
                            ?>
                                <option value="<?php echo $department["id"]; ?>">
                                    <?php echo $department["name"]; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="assetname">
                        <select name="DistinationLocationID" style="width: 100%;">
                            <option value="">Distination Location</option>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="assetname">
                        <label for="Asset"> New Asset SN</label><br><br>
                        <input id="SN" name="AssetSN" type="text" placeholder="dd/gg/nnnn" disabled>
                    </div>
                </div>

                <div class="container-button">
                    <div class="button-list">
                        <div class="cursor"><a onclick="submitForm()">Submit</a></div>
                    </div>
                    <div class="button-list">
                        <a id="cancel" href="session1.php">Cancel</a>
                    </div>
                </div>

            </div>
        </form>


    </div>



</body>

<?php

include "connection/connection.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {



    //location of data
    $Department = $_POST['DistinationDepartmentID'];
    $LocationID = $_POST['DistinationLocationID'];
    $AssetGroupID = $edit['AssetGroupID'];


    $NewAssetSN = "0$Department/0$AssetGroupID/00$Department$AssetGroupID";


    $sql = "SELECT * FROM `departmentlocations` WHERE DepartmentID = $Department AND LocationID = $LocationID";
    $result = $conn->query($sql);

    if (!$result) {
        die("Failed to execute query: " . $conn->error);
    } elseif ($result->num_rows < 1) {

        $datetoday = date("Y-m-d");
        $sql = "INSERT INTO `departmentlocations`(`DepartmentID`,`LocationID`,`StartDate`) VALUES ('$Department', '$LocationID', '$datetoday')";
        $result = $conn->query($sql);


    }

    $locate = mysqli_query($conn, "SELECT * FROM `departmentlocations` WHERE DepartmentID = $Department AND LocationID = $LocationID");
    $forlocation = mysqli_fetch_array($locate);

    $NewDepartmentID = $forlocation['ID'];


    $sql = "UPDATE `assets` SET AssetSN = '$NewAssetSN', `DepartmentLocationID` = '$NewDepartmentID' WHERE `ID` = '$ID'";
    $result = $conn->query($sql);


    if ($result == TRUE) {

        //current
        $AssetID = $edit['ID'];
        $TransferDate = date('Y-m-d');
        $OldAssetSN = $edit['AssetSN'];
        $OldDepartmentID = $edit['DepartmentLocationID'];

        $sql = "INSERT INTO `assettransferlogs` (`AssetID`, `TransferDate`, `FromAssetSN`, `ToAssetSN`, `FromDepartmentLocationID`, `ToDepartmentLocationID`)
                VALUES('$AssetID', '$TransferDate', '$OldAssetSN', '$NewAssetSN', '$OldDepartmentID', '$NewDepartmentID')";
        $result = $conn->query($sql);


        if ($result == TRUE) {
            echo " <script> alert('Asset transfer successfully')</script>";
            echo "<script>window.location.href = 'session1.php'</script>";
        } else {

            echo "Error:" . $sql . "<br>" . $conn->error;
        }
    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}


?>


<script>
    //Submit

    function submitForm() {
        document.getElementById("myForm").submit();
    }

    /////////////
</script>

</html>