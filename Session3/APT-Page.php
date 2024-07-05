<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Session 3 - Asset Preventive Tasks</title>
        <link rel="icon" href="Pictures/dcsalogo.png" type="image/x-icon">
      <link rel="stylesheet" href="CSS/APT-CSS.css?v=<?php echo time(); ?>">
   </head>
   <?php
   
      // Create connection
      $conn = new mysqli("localhost", "root", "", "session3");
      
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
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
      
      ?>
      
   <body>
   <div class="session-container">
    <div class="container">
        <form id="SearchForm"><br>
            <div class="active-date-css">
               <label for="active-date">Active Date:</label>
               <input type="date" id="activedate-options" name="active-date" onchange="applyFilters()" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="apply-filters">
                <div class="item1">
                  <select id="asset-name-filter" onchange="applyFilters()">
                     <option value="">All Assets</option>
                     <?php foreach ($assetNames as $asset): ?>
                           <option value="<?php echo $asset['id']; ?>"><?php echo $asset['AssetName']; ?></option>
                     <?php endforeach; ?>
                  </select>
                </div>
                <div class="item2">
                  <select id="task-filter" onchange="applyFilters()">
                     <option value="">All Tasks</option>
                     <?php foreach ($taskNames as $task): ?>
                           <option value="<?php echo $task['ID']; ?>"><?php echo $task['Name']; ?></option>
                     <?php endforeach; ?>
                  </select>
                </div>
                <div class="item3">
                    <button type="button" onclick="clearFilters()">Clear Filter</button>
                </div>
            </div>
        </form>

            <?php
               
               // Create connection
               $conn = new mysqli("localhost", "root", "", "session3");
               
               // Check connection
               if ($conn->connect_error) {
                   die("Connection failed: " . $conn->connect_error);
               }
            
    // Retrieve selected date from GET parameters or use current date as default
    $selectedDate = $_GET['active-date'] ?? date('Y-m-d');

    // Fetch asset data from database
    $sql = "SELECT pmtasks.*, assets.AssetName AS AssetName, assets.AssetSN AS AssetSN, tasks.Name AS TaskName,
    CASE 
        WHEN pmtasks.PMScheduleTypeID = 2 THEN 'By Date'
        WHEN pmtasks.PMScheduleTypeID = 1 THEN 'By Mileage'
    END AS ScheduleType 
    FROM pmtasks
    JOIN assets ON pmtasks.AssetID = assets.ID
    JOIN tasks ON pmtasks.TaskID = tasks.ID
    WHERE (pmtasks.PMScheduleTypeID = 1 AND pmtasks.TaskDone = 0) -- Run-based active tasks not processed
        OR (pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate < '$selectedDate' AND pmtasks.TaskDone = 0) -- Time-based active tasks past due and not processed
        OR (pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate = '$selectedDate' AND pmtasks.TaskDone = 0) -- Time-based active tasks due on active date and not processed
        OR (pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate BETWEEN '$selectedDate' AND DATE_ADD('$selectedDate', INTERVAL 4 DAY) AND pmtasks.TaskDone = 0) -- Time-based active tasks due within four days after active date and not processed
        OR pmtasks.TaskDone = 1 -- Processed tasks
    ORDER BY
        CASE
            WHEN pmtasks.PMScheduleTypeID = 1 AND pmtasks.TaskDone = 0 THEN 1 -- Run-based active tasks
            WHEN pmtasks.PMScheduleTypeID = 1 AND pmtasks.TaskDone = 1 THEN 2 -- Run-based active tasks processed
            WHEN pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate < '$selectedDate' THEN 3 -- Time-based active tasks past due
            WHEN pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate = '$selectedDate' THEN 4 -- Time-based active tasks due on active date
            WHEN pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate BETWEEN '$selectedDate' AND DATE_ADD('$selectedDate', INTERVAL 4 DAY) THEN 5 -- Time-based active tasks due within four days after active date
            ELSE 6 -- Processed tasks
        END,
        pmtasks.ScheduleDate ASC"; 

    $result = $conn->query($sql);
            ?>

