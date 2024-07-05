<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session 1</title>
    <link rel="stylesheet" href="css/session1.css">

    <style>
    .button1 {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
            background-color: #000000;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
            border-radius: 40px;
            position: absolute;
            top: 85%;
            left: 90%;
        }

        .button1:hover {
            background-color: #3a2828;
        }

        select {
            border: none;
            /* Remove the border */
            outline: none;

        }

        .container {
            padding-top: 10px;
            padding-left: 10px;


        }

        .Porttrait {
            display: flex;
            justify-content: center;

        }

        .Porttrait .container {
            background-color: white;
            border: 1px solid black;
            position: absolute;
            width: 470px;
            /* Default width */
            height: auto;
            display: none;
        }

        /* Landscape div to hide */
        .landscape {
            display: block;
            /* Set the default display property */
        }

        .landscape .container1 {
            background-color: white;
            border: 1px solid black;
            position: absolute;
            width: 98%;
            /* Default width */
            height: auto;
            display: block;
        }
    </style>


</head>
<?php

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

$conn->close();
?>


<div class="button1" onclick="Add()">
    <div>
        <p>Add</p>
    </div>
</div>

<body>
    <div class="Porttrait">
        <div class="container">
            <form method="post">
                <select name="department">
                    <option value="">Department</option>
                    <?php foreach ($departments as $department) : ?>
                        <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="assetgroups">
                    <option value="">Asset Group</option>
                    <?php foreach ($assetGroups as $assetGroup) : ?>
                        <option value="<?php echo $assetGroup['id']; ?>"><?php echo $assetGroup['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <button id="landscapeSwitch" hidden>Switch</button>


                <div>
                    <p>Warranty date range:</p>
                    <div class="date-range">
                        <label for="start-date">Starting Date:</label>
                        <input type="date" name="start-date">
                        <label for="end-date">End Date:</label>
                        <input type="date" name="end-date" onchange="performdateSearch()">
                    </div><br>
                </div>
                <div class="search-container">
                    <input type="text" name="search" class="search" placeholder="Search...">
                    <input type="submit" class="button" name="submit" value="Search">
                </div>
            </form>

            <?php
            include "connection/connection.php";

            $sql = "SELECT departmentlocations.*, departments.*, assets.*
            FROM assets
            JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
            JOIN departments ON departmentlocations.DepartmentID = departments.ID
            JOIN locations ON departmentlocations.LocationID = locations.ID";
            $result = $conn->query($sql);

            // Fetch asset data from database

            if (isset($_POST['submit'])) {

                if (isset($_POST['assetgroups']) && !empty($_POST['assetgroups'])) {
                    $selectedOption = $_POST['assetgroups'];
                    $sql = "SELECT departmentlocations.*, departments.*, assetgroups.*, assets.*
                    FROM assets
                    JOIN assetgroups ON assets.AssetGroupID = assetgroups.ID
                    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                    JOIN departments ON departmentlocations.DepartmentID = departments.ID
                    WHERE assetgroups.ID = $selectedOption";
                    $result = $conn->query($sql);
                }


                if (isset($_POST['department']) && !empty($_POST['department'])) {
                    $selectedOption = $_POST['department'];
                    $sql = "SELECT departmentlocations.*, departments.*, assets.*
                    FROM assets
                    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                    JOIN departments ON departmentlocations.DepartmentID = departments.ID
                    WHERE departments.ID = $selectedOption";
                    $result = $conn->query($sql);
                }

                if (isset($_POST['search']) && !empty($_POST['search'])) {
                    $name = $_POST['search'];
                    $sql = "SELECT departmentlocations.*, departments.*,assets.*
                    FROM assets
                    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                    JOIN departments ON departmentlocations.DepartmentID = departments.ID
                    WHERE LOWER(assets.AssetName) LIKE LOWER('%$name%')";
                    $result = $conn->query($sql);
                }

                if (isset($_POST['start-date']) && !empty($_POST['start-date'])) {

                    $startdate = $_POST['start-date'];
                    $enddate = $_POST['end-date'];

                    $sql = "SELECT departmentlocations.*, departments.*, assets.*
                    FROM assets
                    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                    JOIN departments ON departmentlocations.DepartmentID = departments.ID
                    WHERE departmentlocations.StartDate >= '$startdate'
                    AND departmentlocations.EndDate <= '$enddate' OR departmentlocations.StartDate >= '$startdate'";
                    $result = $conn->query($sql);
                }
            }
            include "connection/connection.php";

            $sql = "SELECT departmentlocations.*, departments.*, assets.*
            FROM assets
            JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
            JOIN departments ON departmentlocations.DepartmentID = departments.ID
            JOIN locations ON departmentlocations.LocationID = locations.ID";
            $result = $conn->query($sql);

            // Fetch asset data from database

            if (isset($_POST['submit'])) {

                if (isset($_POST['assetgroups']) && !empty($_POST['assetgroups'])) {
                    $selectedOption = $_POST['assetgroups'];
                    $sql = "SELECT departmentlocations.*, departments.*, assetgroups.*, assets.*
                    FROM assets
                    JOIN assetgroups ON assets.AssetGroupID = assetgroups.ID
                    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                    JOIN departments ON departmentlocations.DepartmentID = departments.ID
                    WHERE assetgroups.ID = $selectedOption";
                    $result = $conn->query($sql);
                }


                if (isset($_POST['department']) && !empty($_POST['department'])) {
                    $selectedOption = $_POST['department'];
                    $sql = "SELECT departmentlocations.*, departments.*, assets.*
                    FROM assets
                    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                    JOIN departments ON departmentlocations.DepartmentID = departments.ID
                    WHERE departments.ID = $selectedOption";
                    $result = $conn->query($sql);
                }

                if (isset($_POST['search']) && !empty($_POST['search'])) {
                    $name = $_POST['search'];
                    $sql = "SELECT departmentlocations.*, departments.*,assets.*
                    FROM assets
                    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                    JOIN departments ON departmentlocations.DepartmentID = departments.ID
                    WHERE LOWER(assets.AssetName) LIKE LOWER('%$name%')";
                    $result = $conn->query($sql);
                }

                if (isset($_POST['start-date']) && !empty($_POST['start-date'])) {

                    $startdate = $_POST['start-date'];
                    $enddate = $_POST['end-date'];

                    $sql = "SELECT departmentlocations.*, departments.*, assets.*
                    FROM assets
                    JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                    JOIN departments ON departmentlocations.DepartmentID = departments.ID
                    WHERE departmentlocations.StartDate >= '$startdate'
                    AND departmentlocations.EndDate <= '$enddate' OR departmentlocations.StartDate >= '$startdate'";
                    $result = $conn->query($sql);
                }
            }

            ?>

            <div class="table-container">
                <p>Asset List:</p>
                <table>
                    <thead>
                    </thead>
                    <tbody id="table-body">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td>
                                        <img src="file/Null-Item.png" height="60px" width="60px" style="margin: 10px 10px 10px 10px">
                                    </td>
                                    <td style="width:300px;">
                                        <?php echo $row['AssetName']; ?><br>
                                        <?php echo $row['Name']; ?><br>
                                        <div><?php echo $row['AssetSN']; ?></div>
                                        <input id="dates" type="text" value="<?php echo $row['WarrantyDate']; ?>" hidden>

                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <a href="updateasset.php?ID=<?php echo $row['ID']; ?>">&#9998;</a>
                                        <a href="transferasset.php?ID=<?php echo $row['ID']; ?>">&#9112;</a>
                                        <a href="Historytransfer.php?ID=<?php echo $row['ID']; ?>">&#9776;</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <label>No Assets Found.</label>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="landscape">
        <div class="container1">
            <div class="table-container">
                <p>My Asset List:</p>
                <hr>
                <table>
                    <thead>
                    </thead>
                    <tbody id="table-body">
                        <?php
                        include "connection/connection.php";

                        $sql = "SELECT departmentlocations.*, departments.*, assets.*
                        FROM assets
                        JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                        JOIN departments ON departmentlocations.DepartmentID = departments.ID
                        JOIN locations ON departmentlocations.LocationID = locations.ID";
                        $result = $conn->query($sql);

                        // Fetch asset data from database

                        if (isset($_POST['submit'])) {

                            if (isset($_POST['assetgroups']) && !empty($_POST['assetgroups'])) {
                                $selectedOption = $_POST['assetgroups'];
                                $sql = "SELECT departmentlocations.*, departments.*, assetgroups.*, assets.*
                                FROM assets
                                JOIN assetgroups ON assets.AssetGroupID = assetgroups.ID
                                JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                                JOIN departments ON departmentlocations.DepartmentID = departments.ID
                                WHERE assetgroups.ID = $selectedOption";
                                $result = $conn->query($sql);
                            }


                            if (isset($_POST['department']) && !empty($_POST['department'])) {
                                $selectedOption = $_POST['department'];
                                $sql = "SELECT departmentlocations.*, departments.*, assets.*
                                FROM assets
                                JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                                JOIN departments ON departmentlocations.DepartmentID = departments.ID
                                WHERE departments.ID = $selectedOption";
                                $result = $conn->query($sql);
                            }

                            if (isset($_POST['search']) && !empty($_POST['search'])) {
                                $name = $_POST['search'];
                                $sql = "SELECT departmentlocations.*, departments.*,assets.*
                                FROM assets
                                JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                                JOIN departments ON departmentlocations.DepartmentID = departments.ID
                                WHERE LOWER(assets.AssetName) LIKE LOWER('%$name%')";
                                $result = $conn->query($sql);
                            }

                            if (isset($_POST['start-date']) && !empty($_POST['start-date'])) {

                                $startdate = $_POST['start-date'];
                                $enddate = $_POST['end-date'];

                                $sql = "SELECT departmentlocations.*, departments.*, assets.*
                                FROM assets
                                JOIN departmentlocations ON assets.DepartmentLocationID = departmentlocations.ID
                                JOIN departments ON departmentlocations.DepartmentID = departments.ID
                                WHERE departmentlocations.StartDate >= '$startdate'
                                AND departmentlocations.EndDate <= '$enddate' OR departmentlocations.StartDate >= '$startdate'";
                                $result = $conn->query($sql);
                            }
                        }

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td class="td1">
                                        <img src="file/Null-Item.png" height="60px" width="60px" style="margin: 10px 10px 10px 10px">
                                    </td>
                                    <td class="td2">
                                        <?php echo $row['AssetName']; ?> - <?php echo $row['AssetSN']; ?>
                                    </td>
                                    <td class="edit">
                                        <a href="updateasset.php?ID=<?php echo $row['ID']; ?>">&#9998;</a>
                                        <a href="transferasset.php?ID=<?php echo $row['ID']; ?>">&#9112;</a>
                                        <a href="Historytransfer.php?ID=<?php echo $row['ID']; ?>">&#x2630;</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <label>No Assets Found.</label>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function Add() {
            window.location.href = "addasset.php";
        }
        document.addEventListener("DOMContentLoaded", function() {
            const sessionContainer = document.querySelector(".Porttrait .container");
            const landscapeDiv = document.querySelector(".landscape");

            function toggleElementsBasedOnOrientation() {
                if (window.matchMedia("(orientation: portrait)").matches) {
                    sessionContainer.style.display = "none";
                    landscapeDiv.style.display = "block";
                    console.log("landscape");
                } else {
                    sessionContainer.style.display = "block";
                    landscapeDiv.style.display = "none";
                    console.log("portrait");
                }
            }
            toggleElementsBasedOnOrientation();
            window.addEventListener("orientationchange", function() {
                toggleElementsBasedOnOrientation();
            });
        });
    </script>
</body>

</html>