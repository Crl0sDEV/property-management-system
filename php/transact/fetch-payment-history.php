<?php
include('connection.php');

if (isset($_GET['tenant_id'])) {
    $tenant_id = $_GET['tenant_id'];

    $query = "SELECT amount, status, payment_date FROM payment_history WHERE tenant_id = ? ORDER BY payment_date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tenant_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }

    echo json_encode($history);
}
?>
