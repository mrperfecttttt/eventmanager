<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1 class="afacad-flux-normal">E-Manager</h1>
        </div>
        <form action="login_pro.php" method="POST">
            <div class="input-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
            <p class="signup">Don't have an account? Please contact the developer <?php echo $_SESSION['db_name']?></p>
        </form>
    </div>
</body>
</html>
