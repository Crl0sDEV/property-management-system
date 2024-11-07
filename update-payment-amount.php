<?php
include 'connection.php';
header('Content-Type: application/json');

$tenant_id = $_POST['tenant_id'];
$new_amount = $_POST['new_amount'];
$new_status = $_POST['new_status'];

$updateTenantSQL = "UPDATE tenant SET payment_amount = ?, payment_status = ? WHERE id = ?";
$stmt = $conn->prepare($updateTenantSQL);
$stmt->bind_param("dsi", $new_amount, $new_status, $tenant_id);

if ($stmt->execute()) {
    $insertHistorySQL = "INSERT INTO payment_history (tenant_id, payment_date, amount, status) VALUES (?, NOW(), ?, ?)";
    $stmtHistory = $conn->prepare($insertHistorySQL);
    $stmtHistory->bind_param("ids", $tenant_id, $new_amount, $new_status);

    if ($stmtHistory->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert into payment history']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update tenant payment']);
}

$stmt->close();
$conn->close();
?>
