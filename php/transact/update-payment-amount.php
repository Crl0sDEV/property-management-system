<?php
include 'connection.php';
header('Content-Type: application/json');

$tenant_id = $_POST['tenant_id'];
$new_amount = $_POST['new_amount'];
$new_status = $_POST['new_status'];

$tenantSQL = "SELECT name, unit_color FROM tenant WHERE id = ?";
$stmt = $conn->prepare($tenantSQL);
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    
    $tenant = $result->fetch_assoc();
    $tenant_name = $tenant['name'];
    $unit_color = $tenant['unit_color'];

    $updateTenantSQL = "UPDATE tenant SET payment_amount = ?, payment_status = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($updateTenantSQL);
    $stmtUpdate->bind_param("dsi", $new_amount, $new_status, $tenant_id);

    if ($stmtUpdate->execute()) {
        
        $insertHistorySQL = "INSERT INTO payment_history (tenant_id, tenant_name, unit_color, payment_date, amount, status) 
                             VALUES (?, ?, ?, NOW(), ?, ?)";
        $stmtHistory = $conn->prepare($insertHistorySQL);
        $stmtHistory->bind_param("issds", $tenant_id, $tenant_name, $unit_color, $new_amount, $new_status);

        if ($stmtHistory->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to insert into payment history']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update tenant payment']);
    }

    $stmtUpdate->close();
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Tenant not found']);
}

$conn->close();
?>
