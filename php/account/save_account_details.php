<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);
    $email = trim($_POST['email']);

    $query = "UPDATE users SET name = ?, role = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $role, $email, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Account details updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update account details."]);
}

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
