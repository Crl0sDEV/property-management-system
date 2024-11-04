<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenantId = $_POST['id'];

    if (!empty($tenantId)) {
        $sql = "UPDATE tenant SET archived = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $tenantId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo json_encode(["success" => true, "message" => "Tenant archived successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to archive tenant."]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Database error: unable to prepare statement."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No tenant ID provided."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>
