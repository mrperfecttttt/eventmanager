<?php
session_start();  // Start session (if not already started)

// Static connection values (server, username, and password remain the same)
$servername = "209.97.172.153"; 
$username = "admin"; 
$password = "P@55w0rd";

// Check if the user is logged in and if their specific database is set in the session
if (isset($_SESSION['database'])) {
    // If the session exists, use the user's specific database
    $database = $_SESSION['database'];
} else {
    // If no session, use the default database
    $database = "credentials";  // The default database for authentication and general data
}

// Create connection to the determined database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
