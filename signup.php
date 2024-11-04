<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    if ($password === $confirmPassword) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)")) {
            $stmt->bind_param("ss", $username, $hashedPassword);
            if ($stmt->execute()) {
                header("Location: login.html?message=Registration+successful&type=success");
                exit();
            } else {
                header("Location: login.html?message=Error:+Could+not+register+user&type=error");
                exit();
            }
            $stmt->close();
        } else {
            die("Failed to prepare SQL statement.");
        }
    } else {
        header("Location: login.html?message=Passwords+do+not+match&type=error");
        exit();
    }
}
$conn->close();
exit();
?>
