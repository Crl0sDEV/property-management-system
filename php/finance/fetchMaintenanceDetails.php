<?php
// fetchMaintenanceDetails.php

include ('connection.php'); // Include your database connection file

header('Content-Type: application/json');

// Fetch data from the `admin_charge_log` table
$query = "SELECT * FROM admin_charge_log";
$result = $conn->query($query);

$maintenanceData = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $maintenanceData[] = $row;
    }
}

// Return the data as JSON
echo json_encode($maintenanceData);
?>
