<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenantId = $_POST['tenant_id'];
    $newAmount = $_POST['new_amount'];
    $newStatus = $_POST['new_status'];

    if (empty($tenantId) || empty($newAmount) || empty($newStatus)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE tenant SET payment_amount = ?, payment_status = ? WHERE id = ?");
    $stmt->bind_param("dsi", $newAmount, $newStatus, $tenantId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update payment details.']);
    }

    $stmt->close();
    $conn->close();
}
?>
