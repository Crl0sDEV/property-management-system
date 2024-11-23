<?php
header('Content-Type: application/json');
include 'connection.php'; // Replace with your connection file

// Query to count active and archived tenants
$query = "SELECT 
    (SELECT COUNT(*) FROM tenant) AS active, 
    (SELECT COUNT(*) FROM archived_tenant) AS archived";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

echo json_encode(['tenantStatus' => $data]);
?>
