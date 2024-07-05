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
            top: 50%;
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
            margin-top: 1px;
            width: 100%;
            font-size: small;
            border-collapse: collapse;
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

        tr#ZeroNum {
            background-color: red;
            color: white;
        }
    </style>



</head>



<body>

    <div class="container">
        <div class="Textcontainer">
            <h2>Available Assets</h2>
        </div>
        <div class="inside-container">
            <table id="myTable">
                <thead>
                    <tr>
                        <th>Asset SN</th>
                        <th>Asset Name</th>
                        <th>Last Closed EM</th>
                        <th>Number of EMs</th>
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
            assets.ID,
            assets.AssetSN,
            assets.AssetName,
            MAX(emergencymaintenances.EMEndDate) AS LastClosedEM,
            COUNT(DISTINCT emergencymaintenances.ID) AS NumberOfEMs
            FROM 
            assets
            LEFT JOIN 
            emergencymaintenances ON assets.ID = emergencymaintenances.AssetID
            GROUP BY 
            assets.ID, assets.AssetSN, assets.AssetName";

                    $result = $connection->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row["NumberOfEMs"] == 0) {
                                echo "<tr id='ZeroNum'>";
                                foreach ($row as $key => $value) {
                                    echo "<td>" . $value . "</td>";
                                }
                                echo "</tr>";
                            } else {
                                echo "<tr>";
                                foreach ($row as $value) {
                                    echo "<td>" . $value . "</td>";
                                }
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='5'>0 results</td></tr>";
                    }

                    $connection->close();
                    ?>
                </tbody>
            </table>
        </div>
        <div class="Request">
            <button id="sendRequestButton" type="button">Send Emergency Maintenance Request</button>
        </div>
        <div class="Out">
            <a href="Login.php"><button>Sign-Out</button></a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rows = document.querySelectorAll("#myTable tbody tr");
            const manageRequestButton = document.getElementById("sendRequestButton");

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
                    window.location.href = "sendrequest.php?AssetID=" + encodeURIComponent(selectedId);
                } else {
                    alert("Please select a row before sending the request.");
                }
            });
        });
    </script>


</body>

</html>