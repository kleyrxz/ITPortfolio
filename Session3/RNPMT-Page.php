<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Session 3 - Registering New Preventive Maintenance Tasks</title>
        <link rel="icon" href="Pictures/dcsalogo.png" type="image/x-icon">
      <link rel="stylesheet" href="CSS/RNPMT-CSS.css?v=<?php echo time(); ?>">
    </head>    
<?php

      // Create connection
      $conn = new mysqli("localhost", "root", "", "session3");
      
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      
    // Delete Asset
    if (isset($_POST['deleteAsset'])) {
        $assetID = $_POST['assetID'];
        $sql = "DELETE FROM assets WHERE ID = $assetID";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Are you sure you want to discard creating the asset?')</script>";
        } else {
            // Error deleting asset
        }
    }

      // Fetch asset names from the database
      $assetNames = array();
      $sqlAssetNames = "SELECT id, AssetName FROM assets";
      $resultAssetNames = $conn->query($sqlAssetNames);
      if ($resultAssetNames->num_rows > 0) {
         while ($row = $resultAssetNames->fetch_assoc()) {
            $assetNames[] = $row;
         }
      }

      // Fetch task names from the database
      $taskNames = array();
      $sqlTaskNames = "SELECT ID, Name FROM tasks";
      $resultTaskNames = $conn->query($sqlTaskNames);
      if ($resultTaskNames->num_rows > 0) {
         while ($row = $resultTaskNames->fetch_assoc()) {
            $taskNames[] = $row;
         }
      }
      
      // Fetch task names from the database
      $scheduleModels = array();
      $sqlScheduleModels = "SELECT ID, Name FROM pmschedulemodels";
      $resultScheduleModels = $conn->query($sqlScheduleModels);
      if ($resultScheduleModels->num_rows > 0) {
         while ($row = $resultScheduleModels->fetch_assoc()) {
            $scheduleModels[] = $row;
         }
      }
      
    function generateAssetSN($conn) {
        $sql = "SELECT AssetSN FROM assets 
        WHERE DepartmentLocationID = 13 AND AssetGroupID = 5 
        ORDER BY AssetSN DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result(); 
        if ($result->num_rows == 0) {
            $serialNumber = "0001";
        } else {
            $row = $result->fetch_assoc();
            $lastSerialNumber = $row['AssetSN'];
            $lastSerialNumber = substr($lastSerialNumber, 8); 
            $lastSerialNumber = intval($lastSerialNumber); 
            $serialNumber = sprintf("%04d", $lastSerialNumber + 1); 
        } 
        return $serialNumber;
    }
             
    if (isset($_POST['submit'])) {
        $AssetID = $_POST['AssetID'];
        $TaskID = $_POST['TaskID']; 
        $PMScheduleTypeID = isset($_POST['PMScheduleTypeID']) ? $_POST['PMScheduleTypeID'] : '';
        $ScheduleDate = isset($_POST['ScheduleDate']) ? $_POST['ScheduleDate'] : '';
        $ScheduleKilometer = isset($_POST['ScheduleKilometer']) ? $_POST['ScheduleKilometer'] : '';
        $ReadDate = isset($_POST['ReadDate']) ? $_POST['ReadDate'] : '';
        $OdometerAmount = isset($_POST['OdometerAmount']) ? $_POST['OdometerAmount'] : '';
        $TaskDone = "0";
    
        echo "Submitted PMScheduleTypeID: " . $PMScheduleTypeID . "<br>";
        echo "Submitted ScheduleDate: " . $ScheduleDate . "<br>";
        echo "Submitted ScheduleKilometer: " . $ScheduleKilometer . "<br>";
    
        if ($PMScheduleTypeID == 1) {
            $sql = "INSERT INTO assetodometers (AssetID, ReadDate, OdometerAmount) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $AssetID, $ReadDate, $OdometerAmount);
            $stmt->execute();
            $result = $stmt->get_result();

            $sql = "INSERT INTO pmtasks (AssetID, TaskID, PMScheduleTypeID, ScheduleDate, ScheduleKilometer, TaskDone) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiissi", $AssetID, $TaskID, $PMScheduleTypeID, $ScheduleDate, $ScheduleKilometer, $TaskDone);
            
            if ($stmt->execute()) {
                echo "<script>alert('Record inserted successfully');</script>";
            } else {
                echo "PMScheduleTypeID: " . $PMScheduleTypeID . "<br>";
                echo "ScheduleDate: " . $ScheduleDate . "<br>";
                echo "ScheduleKilometer: " . $ScheduleKilometer . "<br>";
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        } else if ($PMScheduleTypeID == 2) {
            $sql = "INSERT INTO pmtasks (AssetID, TaskID, PMScheduleTypeID, ScheduleDate, ScheduleKilometer, TaskDone) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiissi", $AssetID, $TaskID, $PMScheduleTypeID, $ScheduleDate, $ScheduleKilometer, $TaskDone);
            $stmt->execute();
            
            if ($stmt->execute()) {
                echo "<script>alert('Record inserted successfully');</script>";
            } else {
                echo "PMScheduleTypeID: " . $PMScheduleTypeID . "<br>";
                echo "ScheduleDate: " . $ScheduleDate . "<br>";
                echo "ScheduleKilometer: " . $ScheduleKilometer . "<br>";
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        }
    }
    
