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

        // Verify the password (assuming passwords are hashed using password_hash())
        if (password_verify($password, $user['password'])) {
            // Store user information in the session
            $_SESSION['username'] = $user['username'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['database'] = $user['database'];  // If user has a dedicated database

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Error</title>
</head>
<body>
    <div class="container">
        <h1>Login Error</h1>
        <p><?php echo isset($error) ? $error : ''; ?></p>
        <a href="index.php">Go back to login</a>
    </div>
</body>
</html>
