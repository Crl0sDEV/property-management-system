<?php
// getUsedColors.php
include ('connection.php');

$query = "SELECT unit_color FROM tenant"; // Adjust 'tenants' to your table name
$result = mysqli_query($conn, $query);

$usedColors = [];
while ($row = mysqli_fetch_assoc($result)) {
    $usedColors[] = $row['unit_color'];
}

echo json_encode($usedColors);
?>