<head>
    <link rel="stylesheet" href="css/addAtupdateasset.css">
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




//yaawaa ibaa naman to


if (isset($_GET['ID'])) {

    $ID = $_GET['ID'];

    $sql =  mysqli_query($conn, "SELECT departmentlocations.*, departments.*, locations.*, assets.*
    FROM assets
    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
    JOIN departments ON departmentlocations.DepartmentID = departments.ID
    JOIN locations ON departmentlocations.LocationID = locations.ID
    WHERE assets.ID = $ID");

    $edit = mysqli_fetch_array($sql);
}



// Close connection
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
                        <h4>Asset Information</h4>
                    </div>
                    <div class="header">
                        <a href="session1.php">Back</a>
                    </div>
                </div>
                <div class="container-input">
                    <div class="assetname">
                        <label for="Asset">Asset Name</label><br>
                        <input id="Asset" type="text" name="ID" value="<?php echo $edit['ID']; ?>" hidden>
                        <input id="Asset" type="text" name="AssetName" value="<?php echo $edit['AssetName']; ?>">
                    </div>
                </div>
                <div class="container-option">
                    <div class="option-list">
                        <select name="DepartmentID" style="width: 100%;" disabled>
                            <option value="">Department</option>
                            <?php foreach ($departments as $department) : ?>
                                <option value="<?php echo $department["id"]; ?>" <?php if (isset($edit["DepartmentID"]) && $edit["DepartmentID"] == $department["id"]) {
                                                                                        echo "Selected";
                                                                                    } ?>> <?php echo $department["name"]; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="option-list">
                        <select name="LocationID" style="width: 100%;" disabled>
                            <option value="">Location</option>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo $location["id"]; ?>" <?php if (isset($edit["LocationID"]) && $edit["LocationID"] == $location["id"]) {
                                                                                    echo "Selected";
                                                                                } ?>> <?php echo $location["name"]; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="option-list">
                        <select name="AssetGroupID" style="width: 100%;" disabled>
                            <option value="">Asset Group</option>
                            <?php foreach ($assetGroups as $assetGroup) : ?>
                                <option value="<?php echo $assetGroup["id"]; ?>" <?php if (isset($edit["AssetGroupID"]) && $edit["AssetGroupID"] == $assetGroup["id"]) {
                                                                                        echo "Selected";
                                                                                    } ?>> <?php echo $assetGroup["name"]; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="option-list">
                        <select name="EmployeeID" style="width: 100%;">
                            <option value="">Accountable Party</option>
                            <?php foreach ($Employees as $Employee) : ?>
                                <option value="<?php echo $Employee["id"]; ?>" <?php if (isset($edit["EmployeeID"]) && $edit["EmployeeID"] == $Employee["id"]) {
                                                                                    echo "Selected";
                                                                                } ?>> <?php echo $Employee['lastname']; ?>, <?php echo $Employee['firstname']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                <div class="container-input">
                    <div class="assetname">
                        <label for="Description">Asset Descrition</label><br>
                        <textarea id="Description" name="Description" rows="4" cols="50" placeholder="Enter your text here..."></textarea>
                    </div>
                </div>

                <div class="container-date">
                    <div class="date-list">
                        <label for="ExWarranty">Expired Warranty:</label>
                    </div>
                    <div class="date-list">

                        <input id="ExWarranty" name="date" type="date" value="<?php echo $edit['WarrantyDate']; ?>">
                    </div>
                    <div class="date-list">
                        <label for="SN">Asset SN:</label>
                    </div>
                    <div class="date-list">
                        <input id="SN" name="AssetSN" type="text" placeholder="dd/gg/nnnn" disabled>
                    </div>
                </div>
                <div class="container-upload">
                    <div class="upload-list">
                        <label for="file-upload" class="file">Capture Image</label>
                        <input id="" type="file" name="" hidden>
                    </div>
                    <div class="upload-list">
                        <label for="file-upload" class="file">Browse</label>
                        <input id="file-upload" type="file" name="image" hidden accept="image/*">
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

    <?php

    include "connection/connection.php";



    if ($_SERVER["REQUEST_METHOD"] == "POST") {



        $ID = $_POST['ID'];

        $AssetName = $_POST['AssetName'];
        $EmployeeID = $_POST['EmployeeID'];
        $Description = $_POST['Description'];
        $WarrantyDate = $_POST['date'];


        $sql = "UPDATE `assets` SET AssetName = '$AssetName', `EmployeeID` = '$EmployeeID', `Description` = '$Description', `WarrantyDate` = '$WarrantyDate' WHERE `ID` = '$ID'";
        $result = $conn->query($sql);


        if ($result == TRUE) {
            echo " <script> alert('Data updated')</script>";
        } else {

            echo "Error:" . $sql . "<br>" . $conn->error;
        }
    }

    mysqli_close($conn);
    ?>

</body>




<script>
    //Submit

    function submitForm() {
        document.getElementById("myForm").submit();
    }

    /////////////
</script>

</html>