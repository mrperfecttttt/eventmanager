<?php
$servername = "209.97.172.153"; 
$username = "admin"; 
$password = "P@55w0rd"; 
$database = "tunang"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
