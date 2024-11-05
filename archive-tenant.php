<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Insert tenant into `archived_tenants` table
        $archiveQuery = "INSERT INTO archived_tenants (id, name, unit_color, start_date, end_date)
                         SELECT id, name, unit_color, start_date, end_date FROM tenants WHERE id = ?";
        $archiveStmt = $conn->prepare($archiveQuery);
        $archiveStmt->bind_param("i", $id);
        $archiveStmt->execute();

        // Delete tenant from `tenants` table
        $deleteQuery = "DELETE FROM tenants WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);
        $deleteStmt->execute();

        // Commit transaction
        $conn->commit();

        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    $archiveStmt->close();
    $deleteStmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid tenant ID."]);
}
?>
