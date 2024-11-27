<?php

include ('connection.php'); 

header('Content-Type: application/json');

$query = "SELECT * FROM admin_charge_log";
$result = $conn->query($query);

$maintenanceData = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $maintenanceData[] = $row;
    }
}

echo json_encode($maintenanceData);
?>
