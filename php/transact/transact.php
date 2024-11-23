<?php
header('Content-Type: application/json');
include ('connection.php');

$sql = "SELECT t.name, t.payment_amount, t.payment_status, t.id, t.unit_color, 
               p.payment_date, p.amount AS payment_history_amount, p.status AS payment_history_status
        FROM tenant t
        LEFT JOIN payment_history p ON t.id = p.tenant_id";

$result = $conn->query($sql);

$tenants = [];

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $tenantId = $row['id'];
        
        // Only initialize tenant array if it's not already set
        if (!isset($tenants[$tenantId])) {
            $tenants[$tenantId] = [
                'name' => $row['name'],
                'amount' => $row['payment_amount'],
                'status' => $row['payment_status'],
                'id' => $tenantId,
                'payment_history' => [],
                // We store unit_color in the backend, but don't pass it to the frontend
                'unit_color' => $row['unit_color']
            ];
        }

        // Add payment history if available
        if ($row['payment_date']) {
            $tenants[$tenantId]['payment_history'][] = [
                'date' => $row['payment_date'],
                'amount' => $row['payment_history_amount'],
                'status' => $row['payment_history_status']
            ];
        }
    }
}

// Convert to a simple array to remove tenant ID keys
$tenantArray = array_values($tenants);

// Return the data as JSON (without 'unit_color')
echo json_encode($tenantArray);

$conn->close();
?>
