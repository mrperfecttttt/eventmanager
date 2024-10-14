<?php
session_start();
include 'db_connect.php';  // Database connection

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Protect against SQL injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query to get user data based on the entered username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Check if the entered password matches the stored password
        if ($password === $user['password']) {
            // Store user information in the session
            $_SESSION['username'] = $user['username'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['db_name'] = $user['db_name'];  // If user has a dedicated database

            // Redirect to the dashboard or any other page after login
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid password
            $error = "Incorrect password.";
        }
    } else {
        // User not found
        $error = "No user found with that username.";
    }
}
?>
