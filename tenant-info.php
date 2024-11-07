<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

include 'connection.php';

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

if (isset($_GET['archive_id'])) {
    $archive_id = $_GET['archive_id'];

    $getTenantSQL = "SELECT * FROM tenant WHERE id = ?";
    $stmt = $conn->prepare($getTenantSQL);
    $stmt->bind_param("i", $archive_id);
    $stmt->execute();
    $tenantResult = $stmt->get_result();

    if ($tenantResult->num_rows > 0) {
        $tenantData = $tenantResult->fetch_assoc();

        $insertArchiveSQL = "INSERT INTO archived_tenant (name, date, birthday, birthplace, nationality, civil_status, previous_address, province, occupation, address_of_workplace, phone_number, email_address, emergency_contact_number, spouse_name, spouse_occupation, spouse_workplace_address, tenant_phone_number, number_of_tenants, unit_color, id)
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertArchiveSQL);
        $stmt->bind_param(
            "ssssssssssssssssssss",
            $tenantData['name'],
            $tenantData['date'],
            $tenantData['birthday'],
            $tenantData['birthplace'],
            $tenantData['nationality'],
            $tenantData['civil_status'],
            $tenantData['previous_address'],
            $tenantData['province'],
            $tenantData['occupation'],
            $tenantData['address_of_workplace'],
            $tenantData['phone_number'],
            $tenantData['email_address'],
            $tenantData['emergency_contact_number'],
            $tenantData['spouse_name'],
            $tenantData['spouse_occupation'],
            $tenantData['spouse_workplace_address'],
            $tenantData['tenant_phone_number'],
            $tenantData['number_of_tenants'],
            $tenantData['unit_color'],
            $tenantData['id']
        );

        if ($stmt->execute()) {
            $deleteSQL = "DELETE FROM tenant WHERE id = ?";
            $stmt = $conn->prepare($deleteSQL);
            $stmt->bind_param("i", $archive_id);
            $stmt->execute();

            echo json_encode(['success' => 'Tenant archived successfully', 'tenant' => $tenantData]);
        } else {
            echo json_encode(['error' => 'Failed to archive tenant: ' . $stmt->error]);
        }
    } else {
        echo json_encode(['error' => 'Tenant not found']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

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

echo json_encode(['currentTenants' => $currentTenants, 'archivedTenants' => $archivedTenants]);

$conn->close();
?>
