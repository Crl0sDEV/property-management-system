<?php
include 'connection.php';
header('Content-Type: application/json');

$sql = "SELECT name, payment_amount, payment_status, id FROM tenant";
$result = $conn->query($sql);

$tenants = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tenants[] = [
            'name' => $row['name'],
            'amount' => $row['payment_amount'],
            'status' => $row['payment_status'],
            'id' => $row['id']
        ];
    }
}

echo json_encode($tenants);
$conn->close();
?>
