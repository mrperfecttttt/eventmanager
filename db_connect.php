<?php
// Start the session if it hasn't been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection details
$servername = "209.97.172.153"; 
// $servername = "localhost"; 
$username = "admin"; 
// $username = "mrperfectt";
$password = "P@55w0rd"; 

// Determine which database to use
if (isset($_SESSION['db_name'])) {
    $database = $_SESSION['db_name']; // Use the database name from the session
} else {
    $database = "creds"; // Use the default creds database
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
