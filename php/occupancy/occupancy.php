<?php
header('Content-Type: application/json');
include ('connection.php');

$query = "SELECT name, unit_color, status FROM tenant";
$result = mysqli_query($conn, $query);

$tenants = array();
while ($row = mysqli_fetch_assoc($result)) {
    $tenants[] = $row;
}

echo json_encode($tenants);
?>
