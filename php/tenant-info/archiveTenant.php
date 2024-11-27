<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header('Content-Type: application/json');


include('connection.php');


ob_start();

$response = [];

if ($conn->connect_error) {
    $response = ['error' => 'Database connection failed: ' . $conn->connect_error];
    echo json_encode($response);
    ob_end_flush();
    exit;
}

if (isset($_GET['archive_id'])) {
    $archive_id = $_GET['archive_id'];

    $getTenantSQL = "SELECT * FROM tenant WHERE id = ?";
    $stmt = $conn->prepare($getTenantSQL);

    if (!$stmt) {
        $response = ['error' => 'Failed to prepare SELECT query: ' . $conn->error];
        echo json_encode($response);
        ob_end_flush();
        exit;
    }

    $stmt->bind_param("i", $archive_id);
    $stmt->execute();
    $tenantResult = $stmt->get_result();

    if ($tenantResult->num_rows > 0) {
        $tenantData = $tenantResult->fetch_assoc();

        $insertArchiveSQL = "INSERT INTO archived_tenant 
            (name, date, birthday, birthplace, nationality, civil_status, previous_address, province, occupation, address_of_workplace, phone_number, email_address, emergency_contact_number, spouse_name, spouse_occupation, spouse_workplace_address, tenant_phone_number, number_of_tenants, unit_color, id, start_date, end_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertArchiveSQL);

        if (!$insertStmt) {
            $response = ['error' => 'Failed to prepare INSERT query: ' . $conn->error];
            echo json_encode($response);
            ob_end_flush();
            exit;
        }

        
$name = $tenantData['name'] ?? '';
$date = $tenantData['date'] ?? '';
$birthday = $tenantData['birthday'] ?? '';
$birthplace = $tenantData['birthplace'] ?? '';
$nationality = $tenantData['nationality'] ?? '';
$civil_status = $tenantData['civil_status'] ?? '';
$previous_address = $tenantData['previous_address'] ?? '';
$province = $tenantData['province'] ?? '';
$occupation = $tenantData['occupation'] ?? '';
$address_of_workplace = $tenantData['address_of_workplace'] ?? '';
$phone_number = $tenantData['phone_number'] ?? '';
$email_address = $tenantData['email_address'] ?? '';
$emergency_contact_number = $tenantData['emergency_contact_number'] ?? '';
$spouse_name = $tenantData['spouse_name'] ?? '';
$spouse_occupation = $tenantData['spouse_occupation'] ?? '';
$spouse_workplace_address = $tenantData['spouse_workplace_address'] ?? '';
$tenant_phone_number = $tenantData['tenant_phone_number'] ?? '';
$number_of_tenants = $tenantData['number_of_tenants'] ?? '';
$unit_color = $tenantData['unit_color'] ?? '';
$id = $tenantData['id'];
$start_date = $tenantData['start_date'] ?? '';
$end_date = $tenantData['end_date'] ?? '';


$insertStmt->bind_param(
    "ssssssssssssssssssssss",
    $name,
    $date,
    $birthday,
    $birthplace,
    $nationality,
    $civil_status,
    $previous_address,
    $province,
    $occupation,
    $address_of_workplace,
    $phone_number,
    $email_address,
    $emergency_contact_number,
    $spouse_name,
    $spouse_occupation,
    $spouse_workplace_address,
    $tenant_phone_number,
    $number_of_tenants,
    $unit_color,
    $id,
    $start_date,
    $end_date
);

        if ($insertStmt->execute()) {
            $deleteSQL = "DELETE FROM tenant WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSQL);

            if (!$deleteStmt) {
                $response = ['error' => 'Failed to prepare DELETE query: ' . $conn->error];
                echo json_encode($response);
                ob_end_flush();
                exit;
            }

            $deleteStmt->bind_param("i", $archive_id);
            $deleteStmt->execute();

            $response = ['success' => true, 'tenant' => $tenantData];
        } else {
            $response = ['error' => 'Failed to archive tenant: ' . $insertStmt->error];
        }
    } else {
        $response = ['error' => 'Tenant not found'];
    }

    $stmt->close();
} else {
    $response = ['error' => 'Invalid request: archive_id is missing'];
}

echo json_encode($response);
ob_end_flush();
$conn->close();
?>
