<?php
header('Content-Type: application/json');
include('connection.php');

$query = "SELECT name, unit_color, damage_description, charge_amount FROM tenant";
$result = mysqli_query($conn, $query);

$rooms = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rooms[] = $row;
}

echo json_encode($rooms);
?>
