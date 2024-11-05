<?php
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? null;
$unit_color = $data['unit_color'] ?? null;
$damage_description = $data['damage_description'] ?? '';
$charge_amount = $data['charge_amount'] ?? 0;

if ($name && $unit_color) {
    $sql = "UPDATE tenant SET damage_description = ?, charge_amount = ? WHERE name = ? AND unit_color = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $damage_description, $charge_amount, $name, $unit_color);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Charge updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating charge."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data."]);
}

$conn->close();
?>
