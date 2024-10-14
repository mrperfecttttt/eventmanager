<?php
// Start the session
// session_start();

// Include the database connection file
require 'db_connect.php'; // Include your MySQLi connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple validation
    if (empty($username) || empty($password)) {
        echo 'Username and password are required.';
        exit;
    }

    // Prepare and bind
    if ($stmt = $conn->prepare("SELECT password FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $username); // "s" indicates the type is string
        $stmt->execute();
        $stmt->store_result();

        // Check if the username exists
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($stored_password);
            $stmt->fetch();

            // Compare the plaintext passwords
            if ($password === $stored_password) {
                // Store user information in session
                $_SESSION['username'] = $username;

                // Redirect to the dashboard or another page
                header('Location: dashboard.php'); // Replace with your dashboard page
                exit;
            } else {
                echo 'Invalid username or password.';
            }
        } else {
            echo 'Invalid username or password.';
        }

        $stmt->close(); // Close the statement
    } else {
        echo 'Database error: ' . $conn->error; // Display any database error
    }
}
else {
    echo 'woii';
}

// Close the database connection
$conn->close();
?>
