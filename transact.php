<?php
include 'connection.php';
header('Content-Type: application/json');

$sql = "SELECT t.name, t.payment_amount, t.payment_status, t.id, 
               p.payment_date, p.amount AS payment_history_amount, p.status AS payment_history_status
        FROM tenant t
        LEFT JOIN payment_history p ON t.id = p.tenant_id";

$result = $conn->query($sql);

$tenants = [];

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $tenantId = $row['id'];
        
        if (!isset($tenants[$tenantId])) {
            $tenants[$tenantId] = [
                'name' => $row['name'],
                'amount' => $row['payment_amount'],
                'status' => $row['payment_status'],
                'id' => $tenantId,
                'payment_history' => []
            ];
        }

        if ($row['payment_date']) {
            $tenants[$tenantId]['payment_history'][] = [
                'date' => $row['payment_date'],
                'amount' => $row['payment_history_amount'],
                'status' => $row['payment_history_status']
            ];
        }
    }
}

$tenantArray = array_values($tenants);

echo json_encode($tenantArray);
$conn->close();
?>
