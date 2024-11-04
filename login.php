<?php
session_start();
include('connection.php'); // Include the connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($stmt = $conn->prepare("SELECT * FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                // Redirect to dashboard if login is successful
                header("Location: login.html?login_success=true");
                exit();
            } else {
                // Redirect back to login with an error message
                header("Location: login.html?message=Incorrect+password&type=error");
                exit();
            }
        } else {
            // Redirect back to login with a "User not found" message
            header("Location: login.html?message=User+not+found&type=error");
            exit();
        }
        $stmt->close();
    } else {
        die("Failed to prepare SQL statement.");
    }
}
$conn->close();
exit();
?>
