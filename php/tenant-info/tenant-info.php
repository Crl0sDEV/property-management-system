<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include ('connection.php');


$currentTenants = [];
$currentQuery = "SELECT * FROM tenant";
$currentResult = $conn->query($currentQuery);
if ($currentResult && $currentResult->num_rows > 0) {
    while ($row = $currentResult->fetch_assoc()) {
        $currentTenants[] = $row;
    }
}


$archivedTenants = [];
$archivedQuery = "SELECT * FROM archived_tenant";
$archivedResult = $conn->query($archivedQuery);
if ($archivedResult && $archivedResult->num_rows > 0) {
    while ($row = $archivedResult->fetch_assoc()) {
        $archivedTenants[] = $row;
    }
}


if (isset($_GET['unarchive_id'])) {
    $unarchive_id = $_GET['unarchive_id'];
    $query = "INSERT INTO tenant (name, date, birthday, birthplace, nationality, civil_status, previous_address, province, occupation, address_of_workplace, phone_number, email_address, emergency_contact_number, spouse_name, spouse_occupation, spouse_workplace_address, tenant_phone_number, number_of_tenants, unit_color, id, start_date, end_date) 
              SELECT name, date, birthday, birthplace, nationality, civil_status, previous_address, province, occupation, address_of_workplace, phone_number, email_address, emergency_contact_number, spouse_name, spouse_occupation, spouse_workplace_address, tenant_phone_number, number_of_tenants, unit_color, id, start_date, end_date
              FROM archived_tenant WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $unarchive_id);

    if ($stmt->execute()) {
        $deleteQuery = "DELETE FROM archived_tenant WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $unarchive_id);
        $deleteStmt->execute();
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Failed to unarchive tenant: " . $stmt->error]);
    }
    $stmt->close();
    exit;
}


echo json_encode(['currentTenants' => $currentTenants, 'archivedTenants' => $archivedTenants]);

$conn->close();
?>
