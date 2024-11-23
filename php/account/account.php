<?php
include('connection.php');

session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, role, email FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    echo json_encode($user_data);
} else {
    echo json_encode(array("error" => "Could not fetch user data."));
}
?>
