<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include('connection.php');

$sql = "SELECT tenant_name, unit_color, charge_amount, damage_description, change_date FROM charge_history_log";
$result = $conn->query($sql);

$chargeHistory = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chargeHistory[] = $row;
    }
}

echo json_encode($chargeHistory);
$conn->close();
?>
