<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connection.php';

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

$sql = "SELECT name, date, birthday, birthplace, nationality, civil_status, previous_address, province, occupation, address_of_workplace, phone_number, email_address, emergency_contact_number, spouse_name, spouse_occupation, spouse_workplace_address, tenant_phone_number, number_of_tenants, unit_color, id FROM tenant";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit;
}

$tenant = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tenant[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($tenant);
$conn->close();
?>
