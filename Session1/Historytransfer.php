<head>
    <link rel="stylesheet" href="css/historytransfer.css">
</head>
<?php
// Database connection
include "connection/connection.php";




// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session 1</title>
    <link rel="stylesheet" href="css/4.css">

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

            position: absolute;
            top: 85%;
            left: 90%;
        }

        .button1:hover {
            background-color: #3a2828;
        }
    </style>

</head>

<body>

    <div class="landscape">
        <div class="container1">
            <?php
            // Database connection
            include "connection/connection.php";

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if (isset($_GET['ID'])) {

                $ID = $_GET['ID'];

                // Fetch asset data from database
                $sql = "SELECT departmentlocations.*, departments.Name As deparmentName , locations.Name As locationName, assettransferlogs.*, assets.*
                FROM assets
                JOIN assettransferlogs ON Assets.ID = assettransferlogs.AssetID
                JOIN departmentlocations ON assettransferlogs.FromDepartmentLocationID = departmentlocations.ID
                JOIN departments ON departmentlocations.DepartmentID = departments.ID
                JOIN locations ON departmentlocations.LocationID = locations.ID
                WHERE assets.ID = $ID
                ORDER BY `assettransferlogs`.`ID` ASC";
                $result = $conn->query($sql);

                $sql2 = "SELECT departmentlocations.*, departments.Name As deparmentName , locations.Name As locationName, assettransferlogs.*, assets.*
                FROM assets
                JOIN assettransferlogs ON Assets.ID = assettransferlogs.AssetID
                JOIN departmentlocations ON assettransferlogs.ToDepartmentLocationID = departmentlocations.ID
                JOIN departments ON departmentlocations.DepartmentID = departments.ID
                JOIN locations ON departmentlocations.LocationID = locations.ID
                WHERE assets.ID = $ID
                ORDER BY `assettransferlogs`.`ID` ASC";
                $result2 = $conn->query($sql2);
            }

            ?>



            <div class="table-container">
                <p>Transfer History</p>
                <hr>
                <table>
                    <thead>
                    </thead>
                    <tbody id="table-body">
                        <?php
                        if ($result->num_rows > 0 && $result2->num_rows > 0) {
                            while (($row = $result->fetch_assoc()) && ($row2 = $result2->fetch_assoc())) {
                        ?>
                                <tr>
                                    <td class="td1">
                                        <p style="font-size: 40px; text-align: center; ">&#128203;</p>
                                    </td>
                                    <td class="td2">
                                        <div>Relocation date: <?php echo $row2['TransferDate']; ?> </div>
                                        <div> <?php echo $row['deparmentName']; ?>, <?php echo $row['locationName']; ?> - <?php echo $row['FromAssetSN']; ?></div>
                                        <div> <?php echo $row2['deparmentName']; ?>, <?php echo $row2['locationName']; ?> - <?php echo $row2['ToAssetSN']; ?></div>
                                    </td>

                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                    </tbody>
                    <label>No Assets Found.</label>
                </table>
            </div>

        <?php }
                        // Close connection
                        $conn->close();
        ?>
        </tbody>
        </table>
        </div>


        <div class="button1" onclick="back()">
            <div>
                <p>back</p>
            </div>
        </div>


    </div>


</body>

<script>
    function back() {
        window.location.href = "session1.php";
    }
</script>

</html>