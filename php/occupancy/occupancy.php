<?php
header('Content-Type: application/json');
include ('connection.php');

$query = "SELECT name, unit_color, status FROM tenant";
$result = mysqli_query($conn, $query);

$tenants = array();
while ($row = mysqli_fetch_assoc($result)) {
    $tenants[] = $row;
}

// Update occupancy status in the database
$predefinedUnitColors = [
    "Red", "Angel Blush", "Light Blue", "Blue Green", "Dark Blue",
    "Gold", "Orange", "Green Nile", "Pink", "Yellow Ribbon",
    "Light Green", "Orcher", "Blue", "Light Pink", "Light Yellow"
];

foreach ($predefinedUnitColors as $color) {
    $isOccupied = array_filter($tenants, fn($tenant) => $tenant['unit_color'] === $color);
    $status = $isOccupied ? 'Occupied' : 'Available';

    $stmt = $conn->prepare("UPDATE tenant SET status = ? WHERE unit_color = ?");
    $stmt->bind_param("ss", $status, $color);
    $stmt->execute();
}

echo json_encode($tenants);

$conn->close();
?>
