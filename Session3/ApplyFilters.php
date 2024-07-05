<?php
// Database connection
$host = 'localhost'; // Your host
$username = 'root'; // Your database username
$password = ''; // Your database password
$database = 'session3'; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve filter values from $_GET array
$assetName = $_GET['asset-name'] ?? '';
$taskFilter = $_GET['task-filter'] ?? '';
$activeDate = $_GET['active-date'] ?? '';

// Construct SQL query for searching with applied filters
$sql = "SELECT pmtasks.*, 
        assets.AssetName AS AssetName, 
        assets.AssetSN AS AssetSN, 
        tasks.Name AS TaskName,
        CASE 
            WHEN pmtasks.PMScheduleTypeID = 2 THEN 'By Date'
            WHEN pmtasks.PMScheduleTypeID = 1 THEN 'By Mileage'
        END AS ScheduleType 
        FROM pmtasks
        JOIN assets ON pmtasks.AssetID = assets.ID
        JOIN tasks ON pmtasks.TaskID = tasks.ID
        WHERE 1";

// Add filter conditions
if (!empty($assetName)) {
    $sql .= " AND assets.ID = $assetName";
}
if (!empty($taskFilter)) {
    $sql .= " AND tasks.ID = $taskFilter";
}

// Add conditions for active date and task status
$sql .= " AND (
                (pmtasks.PMScheduleTypeID = 1 AND pmtasks.TaskDone = 0) -- Run-based active tasks not processed
                OR (pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate < '$activeDate' AND pmtasks.TaskDone = 0) -- Time-based active tasks past due and not processed
                OR (pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate = '$activeDate' AND pmtasks.TaskDone = 0) -- Time-based active tasks due on active date and not processed
                OR (pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate BETWEEN '$activeDate' AND DATE_ADD('$activeDate', INTERVAL 4 DAY) AND pmtasks.TaskDone = 0) -- Time-based active tasks due within four days after active date and not processed
                OR pmtasks.TaskDone = 1 AND pmtasks.ScheduleDate < '$activeDate' -- Processed tasks
            )";

// Order the results as per the instructions
$sql .= " ORDER BY
            CASE
                WHEN pmtasks.PMScheduleTypeID = 1 AND pmtasks.TaskDone = 0 THEN 1 -- Run-based active tasks
                WHEN pmtasks.PMScheduleTypeID = 1 AND pmtasks.TaskDone = 1 THEN 2 -- Run-based active tasks processed
                WHEN pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate < '$activeDate' THEN 3 -- Time-based active tasks past due
                WHEN pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate = '$activeDate' THEN 4 -- Time-based active tasks due on active date
                WHEN pmtasks.PMScheduleTypeID = 2 AND pmtasks.ScheduleDate BETWEEN '$activeDate' AND DATE_ADD('$activeDate', INTERVAL 4 DAY) THEN 5 -- Time-based active tasks due within four days after active date
                ELSE 6 -- Processed tasks
            END,
            pmtasks.ScheduleDate ASC";

// Execute the query
$result = $conn->query($sql);

// Generate HTML markup for search results
$html = '';
$cellCount = 0; // Initialize cell count
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cellCount++;
        // Construct HTML for each row
        $html .= "<tr class=\"";
        $html .= ($row['PMScheduleTypeID'] == 1 && $row['TaskDone'] == 0) ? 'run-based-task' : '';
        $html .= ($row['PMScheduleTypeID'] == 1 && $row['TaskDone'] == 1) ? ' run-based-task-processed' : '';
        $html .= ($row['PMScheduleTypeID'] == 2 && $row['TaskDone'] == 0 && $row['ScheduleDate'] < date('Y-m-d')) ? ' time-based-task-past-due' : '';
        $html .= ($row['PMScheduleTypeID'] == 2 && $row['TaskDone'] == 1 && $row['ScheduleDate'] < date('Y-m-d')) ? ' time-based-task-past-due-processed' : '';
        $html .= ($row['PMScheduleTypeID'] == 2 && $row['TaskDone'] == 0 && $row['ScheduleDate'] == date('Y-m-d')) ? ' time-based-task-active-date' : '';
        $html .= ($row['PMScheduleTypeID'] == 2 && $row['TaskDone'] == 1 && $row['ScheduleDate'] == date('Y-m-d')) ? ' time-based-task-active-date-processed' : '';
        $html .= ($row['ScheduleDate'] >= $activeDate && $row['ScheduleDate'] <= date('Y-m-d', strtotime($activeDate . ' +4 days'))) ? ' time-based-task-four-day-period' : '';
        $html .= "\">";
        $html .= "<td style='width:120px;text-align:center;'>";
        $html .= "<img src='pictures/assetpicture.png' height='60px' width='60px' style='margin: 10px 10px 10px 10px'>";
        $html .= "</td>";
        $html .= "<td>";
        $html .= $row['AssetName'] . '** SN:' . $row['AssetSN'] . '<br>'; // Display Asset Name and Asset SN
        $html .= $row['TaskName'] . '<br>'; // Display Task Name
        $html .= $row['ScheduleType'] . ' - at '; // Display Schedule Type

        if ($row["ScheduleType"] == 'By Date') {
            $html .= $row["ScheduleDate"];
        } elseif ($row["ScheduleType"] == 'By Mileage') {
            $html .= $row["ScheduleKilometer"] . ' kilometer';
        }
        
        $html .= "</td>";
        $html .= "<td style='width:120px;text-align:center;'>";
        if ($row["TaskDone"] == 1) {
            $html .= '<input type="checkbox" id="checkbox-options" checked disabled>';
        } elseif ($row["TaskDone"] == 0) {
            $html .= '<input type="checkbox" id="checkbox-options" disabled>';
        }
        
        $html .= "</td>";
        $html .= "</tr>";

    }
} else {
    // No results found
    $html = "<tr><td colspan='3'>No assets found.</td></tr>";
}

// Send the cell count in a custom header
header('X-Cell-Count: ' . $cellCount);
echo $html;

// Close database connection
$conn->close();
?>
