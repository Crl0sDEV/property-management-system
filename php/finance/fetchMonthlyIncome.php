<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include('connection.php');

$query = "SELECT tenant_name, unit_color, amount FROM payment_history WHERE status = 'paid'";
$result = mysqli_query($conn, $query);

$incomeData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $incomeData[] = $row;
}
echo json_encode($incomeData);
$conn->close();
?>
