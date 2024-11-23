<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare SQL statement to select user data based on the username
    if ($stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Store the user ID in the session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $username; // Optional, if you still need the username
                
                // Redirect to account page or other destination
                header("Location: login.html?login_success=true");
                exit();
            } else {
                // Incorrect password
                header("Location: login.html?message=Incorrect+password&type=error");
                exit();
            }
        } else {
            // User not found
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