$conn->close();
?>

<body>
<div class="session-container">
    <div class="container">
        <div class="top-bar">
            <span class="title-topbar">
                <h3><label>Registering New Preventive Maintenance Tasks</label></h3>
            </span>
            <span class="back-button">
                <button onclick="confirmDiscard()">Back</button>
            </span>
        </div>
        <div class="function-containers" style="padding:20px"><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <!-- Task Name Dropdown -->
                <select id="taskNameSelect" name="TaskID" onchange="updateTaskName()">
                    <option value="">Task Name</option>
                    <?php foreach ($taskNames as $taskName1): ?>
                        <option value="<?php echo $taskName1['ID']; ?>"><?php echo $taskName1['Name']; ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <input id="tasknameSelected" type="text" name="TaskID" style="display:none;">

                <!-- Asset Name Dropdown -->
                <div class="dropdown">
                    <select id="assetNameSelect" name="AssetID" onchange="enableInput(this)">
                        <option value="">Asset Name</option>
                        <option value="other">Create New Asset...</option>
                        <?php foreach ($assetNames as $assetName1): ?>
                            <option value="<?php echo $assetName1['id']; ?>"><?php echo $assetName1['AssetName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" id="addAssetBtn" style="color:#59A1EB;background-color:white;border:none;display:none;cursor:pointer;" onclick="addAsset()">Add to List</button>
                    <input id="adding-assets" type="text" name="assetName" style="display:none;">
                    <input id="assetNameSelected" type="text" name="AssetID" style="display:none;">
                </div><br>

                <!-- Schedule Model Dropdown -->
                <div class="SMdropdown">
                    <select id="schedule-model" name="GetPMScheduleTypeID" onchange="toggleScheduleFieldsAndClearInputs()">
                        <option value="">Schedule Models</option>
                        <?php foreach ($scheduleModels as $model): ?>
                            <option value="<?php echo $model['ID']; ?>"><?php echo $model['Name']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="button" id="up-down-button1" onclick="openScheduleFields()" style="display:none;">...</button>
                    <input id="schedmodelSelected" type="text" name="PMScheduleTypeID" style="display:none;">
                    <input id="schedDateSelected" type="text" name="ScheduleDate" style="display:none;">
                    <input id="schedKiloSelected" type="text" name="ScheduleKilometer" style="display:none;">
                    <input id="readDateSelected" type="text" name="ReadDate" style="display:none;">
                    <input id="odometerSelected" type="text" name="OdometerAmount" style="display:none;">

                    <div id="schedule-fields" style="display: none;">
                        <button type="button" id="up-down-button2" onclick="closeScheduleFields()">X</button>
                        
                        <div id="daily-interval" style="display: none;">
                            <label for="daily-interval-days">Interval (Days):</label><br>
                            <input type="number" id="daily-interval-days" name="daily-interval-days" oninput="updateDailyEndDate()"><br><br>
                            <div class="item1">
                                <label for="start-date-daily" style="margin-left:10px;">Starting Date:</label><br>
                                <input type="date" id="start-date-daily" name="start-date-daily" value="<?php echo date('Y-m-d'); ?>" disabled>
                                <br><br>
                            </div>
                            <div class="item2">
                                <label for="end-date-daily">End Date:</label><br>
                                <input type="date" id="end-date-daily" name="end-date-daily" disabled>
                                <br><br>
                            </div>
                        </div>

                        <div id="weekly-interval" style="display: none;">
                            <label for="weekly-interval-day">Day of the Week:</label><br>
                            <select id="weekly-interval-day" name="weekly-interval-day" onchange="updateWeeklyEndDate()">
                                <option value="0">Sunday</option>
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
                            </select><br><br>
                            <label for="weekly-interval-weeks">Interval (Weeks):</label><br>
                            <input type="number" id="weekly-interval-weeks" name="weekly-interval-weeks" oninput="updateWeeklyEndDate()"><br><br>
                            <div class="item1">
                                <label for="start-date-weekly" style="margin-left:10px;">Starting Date:</label><br>
                                <input type="date" id="start-date-weekly" name="start-date-weekly" value="<?php echo date('Y-m-d'); ?>" disabled>
                                <br><br>
                            </div>
                            <div class="item2">
                                <label for="end-date-weekly">End Date:</label><br>
                                <input type="date" id="end-date-weekly" name="end-date-weekly" disabled>
                                <br><br>
                            </div>
                        </div>

                        <div id="monthly-interval" style="display: none;">
                            <label for="monthly-interval-day">Day of the Month:</label><br>
                            <input type="number" id="monthly-interval-day" name="monthly-interval-day" oninput="updateMonthlyEndDate()"><br><br>
                            <label for="monthly-interval-months">Interval (Months):</label><br>
                            <input type="number" id="monthly-interval-months" name="monthly-interval-months" oninput="updateMonthlyEndDate()"><br><br>
                            <div class="item1">
                                <label for="start-date-monthly" style="margin-left:10px;">Starting Date:</label><br>
                                <input type="date" id="start-date-monthly" name="start-date-monthly" value="<?php echo date('Y-m-d'); ?>" disabled>
                                <br><br>
                            </div>
                            <div class="item2">
                                <label for="end-date-monthly">End Date:</label><br>
                                <input type="date" id="end-date-monthly" name="end-date-monthly" disabled>
                                <br><br>
                            </div>
                        </div>
                        
                        <div id="kilometer-interval" style="display: none;">
                            <label for="start-odometer-reading">Start Odometer Reading:</label><br>
                            <input type="number" id="start-odometer-reading" name="start-odometer-reading"><br><br>
                            <label for="end-odometer-reading">End Odometer Reading:</label><br>
                            <input type="number" id="end-odometer-reading" name="end-odometer-reading"><br><br>
                            <label for="kilometer-interval">Interval (Kilometers):</label><br>
                            <input type="number" id="run-based-interval-kilometers" name="run-based-interval-kilometers" oninput="updateRunBasedEndDate()"><br><br>
                            <div class="item1">
                                <label for="start-date-run-based" style="margin-left:10px;">Starting Date:</label><br>
                                <input type="date" id="start-date-run-based" name="start-date-run-based" value="<?php echo date('Y-m-d'); ?>" disabled>
                                <br><br>
                            </div>
                            <div class="item2">
                                <label for="end-date-run-based">End Date:</label><br>
                                <input type="date" id="end-date-run-based" name="end-date-run-based" disabled>
                                <br><br>
                            </div>
                        </div>
                    </div><br><br>
                    
                    <?php // Footer Buttons ?>
                    <div class="footer-buttons">
                        <input type="submit" name="submit" value="Submit" style="margin-right:10px;">
                        <input type="button" onclick="confirmDiscard()" value="Cancel">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        var TaskName = document.getElementById("taskNameSelected");
        var AssetName = document.getElementById("assetNameSelected");
        var ScheduleModel = document.getElementById("schedmodelSelected");

        if (TaskName.value == "") {
            alert("Please select an option from the Task Names.");
            return false;
        }

        if (AssetName.value == "" || AssetName.value == "other") {
            alert("Please select an option from the Asset Names.");
            return false;
        }
        
        return true;
    }

    function updateTaskName() {
        var selectElement = document.getElementById("taskNameSelect");
        var selectedValue = selectElement.value;
        console.log("Selected option:", selectedValue);
        document.getElementById("tasknameSelected").value = selectedValue;
    }

    function toggleScheduleFieldsAndClearInputs() {
        var model = document.getElementById("schedule-model").value;
        var scheduleFields = document.getElementById("schedule-fields");
        var scheduleValueInput = document.getElementById("schedmodelSelected");
        var scheduleDateInput = document.getElementById("schedDateSelected");
        var readDateInput = document.getElementById("readDateSelected");
        var scheduleKilometerInput = document.getElementById("schedKiloSelected");
        
        document.getElementById("daily-interval").style.display = "none";
        document.getElementById("weekly-interval").style.display = "none";
        document.getElementById("monthly-interval").style.display = "none";
        document.getElementById("kilometer-interval").style.display = "none";

        clearScheduleInputs();
        scheduleDateInput.value = '';
        readDateInput.value = '';
        scheduleKilometerInput.value = '';

        if (model === "") {
            scheduleFields.style.display = "none";
        } else {
            scheduleFields.style.display = "block";
        }
        
        if (model === "1") {
            document.getElementById("daily-interval").style.display = "block";
            document.getElementById("up-down-button1").style.display = "none";
            document.getElementById("up-down-button2").style.display = "block";
            scheduleValueInput.value = '2';
        } else if (model === "2") {
            document.getElementById("weekly-interval").style.display = "block";
            document.getElementById("up-down-button1").style.display = "none";
            document.getElementById("up-down-button2").style.display = "block";
            scheduleValueInput.value = '2';
        } else if (model === "3") {
            document.getElementById("monthly-interval").style.display = "block";
            document.getElementById("up-down-button1").style.display = "none";
            document.getElementById("up-down-button2").style.display = "block";
            scheduleValueInput.value = '2';
        } else if (model === "4") {
            document.getElementById("kilometer-interval").style.display = "block";
            document.getElementById("up-down-button1").style.display = "none";
            document.getElementById("up-down-button2").style.display = "block";
            scheduleValueInput.value = '1';
        } else {
            document.getElementById("up-down-button1").style.display = "none";
            document.getElementById("schedule-fields").style.display = "none";
            scheduleValueInput.value = '';
        }
    }

    function clearScheduleInputs() {
        document.querySelectorAll('#schedule-fields input[type="number"]').forEach(input => {
            input.value = '';
        });
        document.querySelectorAll('#schedule-fields select').forEach(input => {
            input.value = 0;
        });
    }

    function openScheduleFields() {
        document.getElementById("schedule-fields").style.display = "block";
        document.getElementById("up-down-button1").style.display = "none";
        document.getElementById("up-down-button2").style.display = "block";
    }

    function closeScheduleFields() {
        document.getElementById("schedule-fields").style.display = "none";
        document.getElementById("up-down-button1").style.display = "";
        document.getElementById("up-down-button2").style.display = "none";
    }

    function updateDailyEndDate() {
        var startDate = new Date(document.getElementById("start-date-daily").value);
        var intervalDays = parseInt(document.getElementById("daily-interval-days").value);
        var scheduleDateInput = document.getElementById("schedDateSelected");
        
        if (!isNaN(intervalDays)) {
            var endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + intervalDays);
            document.getElementById("end-date-daily").value = endDate.toISOString().substr(0, 10);
            scheduleDateInput.value = document.getElementById("end-date-daily").value = endDate.toISOString().substr(0, 10);
        }
    }

    function updateWeeklyEndDate() {
        var startDate = new Date(document.getElementById("start-date-weekly").value);
        var intervalWeeks = parseInt(document.getElementById("weekly-interval-weeks").value);
        var scheduleDateInput = document.getElementById("schedDateSelected");

        if (!isNaN(intervalWeeks)) {
            var endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + (intervalWeeks * 7));
            document.getElementById("end-date-weekly").value = endDate.toISOString().substr(0, 10);
            scheduleDateInput.value = document.getElementById("end-date-daily").value = endDate.toISOString().substr(0, 10);
        }
    }

    function updateMonthlyEndDate() {
        var startDate = new Date(document.getElementById("start-date-monthly").value);
        var intervalMonths = parseInt(document.getElementById("monthly-interval-months").value);
        var scheduleDateInput = document.getElementById("schedDateSelected");

        if (!isNaN(intervalMonths)) {
            var endDate = new Date(startDate);
            endDate.setMonth(startDate.getMonth() + intervalMonths);
            document.getElementById("end-date-monthly").value = endDate.toISOString().substr(0, 10);
            scheduleDateInput.value = document.getElementById("end-date-daily").value = endDate.toISOString().substr(0, 10);
        }
    }

    // Add this function to calculate the end date for run-based tasks
    function updateRunBasedEndDate() {
        var startOdometerReading = parseInt(document.getElementById("start-odometer-reading").value);
        var endOdometerReading = parseInt(document.getElementById("end-odometer-reading").value);
        var intervalKilometers = parseInt(document.getElementById("run-based-interval-kilometers").value);
        var readDateInput = document.getElementById("readDateSelected");
        var scheduleKilometerInput = document.getElementById("schedKiloSelected");
        var odometerAmountInput = document.getElementById("odometerSelected");

        if (!isNaN(startOdometerReading) && !isNaN(endOdometerReading) && !isNaN(intervalKilometers)) {
            var kilometersTravelled = endOdometerReading - startOdometerReading;
            var endDate = new Date();
            endDate.setDate(endDate.getDate() + (kilometersTravelled / intervalKilometers));
            document.getElementById("end-date-run-based").value = endDate.toISOString().substr(0, 10);
            readDateInput.value = endDate.toISOString().substr(0, 10);
            scheduleKilometerInput.value = intervalKilometers;
            odometerAmountInput.value = endOdometerReading + startOdometerReading;
        }
    }

    function enableInput(select) {
        var inputBox = document.getElementById("adding-assets");
        var addAssetBtn = document.getElementById("addAssetBtn");

        if (select.value == 'other') {
            inputBox.style.display = 'block';
            addAssetBtn.style.display = 'inline-block';
            inputBox.focus();
        } else {
            inputBox.style.display = 'none';
            addAssetBtn.style.display = 'none';
            var selectElement = document.getElementById("assetNameSelect");
            var selectedValue = selectElement.value;
            console.log("Selected option:", selectedValue);
            document.getElementById("assetNameSelected").value = selectedValue;
        }
    }

    function addAsset() {
    var assetName = document.getElementById("adding-assets").value;

    if (!assetName) {
        alert("Please enter an asset name.");
        return;
    }

    // Create an XMLHttpRequest object
    var xhttp = new XMLHttpRequest();

    // Define the function to handle the response
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText); // Alert the response from the PHP script
            location.reload(); // Reload the page after adding the asset
        }
    };

    // Open a POST request to the PHP script
    xhttp.open("POST", "AddingAsset.php", true);

    // Set the Content-Type header
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Send the request with the assetName as data
    xhttp.send("assetName=" + assetName);
}


    function confirmDiscard() {
        var result = confirm("Are you sure you want to go back?");
        if (result) {
            window.location.href = "APT-Page.php";
        }
    }
</script>
</body>
</html>