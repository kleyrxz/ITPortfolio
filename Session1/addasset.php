<head>
    <link rel="stylesheet" href="css/addAtupdateasset.css">
</head>
<?php
// Database connection
include "connection/connection.php";

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
                        <input type="hidden" name="AssetID" value="<?php echo $row_count ?>">
                        <label for="Asset">Asset Name</label><br>
                        <input id="Asset" type="text" name="AssetName">
                    </div>
                </div>
                <div class="container-option">
                    <div class="option-list">
                        <select name="DepartmentID" style="width: 100%;">
                            <option value="">Department</option>
                            <?php foreach ($departments as $department) : ?>
                                <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="option-list">
                        <select name="LocationID" style="width: 100%;">
                            <option value="">Location</option>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="option-list">
                        <select name="AssetGroupID" style="width: 100%;">
                            <option value="">Asset Group</option>
                            <?php foreach ($assetGroups as $assetGroup) : ?>
                                <option value="<?php echo $assetGroup['id']; ?>"><?php echo $assetGroup['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="option-list">
                        <select name="EmployeeID" style="width: 100%;">
                            <option value="">Accountable Party</option>
                            <?php foreach ($Employees as $Employee) : ?>
                                <option value="<?php echo $Employee['id']; ?>"><?php echo $Employee['lastname']; ?>, <?php echo $Employee['firstname']; ?> </option>
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
                        <input id="ExWarranty" name="date" type="date">
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


        $AssetName = $_POST['AssetName'];

        $EmployeeID = $_POST['EmployeeID'];
        $AssetGroupID = $_POST['AssetGroupID'];
        $Description = $_POST['Description'];
        $WarrantyDate = $_POST['date'];
        $AssetID = $_POST['AssetID'];

        //location of data
        $Department = $_POST['DepartmentID'];
        $LocationID = $_POST['LocationID'];

        $AssetSN = "0$Department/0$AssetGroupID/00$Department$AssetGroupID";


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
        $DepartmentID = $forlocation['ID'];


        $sql = "INSERT INTO `assets`(`AssetSN`,`AssetName`,`DepartmentLocationID`,`EmployeeID`,`AssetGroupID`,`Description`,`WarrantyDate`) VALUES ('$AssetSN', '$AssetName', '$DepartmentID', '$EmployeeID', '$AssetGroupID', '$Description', '$WarrantyDate')";
        $result = $conn->query($sql);


        if ($result == TRUE) {
            echo " <script> alert('Inserted')</script>";
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