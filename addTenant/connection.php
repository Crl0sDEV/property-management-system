<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'property_db';

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection is successful
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
