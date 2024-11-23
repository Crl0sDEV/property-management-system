<?php
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? null;
$unit_color = $data['unit_color'] ?? null;
$damage_description = $data['damage_description'] ?? '';
$charge_amount = $data['charge_amount'] ?? 0;

if ($name && $unit_color) {
    $sql = "INSERT INTO admin_charge_log (tenant_name, unit_color, damage_description, charge_amount, charge_date) 
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $unit_color, $damage_description, $charge_amount);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Charge applied to admin successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error applying charge to admin."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data."]);
}

$conn->close();
?>
