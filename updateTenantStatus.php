<?php
include 'connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['name']) && isset($data['status'])) {
    $name = $data['name'];
    $status = $data['status'];

    $query = "UPDATE tenant SET status = ? WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $status, $name);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update status."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid input."]);
}

$conn->close();
?>