<div class="table-container">
    <p>Active Tasks:</p>
    <table style="border:1px solid black; width:100%;">
        <thead></thead>
        <tbody id="table-body">
            <?php
            $cellCount = 0; 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cellCount++;
            ?> 
            <tr class="<?php echo ($row['PMScheduleTypeID'] == 1 && $row['TaskDone'] == 0) ? 'run-based-task' : ''; ?><?php echo ($row['PMScheduleTypeID'] == 1 && $row['TaskDone'] == 1) ? 'run-based-task-processed' : ''; ?><?php echo ($row['PMScheduleTypeID'] == 2 && $row['TaskDone'] == 0 && $row['ScheduleDate'] < date('Y-m-d')) ? 'time-based-task-past-due' : ''; ?><?php echo ($row['PMScheduleTypeID'] == 2 && $row['TaskDone'] == 1 && $row['ScheduleDate'] < date('Y-m-d')) ? 'time-based-task-past-due-processed' : ''; ?><?php echo ($row['PMScheduleTypeID'] == 2 && $row['TaskDone'] == 0 && $row['ScheduleDate'] == date('Y-m-d')) ? 'time-based-task-active-date' : ''; ?><?php echo ($row['PMScheduleTypeID'] == 2 && $row['TaskDone'] == 1 && $row['ScheduleDate'] == date('Y-m-d')) ? 'time-based-task-active-date-processed' : ''; ?><?php echo ($row['ScheduleDate'] >= $selectedDate && $row['ScheduleDate'] <= date('Y-m-d', strtotime($selectedDate . ' +4 days'))) ? 'time-based-task-four-day-period' : ''; ?>">
                <td style="width:120px;text-align:center;">
                    <img src="pictures/assetpicture.png" height="60px" width="60px" style="margin: 10px 10px 10px 10px">
                </td>
                <td>
                    <?php 
                    echo $row['AssetName'] . '** SN:' . $row['AssetSN'] . '<br>'; // Display Asset Name and Asset SN
                    echo $row['TaskName'] . '<br>'; // Display Task Name
                    echo $row['ScheduleType'] . ' - at '; // Display Schedule Type

                    if ($row["ScheduleType"] == 'By Date') {
                        echo $row["ScheduleDate"];
                    } elseif ($row["ScheduleType"] == 'By Mileage') {
                        echo $row["ScheduleKilometer"] . ' kilometer';
                    }     
                    ?>
                </td>
                <td style="width:120px;text-align:center;">
                    <input type="checkbox" id="checkbox-options" <?php echo ($row["TaskDone"] == 1) ? 'checked' : ''; ?>>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='3'>No assets found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


        <p id="asset-total" style="margin-left:10px"><b><?php echo $cellCount; ?> assets from <?php echo $result->num_rows; ?></b></p>
            <?php
               $conn->close();
            ?>
         </div>
      </div>
      
      <div style="position:relative;">
        <div class="add-btn-container">
            <a href="RNPMT-Page.php"><button id="add-asset">+</button></a>
        </div>
      </div>

<script>
      document.querySelectorAll('.active-date input[type="date"]').forEach(function(input) {
      input.addEventListener('mousedown', function(event) {
      event.preventDefault();
      });
   });

function clearFilters() {
            document.getElementById("asset-name-filter").value = "";
            document.getElementById("task-filter").value = "";
            applyFilters();
        }

function applyFilters() {
    const assetNameInput = document.getElementById('asset-name-filter').value;
    const taskInput = document.getElementById('task-filter').value;
    const activedateInput = document.getElementById('activedate-options').value;

    // Construct the search query string
    let searchQuery = "search=true";
    if (assetNameInput) {
        searchQuery += "&asset-name=" + assetNameInput;
    }
    if (taskInput) {
        searchQuery += "&task-filter=" + taskInput;
    }
    if (activedateInput) {
        searchQuery += "&active-date=" + activedateInput;
    }

    // Send an AJAX request with the search query parameters
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table-body").innerHTML = this.responseText;
            var cellCountHeader = xhttp.getResponseHeader('X-Cell-Count');
            if (cellCountHeader !== null) {
                var assetTotalLabel = document.getElementById("asset-total");
                if (assetTotalLabel !== null) {
                    assetTotalLabel.innerHTML = "<b>" + cellCountHeader + " assets from <?php echo $result->num_rows; ?></b>";
                }
            }
        }
    };
    xhttp.open("GET", "ApplyFilters.php?" + searchQuery, true);
    xhttp.send();
}

</script>
</body>
</html>