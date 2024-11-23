<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
include ('connection.php'); // Update with your database connection file

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];

if ($id && $start_date && $end_date) {
    $query = "UPDATE tenant SET start_date = ?, end_date = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $start_date, $end_date, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid data"]);
}
$conn->close();
?>
