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
            height: 600px;
            width: 900px;
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

        .inside-container {
            height: 450px;
            width: 800px;
            background-color: #B9D9EB;
            border: 3px solid whitesmoke;
            position: fixed;
            top: 48%;
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
            border-radius: 10px;
        }

        .Request {
            position: relative;
            top: 480px;
            left: 50px;
        }

        .Out {
            position: relative;
            top: 450px;
            left: 762px;
        }

        .Request button:hover {
            background-color: green;
            color: white;
        }

        .Out button:hover {
            background-color: red;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: small;
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            border: none;
        }

        td:first-child {
            display: none;
        }

        th {
            background-color: #f2f2f2;
        }

        tr.selected {
            background-color: lightseagreen;
            color: black;
        }

        .hidden {
            display: none;
        }
    </style>

</head>



<body>

    <div class="container">
        <div class="Textcontainer">
            <h3>List of Assets Requesting EM:</h3>
        </div>
        <div class="inside-container">
            <table id="myTable">
                <thead>
                    <tr>
                        <th>Asset SN</th>
                        <th>Asset Name</th>
                        <th>Request Date</th>
                        <th>Employee Full Name</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost"; 
                    $username = "root";
                    $password = ""; 
                    $database = "Session2";

                    $connection = new mysqli($servername, $username, $password, $database);
                    if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                    }
                    $sql = "SELECT 
            emergencymaintenances.ID AS ID,
            emergencymaintenances.AssetID AS AssetID,
            assets.AssetSN AS AssetSN,
            assets.AssetName AS AssetName,
            emergencymaintenances.EMReportDate AS RequestDate,
            CONCAT(employees.FirstName, ' ', employees.LastName) AS EmployeeFullName,
            departments.Name AS Department
        FROM 
            emergencymaintenances
        JOIN 
            assets ON emergencymaintenances.AssetID = assets.ID
        JOIN 
            employees ON emergencymaintenances.ID = employees.ID
        JOIN 
            departments ON employees.ID = departments.ID
        WHERE 
            emergencymaintenances.EMEndDate IS NULL";
                    $result = $connection->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo '<td class="hidden">' . $row["ID"] . '</td>';
                            echo '<td class="hidden">' . $row["AssetID"] . "</td>";
                            echo "<td>" . $row["AssetSN"] . "</td>";
                            echo "<td>" . $row["AssetName"] . "</td>";
                            echo "<td>" . $row["RequestDate"] . "</td>";
                            echo "<td>" . $row["EmployeeFullName"] . "</td>";
                            echo "<td>" . $row["Department"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>0 results</td></tr>";
                    }
                    $connection->close();
                    ?>
                </tbody>
            </table>
        </div>
        <div class="Request">
            <button id="manageRequestButton" type="button">Manage Request</button>
        </div>
        <div class="Out">
            <a href="Login.php"><button>Sign-Out</button></a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rows = document.querySelectorAll("#myTable tbody tr");
            const manageRequestButton = document.getElementById("manageRequestButton");

            rows.forEach(row => {
                row.addEventListener("click", () => {
                    rows.forEach(r => r.classList.remove("selected"));
                    row.classList.add("selected");
                });
            });

            manageRequestButton.addEventListener("click", function() {
                const selectedRow = document.querySelector("#myTable tbody tr.selected");
                if (selectedRow) {
                    const selectedId = selectedRow.querySelector("td:first-child").innerText; 
                    const selectedAssetId = selectedRow.querySelector("td:nth-child(2)").innerText; 
                    window.location.href = "ManageRequest.php?ID=" + encodeURIComponent(selectedId) + "&AssetID=" + encodeURIComponent(selectedAssetId);
                } else {
                    alert("Please select a row before sending the request.");
                }
            });
        });
    </script>



</body>

</html>